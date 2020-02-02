<template>
    <v-form class="p-4">
        <v-container>
            <v-row>
                <v-col cols="12" sm="12">
                    <v-text-field
                        :label="trans('form.name')"
                        outlined v-model="doc.name"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="6">
                    <v-select
                        v-model="doc.category"
                        :items="categories"
                        :menu-props="{ maxHeight: '400' }"
                        :label="trans('form.doc_category_select')"
                        multiple
                        outlined
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-select
                        v-model="doc.role"
                        :items="roles"
												item-text="name"
												item-value="id"
                        :menu-props="{ maxHeight: '400' }"
                        :label="trans('form.share_with')"
                        multiple
                        outlined
                    ></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="12">
                    <v-text-field :label="trans('form.choose_file')" outlined @click='pickFile' prepend-inner-icon="mdi-cloud-upload" :value="doc_file ? doc_file.name : '' "></v-text-field>
                    <input
                        type="file"
                        style="display: none"
                        ref="image"
                        @change="handleFileUpload($event)"
                    >
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
                        {{trans('form.add_doc')}}
                        <v-icon right dark>mdi-cloud-upload</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-form>

</template>

<script>
    import modules from './ModulesListComponent'

    export default {
        props: ['lang'],
        components: {
            modules
        },
        data() {
            return {
                doc: {},
                doc_file: null,
                errors: {},
                submiting: false,
                categories: [],
                roles: [],
            }
        },

        mounted() {
            this.getCategories()
            this.getRoles()
        },
        methods: {
            getRoles() {
                axios.get(`/amministrazione/api/getroles`)
                    .then(response => {
                        if (response.data) {
														console.log(response.data);
														this.roles = response.data;
                        }
                    })
                    .catch(error => {

                    })
            }, getCategories() {
                axios.get(`/amministrazione/api/download/category/list`)
                    .then(response => {
                        if (response.data != undefined) {
                            this.categories = this.convertObjectToArray(response.data)
                        }
                    })
                    .catch(error => {

                    });
            },
            convertObjectToArray(object) {
                return object.map((i, v) => {
                    return i.name
                })
            },
            pickFile () {
                this.$refs.image.click ()
            },
            handleFileUpload(e){
                console.log(e.target.files[0].name);
                return this.doc_file = e.target.files[0];
            },
            send: function () {
                if (!this.submiting) {
                    this.submiting = true;
                    let formData = new FormData();
                    formData.append('doc_file', this.doc_file);
                    formData.append('doc', JSON.stringify(this.doc))
                    axios.post(`/amministrazione/api/download/store`,
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }

                        }).then(response => {
                            console.log(response);
                            this.submiting = false
                            if (response.data.status == 'success'){
                                swal("Good job!", response.data.msg, "success");
                                this.content = {};
                                this.content_type=null;
                                this.lms_file= null;
                            }
                        }).catch(error => {
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
