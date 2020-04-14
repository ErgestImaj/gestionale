<template>
<v-form>
    <v-card outlined flat class="mb-4">
      <v-card-text class="pa-5">
        <v-menu
          content-class="gdate"
          v-model="datePicker1"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          min-width="290px"
          attach
        >
          <template v-slot:activator="{ on }">
            <v-text-field
              v-model="momentDate"
              :label="trans('form.data')"
              readonly
              outlined
              v-on="on"
              :error-messages="errors.date ? errors.date[0] : []"
            ></v-text-field>
          </template>
          <v-date-picker v-model="workshop.date" @input="datePicker1 = false"></v-date-picker>
        </v-menu>

        <v-row>
          <v-col cols="12" md="4">
            <p style="margin-bottom: 5px;">{{trans('form.preferenze')}}</p>
            <v-radio-group
              v-model="workshop.when"
              :mandatory="false"
              :error-messages="errors.when ? errors.when[0] : []"
              row
              dense
            >
              <v-radio :label="trans('form.morning')" :value="0"></v-radio>
              <v-radio :label="trans('form.afternoon')" :value="1"></v-radio>
            </v-radio-group>
          </v-col>
					<v-col cols="12" md="8">
						<v-autocomplete
							chips
							:deletable-chips="true"
							outlined label="Tipo"
							v-model="workshop.types"
							:items="types"
							multiple
							item-text="name"
							item-value="id"
							attach
							:error-messages="errors.types ? errors.types[0] : []"
						></v-autocomplete>
					</v-col>
          <v-col cols="12">
						<v-autocomplete
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
              :label="trans('form.target')"
						></v-autocomplete>
            <div
              class="invalid-feedback d-block"
              v-if="errors.partecipants"
            >{{errors.partecipants[0]}}</div>
          </v-col>
        </v-row>

        <label>{{trans('form.description')}}</label>
        <tiptap-vuetify v-model="workshop.note" :extensions="extensions" />

        <div class="invalid-feedback d-block" v-if="errors.note">{{errors.note[0]}}</div>

        <v-btn
          :loading="submiting"
          :disabled="submiting"
          color="primary"
          class="mt-4 ml-0 white--text"
          @click="updateWorkshop"
        >{{trans('form.save')}}</v-btn>
      </v-card-text>
    </v-card>
  </v-form>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import {
  TiptapVuetify,
  Heading,
  Bold,
  Italic,
  Strike,
  Underline,
  Code,
  Paragraph,
  BulletList,
  OrderedList,
  ListItem,
  Link,
  Blockquote,
  HardBreak,
  HorizontalRule,
  History
} from "tiptap-vuetify";
import moment from "moment";
    export default {
        props:['note'],
        data(){
            return{
                roles:[],
                workshop: {},
                errors: {},
				  			types:[],
                submiting: false,
                datePicker1: false,
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
                    [
                    Heading,
                    {
                        options: {
                        levels: [1, 2, 3]
                        }
                    }
                    ],
                    Bold,
                    Code,
                    HorizontalRule,
                    Paragraph,
                    HardBreak
                ]

            }
        },
        components: {
            'datepicker':  Datepicker,
            TiptapVuetify
        },
        mounted() {
            this.getWorkshop();
           this.getUserTypes();
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
            },
            moment: function() {
                return moment();
            }
       },
        beforeDestroy() {
            this.editor.destroy();
        },
        computed: {
            momentDate() {
            return this.workshop.date
                ? moment(this.workshop.date).format("DD MMM YYYY")
                : "";
            }
        }
    }
</script>

