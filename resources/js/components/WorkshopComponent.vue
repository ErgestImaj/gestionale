<template>
    <v-form>
	<v-container>
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
                                <input type="radio" v-model="workshop.when" v-bind:value="0"  class="custom-control-input" id="customControlValidation2">
                                <label class="custom-control-label pt-1" for="customControlValidation2">{{trans('form.morning')}}</label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" v-model="workshop.when" v-bind:value="1" class="custom-control-input" id="customControlValidation3">
                                <label class="custom-control-label pt-1" for="customControlValidation3">{{trans('form.afternoon')}}</label>
                                <div class="invalid-feedback d-block" v-if="errors.when">{{errors.when[0]}}</div>
                            </div>
                    </div>
                    <div class="form-group col-md-9">
                        <label class="form-control-label"  for="target">{{trans('form.target')}}</label>
                        <v-combobox
                            dense
                            chips
                            :deletable-chips="true"
                            v-model="workshop.partecipants"
                            :items="roles"
                            outlined
                            multiple
                            item-text="name"
                            item-value="target"
                            :error-messages="errors.partecipants ? errors.partecipants[0] : []"
                            attach
                        ></v-combobox>
                        <div class="invalid-feedback d-block" v-if="errors.partecipants">{{errors.partecipants[0]}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="description">{{trans('form.description')}}</label>

                    <tiptap-vuetify
                        v-model="workshop.note"
                        :extensions="extensions"
                        />
                    
                    <div class="invalid-feedback d-block" v-if="errors.note">{{errors.note[0]}}</div>
                </div>


                <div>
                    <v-btn
                        :loading="submiting"
                        :disabled="submiting"
                        color="primary"
                        class="ma-0 white--text"
                        @click="create"
                    >{{trans('form.save')}}</v-btn>
                </div>
            </form>
        </div>
    </div>
	</v-container>
    </v-form>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'

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
                extensions: [
                    History,
                    Blockquote,
                    Link,
                    Underline,
                    Strike,
                    Italic,
                    ListItem,
                    BulletList,
                    OrderedList,
                    [Heading, {
                        options: {
                        levels: [1, 2, 3]
                        }
                    }],
                    Bold,
                    Code,
                    HorizontalRule,
                    Paragraph,
                    HardBreak
                ],
            }
        },
        components: {
            'summernote' : require('./Summernote'),
            'datepicker':  Datepicker,
             TiptapVuetify 
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

           create () {
               if (!this.submiting) {
                   this.submiting = true
                   axios.post(`/amministrazione/workshop`,this.workshop)
                   .then(response => {
                       console.log(response.data)
                       this.submiting = false
                       if (response.data.status == 'success'){
                           swal("Good job!", response.data.msg, "success");
                           this.workshop = {}
                       }else if (response.data.status == 'error'){
                           swal("Woops!", response.data.msg, "error");
                           this.workshop = {};
                       }
                   }).catch(error => {
                       this.submiting = false
                       this.errors = error.response.data.errors
                   })
               }
           },
       },
        beforeDestroy() {
            this.editor.destroy()
        },
    }
</script>
<style>
#app.workshop .v-application--wrap {
    min-height: 0 !important;
}
</style>