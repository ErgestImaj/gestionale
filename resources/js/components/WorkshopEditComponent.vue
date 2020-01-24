<template>
    <div class="row">
        <div class="col-12">
            <form action="">
                <div class="form-group">
                    <label for="data">{{trans('form.data')}}</label>
                    <datepicker v-model="workshop.date" input-class="form-control" id="data" name="data"></datepicker>
                    <div class="invalid-feedback d-block" v-if="errors.date">{{errors.date[0]}}</div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label class="form-control-label">{{trans('form.preferenze')}}</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" v-model="workshop.when" :value="0" name="when"  class="custom-control-input" id="customControlValidation2">
                            <label class="custom-control-label pt-1" for="customControlValidation2">{{trans('form.morning')}}</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" v-model="workshop.when" :value="1" name="when" class="custom-control-input" id="customControlValidation3">
                            <label class="custom-control-label pt-1" for="customControlValidation3">{{trans('form.afternoon')}}</label>
                            <div class="invalid-feedback d-block" v-if="errors.when">{{errors.when[0]}}</div>
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <label class="form-control-label"  for="target">{{trans('form.target')}}</label>
                        <multiselect
                                v-model="workshop.partecipants"
                                :options="roles"
                                :multiple="true"
                                openDirection="bottom"
                                track-by="name"
                                label="name"
                                id="target"
                                :class="{'border border-danger rounded': errors.partecipants}">
                        </multiselect>
                        <div class="invalid-feedback d-block" v-if="errors.partecipants">{{errors.partecipants[0]}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="description">{{trans('form.description')}}</label>
                    <summernote
                            id="description"
                            name="note"
                            :model="workshop.note"
                            v-on:change="value => { workshop.note = value }"
                            :config="config"
                    ></summernote>
                    <div class="invalid-feedback d-block" v-if="errors.note">{{errors.note[0]}}</div>
                </div>


                <div class="col-lg-12">
                    <a class="btn btn-info text-uppercase mt-5" href="#" :disabled="submiting" @click.prevent="updateWorkshop">
                        <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                        <span class="ml-1">{{trans('form.save')}}</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    export default {

        data(){
            return{
                roles:[],
                workshop:{},
                errors: {},
                submiting: false,
                config: {
                    height: 100
                },
            }
        },
        components: {
            'summernote' : require('./Summernote'),
            'datepicker':  Datepicker
        },

        mounted() {
            this.getWorkshop();
            this.getRoles();
        },
        methods:{
            getWorkshop(){
                axios.get(`/amministrazione/api/workshop/${getUrlData(3)}/show`)
                    .then(response=>{
                        this.workshop = response.data
                    }) .catch(error => {
                    swal({
                        title: "Whoops!",
                        text: 'Workshop does not exist!',
                        icon: "warning",
                        dangerMode: true,
                    })
                    location.href = '/amministrazione/workshops'
                   })

            },
            getRoles(){
                axios.get(`/amministrazione/api/getroles`)
                    .then(response=>{
                        this.roles = response.data
                    })
            },
            updateWorkshop(){
                if (!this.submiting) {
                    this.submiting = true
                    axios.patch(`/amministrazione/workshop/${getUrlData(3)}/update`, this.workshop)
                        .then(response => {
                            this.submiting = false
                            if (response.data.status == 'success'){
                                swal("Good job!", response.data.msg, "success");
                                this.update = false;
                            }
                            else if (response.data.status == 'error'){
                                swal({
                                    title: "Whoops!",
                                    text: response.data.msg,
                                    icon: "warning",
                                    dangerMode: true,
                                })
                                this.update = false;
                            }
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

