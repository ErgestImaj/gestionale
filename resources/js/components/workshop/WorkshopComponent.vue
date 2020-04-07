<template>
	<v-form>
		<v-card outlined flat class="mb-4">
			<v-card-text class="pa-5">
				<v-menu
					content-class="gdate"
					v-model="datePicker1"
					:close-on-content-click="false"
					transition="scale-transition"
					offset-y
					min-width="290px"
					attach
				>
					<template v-slot:activator="{ on }">
						<v-text-field
							v-model="momentDate"
							:label="trans('form.data')"
							readonly
							outlined
							v-on="on"
							:error-messages="errors.date ? errors.date[0] : []"
						></v-text-field>
					</template>
					<v-date-picker v-model="workshop.date" @input="datePicker1 = false"></v-date-picker>
				</v-menu>

				<v-row>
					<v-col cols="12" md="4">
						<p style="margin-bottom: 5px;">{{trans('form.preferenze')}}</p>
						<v-radio-group
							v-model="workshop.when"
							:mandatory="false"
							:error-messages="errors.when ? errors.when[0] : []"
							row
							dense
						>
							<v-radio :label="trans('form.morning')" value="0"></v-radio>
							<v-radio :label="trans('form.afternoon')" value="1"></v-radio>
						</v-radio-group>
					</v-col>
					<v-col cols="12" md="8">
						<v-combobox
							chips
							:deletable-chips="true"
							outlined label="Tipo"
							v-model="workshop.types"
							:items="types"
							multiple
							item-text="name"
							item-value="id"
							attach
							:error-messages="errors.types ? errors.types[0] : []"
						></v-combobox>
					</v-col>
					<v-col cols="12" >
						<v-combobox
							chips
							:deletable-chips="true"
							v-model="workshop.partecipants"
							:items="roles"
							outlined
							multiple
							item-text="name"
							item-value="id"
							:error-messages="errors.partecipants ? errors.partecipants[0] : []"
							attach
							:label="trans('form.target')"
						></v-combobox>
					</v-col>
				</v-row>

				<label>{{trans('form.description')}}</label>
				<tiptap-vuetify v-model="workshop.note" :extensions="extensions" />

				<div class="invalid-feedback d-block" v-if="errors.note">{{errors.note[0]}}</div>

				<v-btn
					:loading="submiting"
					:disabled="submiting"
					color="primary"
					class="mt-4 ml-0 white--text"
					@click="create"
				>{{trans('form.save')}}</v-btn>
			</v-card-text>
		</v-card>

		<v-card>
			<v-card-title>
				Lista workshops
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="workshops"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.data="{ item }">
					<div v-html="item.data"></div>
				</template>
				<template v-slot:item.description="{ item }">
					<div v-html="item.description.replace(/<[^>]*>?/gm, '')"></div>
				</template>
				<template v-slot:item.actions="{ item }">
					<a icon :href="item.editlink">
						<v-icon>mdi-pencil</v-icon>
					</a>
					<a
						icon
						class="delete-btn"
						:data-content="item.remMessage"
						:data-action="item.remlink"
					>
						<v-icon>mdi-delete</v-icon>
					</a>
				</template>
			</v-data-table>
		</v-card>
	</v-form>
</template>

<script>
    import Datepicker from "vuejs-datepicker";
    import {
        Blockquote,
        Bold,
        BulletList,
        Code,
        HardBreak,
        Heading,
        History,
        HorizontalRule,
        Italic,
        Link,
        ListItem,
        OrderedList,
        Paragraph,
        Strike,
        TiptapVuetify,
        Underline
    } from "tiptap-vuetify";
    import moment from "moment";

    export default {
        dependencies: 'globalService',
        data() {
            return {
                footerProps: null,
                roles: [],
                workshops: [],
                workshop: {
                    date: "",
                    note: `<p></p>`
                },
							  types:[],
                datePicker1: false,
                errors: {},
                submiting: false,
                extensions: [
                    History,
                    Blockquote,
                    Link,
                    Underline,
                    Strike,
                    Italic,
                    ListItem,
                    BulletList,
                    OrderedList,
                    [
                        Heading,
                        {
                            options: {
                                levels: [1, 2, 3]
                            }
                        }
                    ],
                    Bold,
                    Code,
                    HorizontalRule,
                    Paragraph,
                    HardBreak
                ],
                search: "",
                headers: [
                    { text: "#", value: "id" },
                    { text: this.trans("form.data"), value: "date" },
                    { text: this.trans("form.description"), value: "description" },
                    { text: this.trans("form.participants"), value: "participants" },
                    { text: 'Tipo', value: "types" },
                    { text: this.trans("form.created_by"), value: "created_by" },
                    { text: this.trans("form.updated_by"), value: "updated_by" },
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ],
                loading: true
            };
        },
        components: {
            TiptapVuetify
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.loading = true;
            this.getRoles();
            this.getWorkshops();
			     	this.getUserTypes();
        },
        methods: {
            getWorkshops() {
                axios.get(`/amministrazione/api/getworkshops`).then(response => {
                    this.workshops = response.data;
                    this.loading = false;
                });
            },
            getRoles() {
                axios
                    .get(`/amministrazione/api/getroles`)
                    .then(response => {
                        this.roles = response.data;
                    })
                    .catch(error => {});
            },

            create() {
                if (!this.submiting) {
                    this.submiting = true;
                    axios
                        .post(`/amministrazione/workshop`, this.workshop)
                        .then(response => {
                            this.submiting = false;
                            if (response.data.status == "success") {
                                swal("Good job!", response.data.msg, "success");
                               this.getWorkshops()
                            } else if (response.data.status == "error") {
                                swal("Woops!", response.data.msg, "error");
                                this.workshop = {};
                            }
                        })
                        .catch(error => {
                            this.submiting = false;
                            this.errors = error.response.data.errors;
                        });
                }
            },
            moment: function() {
                return moment();
            }
        },
        beforeDestroy() {
            this.editor.destroy();
        },
        computed: {
            momentDate() {
                return this.workshop.date
                    ? moment(this.workshop.date).format("DD MMM YYYY")
                    : "";
            }
        }
    };
</script>
<style>
	#app.workshop .v-application--wrap {
		min-height: 0 !important;
	}
	#app.workshop .v-label {
		margin-bottom: 0;
	}
	.v-input--radio-group--row {
		margin-top: 0;
	}
	.v-select.v-select--chips:not(.v-text-field--single-line).v-text-field--box
	.v-select__selections,
	.v-select.v-select--chips:not(.v-text-field--single-line).v-text-field--enclosed
	.v-select__selections {
		min-height: 50px;
	}
	a[icon] {
		text-decoration: none !important;
	}
</style>
