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
                    <v-toolbar-title>Categories</v-toolbar-title>
                </v-toolbar>

                <v-list two-line>
                    <v-list-item :key="item.title" v-for="item in categories">
                        <template v-slot:default="{ active, toggle }">
                            <v-list-item-avatar>
                                <v-icon class="grey lighten-1 white--text">mdi-folder</v-icon>
                                <span class="gcount">{{item.documents_count}}</span>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title v-text="item.name"></v-list-item-title>
                                <v-list-item-subtitle class="text--primary">{{ 'Files: ' + item.documents_count}}
                                </v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action class="d-flex flex-row justify-space-between align-center">
                                <v-btn icon>
                                    <v-icon color="grey lighten-1" @click="openEdit(item)">mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn icon class="delete-btn" :data-content="trans('messages.delete_record')"
                                       :data-action="'/amministrazione/download/categories/'+item.hashid">
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
                                @click="send"
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
    import modules from './ModulesListComponent'

    export default {
        components: {
            modules
        },
        data() {
            return {
                cat: {},
                errors: {},
                errorsmodify: {},
                submiting: false,
                categories: [],
                noCategories: false,
                loading: true,
                editDialog: false,
                edit: null
            }
        },
        mounted() {
            this.getCategories()
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
                axios.get(`/amministrazione/api/download/category/index`)
                    .then(response => {
                        this.categories = response.data;
                        this.noCategories = response.data.length === 0;
                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },
            send() {
                if (!this.submiting) {
                    this.submiting = true;
                    axios.post(`/amministrazione/api/download/category/create`, this.cat)
                        .then(response => {
                            this.submiting = false;
                            if (response.data.status === 'success') {
                                swal("Good job!", response.data.msg, "success");
                                this.loading = true;
                                this.getCategories();
                            } else if (response.data.status === 'error') {
                                swal({
                                    title: "Whoops!",
                                    text: response.data.msg,
                                    icon: "warning",
                                    dangerMode: true,
                                });
                            }
                            this.cat = {};

                        })
                        .catch(error => {
                            this.submiting = false;
                            this.errors = error.response.data.errors
                        })
                }
            },
            updateCategory(record) {
                if (!this.submiting) {
                    this.submiting = true;
                    axios.patch(`/amministrazione/api/download/category/${record}`, this.edit)
                        .then(response => {
                            this.submiting = false;
                            if (response.data.status === 'success') {
                                swal("Good job!", response.data.msg, "success");
                                this.update = false;
                                this.loading = true;
                                this.getCategories();
                                this.edit = null;
                                this.editDialog = false;
                            } else if (response.data.status === 'error') {
                                swal({
                                    title: "Whoops!",
                                    text: response.data.msg,
                                    icon: "warning",
                                    dangerMode: true,
                                });
                                this.update = false;
                            }
                            this.cat = {};

                        })
                        .catch(error => {
                            this.submiting = false;
                            this.errorsmodify = error.response.data.errors
                        })
                }
            }
        }
    }
</script>

