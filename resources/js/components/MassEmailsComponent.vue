<template>
    <div class="row">
        <div class="col-12">
            <form action="">
                <div class="form-group">
                    <label for="subject">{{trans('form.subject')}}</label>
                    <input type="text" v-model="massemails.subject" class="form-control" id="subject" :class="{'is-invalid': errors.subject}"  name="subject">
                    <div class="invalid-feedback" v-if="errors.subject">{{errors.subject[0]}}</div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="description">{{trans('form.description')}}</label>
                    <summernote
                        id="description"
                        name="editor"
                        :model="massemails.description"
                        v-on:change="value => { massemails.description = value }"
                        :config="config"
                    ></summernote>
                    <div class="invalid-feedback d-block" v-if="errors.description">{{errors.description[0]}}</div>
                </div>
                <div class="form-group">
                    <label class="form-control-label"   for="target">{{trans('form.target')}}</label>
                    <multiselect
                        v-model="massemails.target"
                        :options="roles"
                        :multiple="true"
                        openDirection="bottom"
                        track-by="name"
                        label="name"
                        id="target"
                        :class="{'border border-danger rounded': errors.target}">
                    </multiselect>
                    <div class="invalid-feedback d-block" v-if="errors.target">{{errors.target[0]}}</div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="exclude">{{trans('form.exclude')}}</label>
                    <multiselect
                        v-model="massemails.exclude"
                        :options="emails"
                        :multiple="true"
                        openDirection="bottom"
                        track-by="email"
                        label="email"
                        id="exclude"
                        @search-change="asyncFind"
                        :class="{'border border-danger rounded': errors.exclude}">
                    </multiselect>
                    <div class="invalid-feedback d-block" v-if="errors.exclude">{{errors.exclude[0]}}</div>
                </div>
                <div class="col-lg-12">
                    <a class="btn btn-info text-uppercase mt-5" href="#" :disabled="submiting" @click.prevent="create">
                        <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                        <span class="ml-1">{{trans('messages.send_email')}}</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                roles:[],
                emails:[],
                massemails:{},
                errors: {},
                submiting: false,
                config: {
                    height: 100
                },
            }
        },
        components: {
            'summernote' : require('./Summernote')
        },
        mounted() {
            this.getRoles();
        },
        methods:{
            getRoles(){
                axios.get(`/amministrazione/api/getroles`)
                     .then(response=>{
                         this.roles = response.data
                     })
                     .catch(error=>{

                     })
            },
            asyncFind(query){
                axios.get(`/amministrazione/api/getemails/${query}`,)
                    .then(response=>{
                        this.emails= response.data
                    })
                    .catch(error=>{

                    })
            },

           create () {
               if (!this.submiting) {
                   this.submiting = true
                   axios.post(`/amministrazione/messaggi`,this.massemails)
                   .then(response => {
                       console.log(response.data)
                       this.submiting = false
                       if (response.data.status == 'success'){
                           swal("Good job!", response.data.msg, "success");
                           this.massemails = {}
                       }else if (response.data.status == 'error'){
                           swal("Woops!", response.data.msg, "error");
                           this.massemails = {};
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

