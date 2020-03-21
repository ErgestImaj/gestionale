<template>
	<v-row>
		<v-overlay :value="loading">
			<v-progress-circular indeterminate size="64"></v-progress-circular>
		</v-overlay>
		<v-col cols="12" sm="6">
			<v-card class="mx-auto" v-if="noCategories">
				<p class="p-3">
					{{trans('form.doc_no_records')}}
				</p>
			</v-card>
			<v-card class="mx-auto" v-if="!noCategories">
				<v-toolbar color="primary" dark>
					<v-toolbar-title>{{trans('form.doc_cats')}}</v-toolbar-title>
				</v-toolbar>

				<v-list two-line>
					<v-list-item :key="item.title" v-for="item in categories">
						<template v-slot:default="{ active, toggle }">

							<v-list-item-content>
								<v-list-item-title v-text="item.name"></v-list-item-title>
								<v-list-item-subtitle class="text--primary">
									<span>{{ 'Creato da: ' + item.created_by }}</span>
									<span v-if="item.updated_by">{{ 'Modificato da: ' + item.updated_by }}</span>
								</v-list-item-subtitle>
							</v-list-item-content>

							<v-list-item-action class="d-flex flex-row justify-space-between align-center">
								<v-btn icon>
									<v-icon color="grey lighten-1" @click="openEdit(item)">mdi-pencil</v-icon>
								</v-btn>
								<v-btn icon class="delete-btn" :data-content="trans('messages.delete_record')"
											 :data-action="'/amministrazione/categories/'+item.hashid">
									<v-icon color="grey lighten-1">mdi-delete-outline</v-icon>
								</v-btn>
							</v-list-item-action>
						</template>
					</v-list-item>
				</v-list>
			</v-card>
		</v-col>

		<v-col cols="12" sm="6">
			<v-card class="mx-auto">
				<v-toolbar color="primary" dark>
					<v-toolbar-title>{{trans('form.doc_cat_add')}}</v-toolbar-title>
				</v-toolbar>

				<div class="p-4">
					<v-row>
						<v-col cols="12" sm="12">
							<v-text-field
								:label="trans('form.name')"
								:error-messages="errors.name ? errors.name[0] : []"
								outlined v-model="cat.name"
							></v-text-field>
						</v-col>
					</v-row>
					<v-row>
						<v-col cols="12" sm="12">
							<v-btn
								:loading="submiting"
								:disabled="submiting"
								color="primary"
								class="ma-0 white--text"
								@click="create"
							>
								{{trans('form.doc_cat_add_btn')}}
							</v-btn>
						</v-col>
					</v-row>
				</div>
			</v-card>
		</v-col>

		<v-dialog v-model="editDialog" persistent max-width="600px">
			<v-card v-if="edit">
				<v-card-title>
					<span class="headline">{{trans('form.doc_cat_edit')}}</span>
				</v-card-title>
				<v-card-text>
					<v-container>
						<v-form>
							<v-row>
								<v-col cols="12" sm="12">
									<v-text-field
										:label="trans('form.name')"
										:error-messages="errorsmodify.name ? errorsmodify.name[0] : []"
										outlined v-model="edit.name"
									></v-text-field>
								</v-col>
							</v-row>
						</v-form>
					</v-container>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="grey darken-1" text @click="closeEdit()">{{trans('form.doc_close')}}</v-btn>
					<v-btn color="primary darken-1" :data-name="edit.name" @click="updateCategory(edit.hashid)">
						{{trans('form.save')}}
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-row>
</template>

<script>
    export default {
        data() {
            return {
                categories: [],
                cat: {},
                errors: {},
                errorsmodify: {},
                submiting: false,
                noCategories: false,
                loading: true,
                editDialog: false,
                edit: null
            }
        },
        mounted() {
            this.getCategories();
        },
        methods: {
            openEdit(record) {
                this.edit = record;
                this.editDialog = true;
            },
            closeEdit() {
                this.editDialog = false
            },
						getCategories() {
                this.loading = true;
                axios.get(`/amministrazione/api/categories`)
                    .then(response => {
                        this.categories = response.data.data;
                        this.noCategories = response.data.length === 0;
                    })
										.finally(() => {
                        this.loading = false;
										})
								;
						},
            create() {
                if (!this.submiting) {
                    this.submiting = true;
                    axios.post(`/amministrazione/api/categories/create`, this.cat)
                        .then(response => {
                            swal("Good job!", response.data.message, "success");
                            this.cat = {};
                            this.getCategories();
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        }).finally(() => {
                        		this.submiting = false;
												})
                }
            },
            updateCategory(record) {
                if (!this.submiting) {
                    this.submiting = true;
                    axios.patch(`/amministrazione/api/categories/update/${record}`, this.edit)
                        .then(response => {
                            swal("Good job!", response.data.message, "success");
                            this.cat = {};
                            this.getCategories();
                            this.editDialog = false;
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        }).finally(() => {
                        	this.submiting = false;
                    })
                }
            }
        }
    }
</script>

<style>

</style>
