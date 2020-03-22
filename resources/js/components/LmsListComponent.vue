<template>
	<div>
		<v-btn @click="addLms()" class="gadd">{{ trans('form.add_content') }}</v-btn>
		<v-card>
			<v-card-title>
				Lista LMS
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="lmss"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.status="{ item }">
					<v-icon>{{ !!item.status ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
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
									class="update-btn" v-if="m.id == 3" :key="i"
									link :data-action="`/lms-content/status/${item.hashid}`">
									<v-list-item-icon>
										<v-icon>{{ !!item.status ? 'mdi-minus-circle-outline' : 'mdi-checkbox-marked-circle-outline' }}</v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ !!item.state ? m.title2 : m.title }}</v-list-item-title>
								</v-list-item>
								<v-list-item v-else-if="m.id == 4" :key="i" class="delete-btn" link
									:data-content="trans('messages.delete_record')"
									:data-action="`/lms-content/${item.hashid}`"
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
		<v-dialog v-model="editDialog" max-width="800px">
			<div v-if="editData" style="background: white">
				<v-btn class="ma-3 mb-0" @click="closeDialog()">Chiudi</v-btn>
				<add-lms
					:is-edit="true"
					:edit-content="editData"
				></add-lms>
			</div>
		</v-dialog>
	</div>
</template>

<script>
    export default {
        dependencies: 'globalService',
        data() {
            return {
                footerProps: null,
                search: '',
								loading: true,
                headers: [
                    { text: "#", value: "id" },
                    { text: this.trans("form.code_module"), value: "code" },
                    { text: this.trans("form.module"), value: "module" },
                    { text: this.trans("form.code"), value: "course" },
                    { text: this.trans("profile.status"), value: "status" },
                    { text: this.trans("form.created_by"), value: "created_by" },
                    { text: this.trans("form.updated_by"), value: "updated_by" },
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ],
                menuItems: [
                    { id: 1, title: "Edit", icon: "mdi-pencil-outline" },
                    { id: 2, title: "View", icon: "mdi-eye-outline" },
                    { id: 3, title: "Enable", title2: "Disable", icon: "" },
                    { id: 4, title: "Delete", icon: "mdi-trash-can-outline" }
                ],
								lmss: [],
								editData: null,
                editDialog: false,
						}
				},
				mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getLmss();
				},
				methods: {
            openDialog(item) {
                this.editData = item;
                this.editDialog = true;
            },
            closeDialog() {
                this.editData = null;
                this.editDialog = false;
            },
            getLmss() {
                axios.get(`/lms-content`).then(res => {
                    this.lmss = res.data.data;
                    this.loading = false;
                });
						},
						addLms() {
                let nUrl = window.location.origin + "/lms-content/create";
                window.location.href = nUrl;
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
                        // this.toggle(item);
                        break;
                    case 4:
                        // this.remove(item);
                        break;
                }
            },
						edit(item) {
                this.openDialog(item);
						},
						view(item) {
                let nUrl = window.location.origin + "/lms-content/" + item.hashid;
                window.location.href = nUrl;
						}
				}
    }
</script>

<style scoped>

</style>
