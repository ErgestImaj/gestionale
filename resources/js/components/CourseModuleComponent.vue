<template>
    <div class="row">
        <div class="col-xl-4 mb-5">
            <div class="card">
                <div class="card-body">
                      <h6 class="heading-small text-muted mb-4">{{trans('form.new_module')}}</h6>
                      <div class="pl-lg-4">
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group">
                                      <label class="form-control-label" for="input-first-name">{{trans('form.name')}}</label>
                                      <input type="text" v-model="module.module_name"  id="input-first-name" :class="{'is-invalid': errors.module_name}" class="form-control" >
                                      <div class="invalid-feedback" v-if="errors.module_name">{{errors.module_name[0]}}</div>
                                  </div>

                                  <div class="form-group">
                                      <label class="form-control-label" for="input-code">{{trans('form.code_module')}}</label>
                                      <input type="text" v-model="module.module_code"  id="input-code" :class="{'is-invalid': errors.module_code}" class="form-control" >
                                      <div class="invalid-feedback" v-if="errors.module_code">{{errors.module_code[0]}}</div>
                                  </div>

                                  <div class="form-group">
                                      <label class="form-control-label" for="input-code">{{trans('form.module_percentage_success')}}</label>
                                      <input type="text" v-model="module.module_percentage_success"  id="input-module_percentage_success" :class="{'is-invalid': errors.module_percentage_success}" class="form-control" >
                                      <div class="invalid-feedback" v-if="errors.module_percentage_success">{{errors.module_percentage_success[0]}}</div>
                                  </div>

                                  <div class="form-group">
                                      <label class="form-control-label" for="input-code">{{trans('form.module_credits')}}</label>
                                      <input type="text" v-model="module.module_credits"  id="input-module_credits" :class="{'is-invalid': errors.module_credits}" class="form-control" >
                                      <div class="invalid-feedback" v-if="errors.module_credits">{{errors.module_credits[0]}}</div>
                                  </div>

                                  <div class="form-group">
                                      <label class="form-control-label" for="input-code">{{trans('form.module_credits_price')}}</label>
                                      <input type="text" v-model="module.module_credits_price"  id="input-module_credits_price" :class="{'is-invalid': errors.module_credits_price}" class="form-control" >
                                      <div class="invalid-feedback" v-if="errors.module_credits_price">{{errors.module_credits_price[0]}}</div>
                                  </div>
                                  <div class="form-group">
                                      <label for="description">{{trans('form.description')}}</label>
                                      <textarea  v-model="module.module_description" :class="{'is-invalid': errors.module_description}" class="form-control"  id="description" rows="4"></textarea>
                                      <div class="invalid-feedback" v-if="errors.module_description">{{errors.module_description[0]}}</div>
                                  </div>
                              </div>
                              <div class="col-lg-12">
                                  <a v-if="!update" class="btn-info btn" href="#" :disabled="submiting" @click.prevent="create">
                                      <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                                      <span class="ml-1">{{trans('form.save')}}</span>
                                  </a>
                                  <a v-else class="btn-warning btn text-white" href="#" :disabled="submiting" @click.prevent="updateModule(module.hashid)">
                                      <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                                      <span class="ml-1">{{trans('form.edit')}}</span>
                                  </a>
                              </div>
                          </div>
                      </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
          <modules ref="modules" v-on:editModule="editModule"></modules>
        </div>
      </div>
</template>

<script>
    import modules from './ModulesListComponent'
    export default {
        data(){
            return{
                module:{},
                errors: {},
                submiting: false,
                loading: true,
                update:false
            }
        },
        components:{
            modules
        },
       methods:{
           create () {
               if (!this.submiting) {
                   this.submiting = true
                   axios.post(`/course/${getUrlData(2)}/module`, this.module)
                       .then(response => {
                           this.submiting = false
                           if (response.data.status == 'success'){
                               swal("Good job!", response.data.msg, "success");
                               this.$refs.modules.getModules();
                           }
                           this.module = {};

                       })
                       .catch(error => {
                           this.submiting = false
                           this.errors = error.response.data.errors
                       })
               }
           },
           editModule (record) {
                    axios.get(`/module/${record}/edit`)
                       .then(response => {
                          if ("module" in response.data){
                              this.update = true;
                              this.module = response.data.module;
                          }

                       })
                       .catch(error => {
                           this.errors = error.response.data.errors
                 })

           },
           updateModule(record){
               if (!this.submiting) {
                   this.submiting = true
                   axios.patch(`/module/${record}`, this.module)
                       .then(response => {
                           this.submiting = false
                           if (response.data.status == 'success'){
                               swal("Good job!", response.data.msg, "success");
                               this.update = false;
                               this.$refs.modules.getModules();
                           }
                           this.module = {};

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
