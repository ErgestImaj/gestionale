<template>
	<div>
		<v-btn @click="addStrutura()" class="gadd">Add Strutura</v-btn>
		<v-card>
			<v-card-title>
				Struture - {{structureType | filterStructureType}}
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="struture"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.legal_name="{ item }">
					<div v-html="item.legal_name" class="gname"></div>
				</template>
				<template v-slot:item.state="{ item }">
					<v-icon>{{item.state == 1 ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
				</template>
				<template v-slot:item.actions="{ item }">
					<v-menu bottom left content-class="gactions">
						<template v-slot:activator="{ on }">
							<v-btn icon v-on="on">
								<v-icon>mdi-dots-vertical</v-icon>
							</v-btn>
						</template>

						<v-list dense>
							<template v-for="(m, i) in menuItems">
								<v-list-item
									class="update-btn" v-if="m.id == 5" :key="i"
									link :data-action="`/amministrazione/structure/${item.hashid}/status`">
									<v-list-item-icon>
										<v-icon>{{item.state   ? 'mdi-minus-circle-outline' : 'mdi-checkbox-marked-circle-outline' }}</v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ item.state ? m.title2 : m.title }}</v-list-item-title>
								</v-list-item>
								<v-list-item
									v-else-if="m.id == 6" :key="i"
									class="post-action"
									:data-content="trans('messages.send_reset_link_confirm')"
									:data-action="`/amministrazione/send-invitation-link/${item.owner.hashid}`"
									link
								>
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>
								<v-list-item v-else-if="m.id == 7" :key="i"
														 class="sender-email"
														 :data-action="`/amministrazione/send-email-to-single-user/${item.owner.hashid}`"
														 link
								>
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>
								<v-list-item v-else-if="m.id ==8" :key="i"
														 class="delete-btn"
														 :data-content="trans('messages.delete_record')"
														 :data-action="`/amministrazione/structure/${item.hashid}`"
														 link
								>
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>

								<v-list-item v-else :key="i" @click="menuClick(m.id, item)">
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>
							</template>
						</v-list>
					</v-menu>
				</template>
			</v-data-table>
		</v-card>
		<v-dialog v-model="editDialog" persistent max-width="600px">
			<v-card v-if="edit">
				<v-card-title>
					<span class="headline">{{'Cambia gerarchia'}}</span>
				</v-card-title>
				<v-card-text>
					<v-container>
						<v-form>
							<v-row>
								<v-col cols="12" sm="12">
									<v-radio-group v-model="structur.type">
										<v-radio
											v-for="n in types"
											:key="n.id"
											:label="n.value"
											:value="n.id"
										></v-radio>
									</v-radio-group>
								</v-col>
							</v-row>
						</v-form>
					</v-container>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="grey darken-1" text @click="closeEdit()">{{trans('form.doc_close')}}</v-btn>
					<v-btn color="primary darken-1"  @click="updateStructure(structur.hashid)">
						{{trans('form.save')}}
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
    export default {
        dependencies: 'globalService',
        props: ["structureType"],
        data() {
            return {
                footerProps: null,
                struture: [],
                search: "",
                editDialog: false,
                structur:{},
                headers: [
                    { text: "#", value: "id" },
                    { text: "Partita IVA", value: "piva" },
                    { text: "Ragione sociale", value: "legal_name" },
                    { text: "Codice", value: "code" },
                    { text: "Email", value: "email" },
                    { text: "Telefono", value: "phone" },
                    { text: "Provincia", value: "province.title" },
                    { text: "Stato", value: "state" },
                    { text: "actions", value: "actions", sortable: false, align: "right" }
                ],
                loading: true,
                menuItems: [
                    { id: 1, title: "Edit", icon: "mdi-pencil-outline" },
                    { id: 2, title: "View", icon: "mdi-eye-outline" },
                    { id: 3, title: "Add Discount", icon: "mdi-tag-plus" },
                    { id: 4, title: "Switch Account", icon: "mdi-account-convert" },
                    { id: 5, title: "Enable", title2: "Disable", icon: "" },
                    { id: 6, title: "Invia link di accesso", icon: "mdi-account-key-outline" },
                    { id: 7, title: "Invia Email", icon: "mdi-email-send-outline" },
                    { id: 8, title: "Delete Account", icon: "mdi-trash-can-outline" },
                    { id: 9, title: "Cambia Gerarchia", icon: "mdi-arrow-split-horizontal" }
                ],
                types:[
                    {id: 1, value: 'Partner'},
                    {id: 2, value: 'Master'},
                    {id: 3, value: 'Affiliati'},
                ],
            };
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getStructures();
        },
        methods: {
            getStructures() {
                axios
                    .get(`/amministrazione/api/struture/${this.structureType}`)
                    .then(response => {
                        this.struture = response.data;
                    })
                    .catch(error => {})
                    .finally(() => {
                        this.loading = false;
                    });
            },
            menuClick(id, item) {
                switch (id) {
                    case 1:
                        this.edit(item);
                        break;
                    case 2:
                        this.view(item);
                        break;
                    case 3:
                        this.addDiscount(item);
                        break;
                    case 4:
                        this.switchAccount(item);
                        break;
                    case 9:
                        this.openEdit(item);
                }
            },
            openEdit(record) {
                this.structur = record;
                this.editDialog = true;
            },
            closeEdit() {
                this.editDialog = false
                this.structur = null
            },
            updateStructure(record) {
                axios.patch(`/amministrazione/api/${record}/hirearcy/`, this.structur)
                    .then(response => {
                        this.editDialog = false
                        if (response.data.status === 'success') {
                            swal("Good job!", response.data.msg, "success");
                            setTimeout(function () {
                                location.reload();
                            }, 1500)
                        } else if (response.data.status === 'error') {
                            swal({
                                title: "Whoops!",
                                text: response.data.msg,
                                icon: "warning",
                                dangerMode: true,
                            });
                        }
                    })
                    .catch(error => {
                    })
            },
            edit(item) {
                let nUrl =
                    window.location.origin +
                    "/amministrazione/struture/" +
                    item.hashid +
                    "/edit";
                window.location.href = nUrl;
            },
            view(item) {
                let nUrl =
                    window.location.origin +
                    "/amministrazione/struture/" +
                    item.hashid +
                    "/view";
                window.location.href = nUrl;
            },
            addDiscount(item) {
                let nUrl =
                    window.location.origin +
                    "/amministrazione/struture/" +
                    item.hashid +
                    "/sconto";
                window.location.href = nUrl;
            },
            switchAccount(item) {
                let nUrl =
                    window.location.origin +
                    "/amministrazione/login-as-user/" +
                    item.owner.hashid;
                window.location.href = nUrl;
            },
            addStrutura() {
                let nUrl =
                    window.location.origin +
                    "/amministrazione/struture/" +
                    this.structureType +
                    "/create";
                window.location.href = nUrl;
            }
        },
        filters: {
            filterStructureType: function(value) {
                if (!value) return "";
                if (value == 1) return "Partner";
                if (value == 2) return "Master";
                if (value == 3) return "Affiliati";
                return value;
            }
        }
    };
</script>

<style>
	.v-data-table td,
	.v-data-table th {
		font-size: 12px;
		padding: 0 3px;
	}
	.v-data-table td:first-child,
	.v-data-table th:first-child {
		padding-left: 10px;
	}
	.v-data-table td:last-child,
	.v-data-table th:last-child {
		padding-right: 10px;
	}
	.gname {
		font-size: 12px;
		max-width: 220px;
	}
	.gactions .v-list-item {
		min-height: 33px;
	}
	button.gadd {
		position: relative;
		display: block;
		float: right;
		margin-top: -50px;
		margin-bottom: 10px;
	}
	.text-start .mdi-checkbox-marked-circle-outline {
		color: #66bb6a;
	}
	.text-start .mdi-minus-circle-outline {
		color: #ef5350;
	}
	.update-btn,
	.delete-btn,
	.post-action,
	.sender-email {
		color: rgba(0, 0, 0, 0.87) !important;
	}
	.v-list-item--dense .v-list-item__icon, .v-list--dense .v-list-item .v-list-item__icon {
		height: 24px;
		margin-top: 6px;
		margin-bottom: 6px;
		margin-right: 14px;
	}
</style>
