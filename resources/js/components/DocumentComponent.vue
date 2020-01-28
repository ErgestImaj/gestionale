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
						:label="trans('form.category')"
						multiple
						outlined
					></v-select>
				</v-col>
				<v-col cols="12" sm="6">
					<v-select
						v-model="doc.role"
						:items="roles"
						:menu-props="{ maxHeight: '400' }"
						:label="trans('form.share_with')"
						multiple
						outlined
					></v-select>
				</v-col>
			</v-row>
			<v-row>
				<v-col cols="12" sm="12">
					<v-file-input :label="trans('form.doc_file')"
												outlined
												prepend-icon=""
												prepend-inner-icon="mdi-cloud-upload"
												v-model="doc.file"
					></v-file-input>
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
        components: {
            modules
        },
        data(){
            return{
                doc:{},
                errors: {},
								submiting: false,
								categories: ['cat1', 'cat2', 'cat3', 'cat4'],
								roles: ['rol1', 'rol2', 'rol3', 'rol4']
            }
        },
        props: ['lang'],
        created: function () {
            //
        },
        methods: {
						send: function() {
                if (!this.submiting) {
                    this.submiting = true

                    // let formData = new FormData()
                    // formData.append('doc_file', this.doc.file);
                    // formData.append('content', JSON.stringify(this.content))
                    // axios.post(`/lms-content`,
                    //     formData,
                    //     {
                    //         headers: {
                    //             'Content-Type': 'multipart/form-data'
                    //         }
										//
                    //     }).then(response => {
                    //     this.submiting = false
                    //     if (response.data.status == 'success'){
                    //         swal("Good job!", response.data.msg, "success");
                    //         this.content = {};
                    //         this.content_type=null;
                    //         this.lms_file= null;
                    //     }
                    // }).catch(error => {
                    //     this.submiting = false
                    //     this.errors = error.response.data.errors
                    // })
                }
						}
        }
    }
</script>

<style scoped>

</style>
