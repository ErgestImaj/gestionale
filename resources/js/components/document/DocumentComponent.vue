<template>
    <v-form class="p-4">
        <v-container>
            <v-row>
                <v-col cols="12" sm="6">
                    <v-text-field
                        :label="trans('form.name')"
                        :error-messages="errors.name ? errors.name[0] : []"
                        outlined v-model="doc.name"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-select
                        v-model="doc.category"
                        :items="categories"
                        item-text="name"
                        item-value="id"
                        :error-messages="errors.category ? errors.category[0] : []"
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
                        :error-messages="errors.role ? errors.role[0] : []"
                        item-text="name"
                        item-value="id"
                        :menu-props="{ maxHeight: '400' }"
                        :label="trans('form.share_with')"
                        multiple
                        outlined
                    ></v-select>
                </v-col>
						 	<v-col cols="12" sm="6">
                    <v-select
                        v-model="doc.types"
                        :items="types"
                        :error-messages="errors.types ? errors.types[0] : []"
                        item-text="name"
                        item-value="id"
                        :menu-props="{ maxHeight: '400' }"
                        label="Tipo"
                        multiple
                        outlined
                    ></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="12">
                    <v-text-field :label="trans('form.choose_file')" outlined @click='pickFile'
                                  prepend-inner-icon="mdi-cloud-upload"
                                  :error-messages="errors.doc_file ? errors.doc_file[0] : []"
                                  :value="doc_file ? doc_file.name : '' "></v-text-field>
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
    import modules from '../module/ModulesListComponent'

    export default {
        props: ['lang'],
        components: {
            modules
        },
        data() {
            return {
                doc: {},
                doc_file: null,
							  types:[],
                errors: {},
                submiting: false,
                categories: [],
                roles: [],
            }
        },

        mounted() {
            this.getCategories()
            this.getRoles()
					  this.getUserTypes()
        },
        methods: {
            getRoles() {
                axios.get(`/amministrazione/api/getroles`)
                    .then(response => {
                        if (response.data) {
                            this.roles = response.data;
                        }
                    })
                    .catch(error => {

                    })
            }, getCategories() {
                axios.get(`/amministrazione/api/download/category/list`)
                    .then(response => {
                        if (response.data != undefined) {
                            this.categories = response.data
                        }
                    })
                    .catch(error => {

                    });
            },
            pickFile() {
                this.$refs.image.click()
            },
            handleFileUpload(e) {
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
                        this.submiting = false
                        if (response.data.status == 'success') {
                            swal("Good job!", response.data.msg, "success");
													setTimeout(function () {
														window.location.href = response.data.redirect;
													}, 1500)
                        }
                        else if (response.data.status === 'error') {
                            swal({
                                title: "Whoops!",
                                text: response.data.msg,
                                icon: "warning",
                                dangerMode: true,
                            });
                            this.submiting = false
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
