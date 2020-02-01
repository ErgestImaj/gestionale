<template>
    <v-row>
        <v-col cols="12" sm="6">
            <v-card class="mx-auto">
                <v-toolbar color="primary" dark>
                    <v-toolbar-title>Categories</v-toolbar-title>

                    <v-spacer></v-spacer>

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
                                    <v-icon color="grey lighten-1">mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn icon class="delete-btn" :data-content="trans('messages.delete_record')"  :data-action="'/amministrazione/download/categories/'+item.hashid" >
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
                    <v-toolbar-title>Add new category</v-toolbar-title>
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
                                Add Category
                            </v-btn>
                        </v-col>
                    </v-row>
                </div>
            </v-card>
        </v-col>
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
                submiting: false,
                categories: []
            }
        },
        mounted() {
            this.getCategories()
        },
        methods: {
            getCategories() {
                axios.get(`/amministrazione/api/download/category/index`)
                     .then(response=>{
                         this.categories = response.data
                     })
                     .catch(error => {

                     });
            },
            send() {
                if (!this.submiting) {
                    this.submiting = true
                    axios.post(`/amministrazione/api/download/category/create`, this.cat)
                        .then(response => {
                            this.submiting = false
                            if (response.data.status == 'success') {
                                swal("Good job!", response.data.msg, "success");
                            } else if (response.data.status == 'error') {
                                swal({
                                    title: "Whoops!",
                                    text: response.data.msg,
                                    icon: "warning",
                                    dangerMode: true,
                                })
                                this.update = false;
                            }
                            this.cat = {};

                        })
                        .catch(error => {
                            this.submiting = false
                            this.errors = error.response.data.errors
                        })
                }
            },
            updateCategory(record){
                if (!this.submiting) {
                    this.submiting = true
                    axios.patch(`/api/download/category/${record}`, this.cat)
                        .then(response => {
                            this.submiting = false
                            if (response.data.status == 'success'){
                                swal("Good job!", response.data.msg, "success");
                                this.update = false;
                            }
                            else if (response.data.status == 'error') {
                                swal({
                                    title: "Whoops!",
                                    text: response.data.msg,
                                    icon: "warning",
                                    dangerMode: true,
                                })
                                this.update = false;
                            }
                            this.cat = {};

                        })
                        .catch(error => {
                            this.submiting = false
                            this.errors = error.response.data.errors
                        })
                }
            }
        }
    }
</script>

<style scoped>

</style>
