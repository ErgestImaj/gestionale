<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">{{trans('headers.base_info')}}</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="title">{{trans('form.title')}}</label>
                                    <input type="text" v-model="content.title" id="title" :class="{'is-invalid': errors.title}" class="form-control">
                                    <div class="invalid-feedback" v-if="errors.title">{{errors.title[0]}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="code">{{trans('form.code_module')}}</label>
                                    <input type="text" v-model="content.code" id="code" :class="{'is-invalid': errors.code}" class="form-control">
                                    <div class="invalid-feedback" v-if="errors.code">{{errors.code[0]}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >{{trans('form.course')  | capitalize}}</label>
                                    <multiselect
                                        v-model="content.course"
                                        :options="courses"
                                        openDirection="bottom"
                                        track-by="hashid"
                                        label="name"
                                        :disabled="isDisabled"
                                        @select="getCourseModules"
                                        :class="{'border border-danger rounded': errors.course}">
                                    </multiselect>
                                    <div class="invalid-feedback d-block" v-if="errors.course">{{errors.course[0]}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" >{{trans('form.module')  | capitalize}}</label>
                                    <multiselect
                                        v-model="content.module"
                                        :options="modules"
                                        openDirection="bottom"
                                        track-by="hashid"
                                        label="module_name"
                                        :disabled="Disabled"
                                        :class="{'border border-danger rounded': errors.module}">
                                    </multiselect>
                                    <div class="invalid-feedback d-block" v-if="errors.module">{{errors.module[0]}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="content_type">{{trans('form.content_type')}}</label>
                                    <multiselect
                                        v-model="content.content_type"
                                        :options="content_types"
                                        openDirection="bottom"
                                        track-by="value"
                                        label="name"
                                        id="content_type"
                                        @select="getSelectedItem"
                                        :class="{'border border-danger rounded': errors.content_type}">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <fieldset v-if="content_type=='file' || content_type=='video' || content_type=='audio'" class="form-group ">
                                        <label for="lms_file">{{trans('form.lms_file')}}</label>
                                        <input type="file" id="lms_file" :class="{'is-invalid': errors.lms_file}" class="form-control" @change="handleFileUpload($event)" rel="file">
                                        <div class="invalid-feedback" v-if="errors.lms_file">{{errors.lms_file[0]}}</div>
                                    </fieldset>
                                    <fieldset v-if="content_type=='url' ||  content_type=='video_url'|| content_type=='audio_url'" class="form-group ">
                                        <label for="file_path">{{trans('form.resource_link')}}</label>
                                        <input class="form-control" :class="{'is-invalid': errors.file_path}"  v-model="content.file_path" type="text" id="file_path">
                                        <div class="invalid-feedback" :class="{'is-invalid': errors.file_path}" v-if="errors.file_path">{{errors.content_type[0]}}</div>
                                    </fieldset>

                                </div>
                            </div>
                            <div class="col-md-12">
                               <div class="form-group">
                                   <label for="file_description">{{trans('form.description')}}</label>
                                   <summernote
                                       id="file_description"
                                       name="editor"
                                       :model="content.description"
                                       v-on:change="value => { content.description = value }"
                                       :config="config"
                                   ></summernote>
                                   <div class="invalid-feedback d-block" v-if="errors.description">{{errors.description[0]}}</div>
                               </div>
                            </div>
                            <div class="col-lg-12">
                                <a class="btn btn-info text-uppercase mt-5" href="#" :disabled="submiting" @click.prevent="create">
                                    <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                                    <span class="ml-1">{{trans('form.save')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return{
                content_type:null,
                lms_file: null,
                content_types:[
                    {value:'file', name: 'File'},
                    {value:'video', name: 'Video File'},
                    {value:'audio', name: 'Audio File'},
                    {value:'video_url', name: 'Video URL'},
                    {value:'audio_url', name: 'Audio URL'},
                    {value:'url', name: 'URL'},
                ],
                courses:[],
                modules:[],
                content:{},
                errors: {},

                isDisabled: false,
                Disabled: true,
                submiting: false,
                loading: true,
                config: {
                    height: 100
                },
            }
        },
        components: {
            'summernote' : require('./Summernote')
        },
        mounted() {
            this.getCourses();
        },
        methods:{
            getCourses(){
                this.modules =[];
                axios.get(`/filter-courses`)
                     .then(response=>{
                         this.courses = response.data
                     })
                     .catch(error=>{

                     })
            },
            getCourseModules(course){
                if("hashid" in course){
                    this.isDisabled =true;
                    axios.get(`/course/${course.hashid}/modules`)
                        .then(response=>{
                            this.isDisabled =false;
                            this.modules = response.data
                            this.Disabled =false;
                        })
                        .catch(error=>{
                            this.isDisabled =false;
                        })
                }
            },
            getSelectedItem(content){
                this.content_type = content.value;
            },
            handleFileUpload(e){
                return this.lms_file = e.target.files[0];
            },
           create () {
               if (!this.submiting) {
                   this.submiting = true

                   let formData = new FormData()

                   formData.append('lms_file', this.lms_file);
                   formData.append('content',JSON.stringify(this.content))
                   axios.post(`/lms-content`,
                       formData,
                       {
                           headers: {
                               'Content-Type': 'multipart/form-data'
                           }

                       }).then(response => {
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
           },
       }
    }
</script>

