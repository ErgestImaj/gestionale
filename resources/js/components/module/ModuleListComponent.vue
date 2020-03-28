<template>
	<div>
		<v-row>
			<v-overlay :value="loading">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-col cols="12" sm="6">
				<v-card>
					<v-card-title>
						Moduli
						<v-spacer></v-spacer>
						<v-text-field
							v-model="search"
							append-icon="search"
							:label="trans('form.search')"
							single-line
							hide-details
						></v-text-field>
					</v-card-title>
					<v-data-table
						:headers="headers"
						:items="modules"
						:search="search"
						:loading="loading"
						:footer-props="footerProps"
						class="pa-4"
					>
						<template v-slot:item.module_credits_price="{ item }">
							{{ item.module_credits_price | currency}}
						</template>
						<template v-slot:item.module_percentage_success="{ item }">
							{{ item.module_percentage_success | percent}}
						</template>
						<template v-slot:item.actions="{ item }">
							<v-tooltip bottom>
								<template v-slot:activator="{ on }">
									<v-btn icon color="primary" @click="openEdit(item)" v-on="on">
										<v-icon>mdi-pencil</v-icon>
									</v-btn>
								</template>
								<span>{{trans('headers.edit_module')}}</span>
							</v-tooltip>

							<v-tooltip bottom>
								<template v-slot:activator="{ on }">
									<v-btn icon color="indigo" v-on="on" @click="openContent(item)">
										<v-icon>mdi-plus-box-multiple</v-icon>
									</v-btn>
								</template>
								<span>{{trans('form.add_content')}}</span>
							</v-tooltip>

							<v-tooltip bottom>
								<template v-slot:activator="{ on }">
									<v-btn v-on="on" icon color="red" class="delete-btn"
												 :data-content="trans('messages.delete_module')"
												 :data-action="'/module/'+item.hashid"
									>
										<v-icon>mdi-delete</v-icon>
									</v-btn>
								</template>
								<span>{{trans('form.delete')}}</span>
							</v-tooltip>
						</template>
					</v-data-table>
				</v-card>
			</v-col>

			<v-col cols="12" sm="6">
				<v-card class="mx-auto">
					<v-toolbar color="primary" dark>
						<v-toolbar-title>{{trans('form.new_module')}}</v-toolbar-title>
					</v-toolbar>

					<div class="p-4">
						<v-row>
							<v-col cols="12" sm="12">
								<v-text-field dense outlined
															:label="trans('form.name')"
															v-model="newModule.module_name"
															:error-messages="getError('module_name')"
								></v-text-field>
								<v-text-field dense outlined
															:label="trans('form.code_module')"
															v-model="newModule.module_code"
															:error-messages="getError('module_code')"
								></v-text-field>
								<v-text-field dense outlined
															:label="trans('form.module_percentage_success')"
															v-model="newModule.module_percentage_success"
															:error-messages="getError('module_percentage_success')"
															suffix="%"
								></v-text-field>
								<v-text-field dense outlined
															:label="trans('form.module_credits')"
															v-model="newModule.module_credits"
															:error-messages="getError('module_credits')"
								></v-text-field>
								<v-text-field dense outlined
															:label="trans('form.module_credits_price')"
															v-model="newModule.module_credits_price"
															:error-messages="getError('module_credits_price')"
															suffix="€"
								></v-text-field>
								<v-text-field dense outlined
															label="Ordine"
															v-model="newModule.order"
															:error-messages="getError('order')"
								></v-text-field>
								<v-textarea dense outlined rows="2"
														:label="trans('form.description')"
														v-model="newModule.module_description"
														:error-messages="getError('module_description')"
								></v-textarea>
							</v-col>
						</v-row>
						<v-row>
							<v-col cols="12" sm="12">
								<v-btn
									:loading="submiting"
									:disabled="submiting"
									color="primary"
									class="ma-0 white--text"
									@click="addModule()"
								>
									{{trans('form.save')}}
								</v-btn>
							</v-col>
						</v-row>
					</div>
				</v-card>
			</v-col>

			<v-dialog v-model="editDialog" persistent max-width="600px">
				<v-card v-if="edit">
					<v-card-title>
						<span class="headline">{{ '#' + edit.id}}</span>
					</v-card-title>
					<v-card-text>
						<v-container>
							<v-form>
								<v-row>
									<v-col cols="12" sm="12">
										<v-text-field dense outlined
																	:label="trans('form.name')"
																	v-model="edit.module_name"
																	:error-messages="getError('module_name', true)"
										></v-text-field>
										<v-text-field dense outlined
																	:label="trans('form.code_module')"
																	v-model="edit.module_code"
																	:error-messages="getError('module_code', true)"
										></v-text-field>
										<v-text-field dense outlined
																	:label="trans('form.module_percentage_success')"
																	v-model="edit.module_percentage_success"
																	:error-messages="getError('module_percentage_success', true)"
																	suffix="%"
										></v-text-field>
										<v-text-field dense outlined
																	:label="trans('form.module_credits')"
																	v-model="edit.module_credits"
																	:error-messages="getError('module_credits', true)"
										></v-text-field>
										<v-text-field dense outlined
																	:label="trans('form.module_credits_price')"
																	v-model="edit.module_credits_price"
																	:error-messages="getError('module_credits_price', true)"
																	suffix="€"
										></v-text-field>
										<v-text-field dense outlined
																	label="Ordine"
																	v-model="edit.order"
																	:error-messages="getError('order', true)"
										></v-text-field>
										<v-textarea dense outlined rows="2"
																:label="trans('form.description')"
																v-model="edit.module_description"
																:error-messages="getError('module_description', true)"
										></v-textarea>
									</v-col>
								</v-row>
							</v-form>
						</v-container>
					</v-card-text>
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn color="grey darken-1" text @click="closeEdit()">{{trans('form.doc_close')}}</v-btn>
						<v-btn
							:loading="submiting"
							:disabled="submiting"
							color="primary darken-1" @click="updateModule(edit.hashid)">
							{{trans('form.save')}}
						</v-btn>
					</v-card-actions>
				</v-card>
			</v-dialog>
			<v-dialog v-model="contentDialog" max-width="800px">
				<div v-if="contentData" style="background: white">
					<v-btn class="ma-3 mb-0" @click="closeContent()">Chiudi</v-btn>
							<add-lms
								:prev-course="contentData.course_id"
								:sel-module="contentData.id"
							></add-lms>
				</div>
			</v-dialog>
		</v-row>
	</div>
</template>

<script>
    export default {
        dependencies: 'globalService',
        props: ['course'],
        data () {
            return {
                footerProps: null,
                search: '',
                headers: [
                    {
                        text: '#',
                        value: 'id',
                    },
                    { text: this.trans('form.name'), value: 'module_name' },
                    { text: this.trans('form.module_credits'), value: 'module_credits' },
                    { text: this.trans('form.price'), value: 'module_credits_price' },
                    { text: this.trans('form.module_percentage'), value: 'module_percentage_success' },
                    { text: 'Ordine', value: 'order' },

                    { text: this.trans('form.actions'), value: "actions", sortable: false, align: 'right' },
                ],
                modules: [],
                loading: true,
                newModule: {},
                errors: {},
                errorsmodify: {},
                submiting: false,
                editDialog: false,
                contentDialog: false,
								contentData: null,
                edit: null
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getModules();
        },
        methods: {
            openEdit(record) {
                this.edit = record;
                this.editDialog = true;
            },
            closeEdit() {
                this.editDialog = false;
                this.edit = null;
            },
						openContent(item) {
                this.contentData = item;
                this.contentDialog = true;
						},
						closeContent() {
                this.contentData = null;
                this.contentDialog = false;
						},
            addModule() {
                if (!this.submiting) {
                    this.submiting = true;
                    axios.post(`/course/${getUrlData(2)}/module`, this.newModule)
                        .then(response => {
                            if (response.data.status == 'success'){
                                swal("Good job!", response.data.msg, "success");
                                this.getModules();
                            }
                            this.newModule = {};

                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        }).finally(() => {
														this.submiting = false;
												})
                }
            },
						updateModule(record) {
                if (!this.submiting) {
                    this.submiting = true;
                    axios.patch(`/module/${record}`, this.edit)
                        .then(response => {
                            this.submiting = false;
                            if (response.data.status == 'success'){
                                swal("Good job!", response.data.msg, "success");
                                this.closeEdit();
                                this.getModules();
                            }
                        })
                        .catch(error => {
                            this.errorsmodify = error.response.data.errors;
                        }).finally(() => {
														this.submiting = false;
												})
                }
						},
            getModules() {
                this.loading = true;
                axios.get(`/api/course/${getUrlData(2)}/modules`)
                    .then(response => {
                        this.modules = response.data;

                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            getError(field, isEdit) {
                if (isEdit) {
                    return this.errorsmodify[field] ? this.errorsmodify[field][0] : []
                }
                return this.errors[field] ? this.errors[field][0] : []
            },
        },
    }
</script>

<style scoped>
</style>
