<template>
    <v-form class="add-stru">
        <v-container>
            <v-row>
                <v-col cols="12" md="6">
                    <v-card outlined flat>
                        <v-card-title>{{ trans('form.info_accesso' )}}</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="12" class="gel">
                                    <v-text-field :label="trans('form.nome_strutura')" outlined
                                                  :error-messages="errors.nome  ? errors.nome[0] : []"
                                                  v-model="strutura.nome" dense></v-text-field>
                                    <v-text-field :label="trans('form.ragione_sociale')" outlined
                                                  :error-messages="errors.legal_name  ? errors.legal_name[0] : []"
                                                  v-model="strutura.legal_name" dense></v-text-field>
                                    <v-text-field :label="trans('form.piva')" outlined
                                                  :error-messages="errors.piva  ? errors.piva[0] : []"
                                                  v-model="strutura.piva" dense></v-text-field>

                                    <v-text-field  label="Codice Fiscale" outlined
                                                  :error-messages="errors.tax_code  ? errors.tax_code[0] : []"
                                                  v-model="strutura.tax_code" dense></v-text-field>

                                    <v-select dense v-model="strutura.accredit"
                                              :items="accredit"
                                              item-text="value"
                                              item-value="id"
                                              :error-messages="errors.accredit  ? errors.accredit[0] : []"
                                              multiple
                                              :label="trans('form.accredit')" outlined
                                    ></v-select>

                                    <v-text-field :label="trans('form.codice_destinatario')" outlined
                                                  :error-messages="errors.codice_destinatario  ? errors.codice_destinatario[0] : []"
                                                  v-model="strutura.codice_destinatario"
                                                  dense></v-text-field>

                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card outlined flat>
                        <v-card-title>Sede legale</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="12" class="gel">
                                    <v-autocomplete
                                        dense v-model="strutura.legal_country"
                                        :items="nazioni"
                                        item-text="name"
                                        item-value="id"
                                        :error-messages="errors.legal_country ? errors.legal_country[0] : []"
                                        :label="trans('form.country')"
                                        outlined
                                    ></v-autocomplete>
                                    <v-autocomplete
                                        dense v-model="strutura.legal_town"
                                        :items="towns"
                                        item-text="title"
                                        item-value="id"
                                        :error-messages="errors.legal_town ? errors.legal_town[0] : []"
                                        :label="trans('form.city')"
                                        outlined
                                    ></v-autocomplete>

                                    <v-autocomplete
                                        dense v-model="strutura.legal_region"
                                        :items="regions"
                                        item-text="title"
                                        item-value="id"
                                        :error-messages="errors.legal_region ? errors.legal_region[0] : []"
                                        label="Regione"
                                        outlined
                                    ></v-autocomplete>

                                    <v-autocomplete
                                        dense v-model="strutura.legal_prov"
                                        :items="province"
                                        item-text="title"
                                        item-value="id"
                                        :error-messages="errors.legal_prov ? errors.legal_prov[0] : []"
                                        :label="trans('form.state')"
                                        outlined
                                    ></v-autocomplete>

                                        <v-text-field :label="trans('form.cap')" outlined v-model="strutura.legal_zipcode"
                                                      :error-messages="errors.legal_zipcode ? errors.legal_zipcode[0] : []"
                                                      dense></v-text-field>

                                        <v-text-field :label="trans('form.address')" outlined
                                                      :error-messages="errors.legal_address ? errors.legal_address[0] : []"
                                                      v-model="strutura.legal_address" dense></v-text-field>



                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="6">
                    <v-card outlined flat>
                        <v-card-title>{{trans('form.sedi_esame')}}</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="12" class="gel">

                                    <v-autocomplete
                                        dense v-model="strutura.operational_country"
                                        :items="nazioni"
                                        :label="trans('form.country')"
                                        item-text="name"
                                        item-value="id"
                                        :error-messages="errors.operational_country ? errors.operational_country[0] : []"
                                        outlined
                                    ></v-autocomplete>
                                    <v-row>
                                        <v-col cols="12" >
                                            <v-autocomplete
                                                dense v-model="strutura.operational_town"
                                                :items="towns"
                                                item-text="title"
                                                item-value="id"
                                                :error-messages="errors.operational_town ? errors.operational_town[0] : []"
                                                :label="trans('form.city')"
                                                outlined
                                            ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12" >
                                            <v-autocomplete
                                                dense v-model="strutura.operational_prov"
                                                :items="province"
                                                item-text="title"
                                                item-value="id"
                                                :error-messages="errors.operational_prov ? errors.operational_prov[0] : []"
                                                :label="trans('form.state')"
                                                outlined
                                            ></v-autocomplete>
                                        </v-col>
                                         <v-col cols="12">
                                             <v-autocomplete
                                                 dense v-model="strutura.operational_region"
                                                 :items="regions"
                                                 item-text="title"
                                                 item-value="id"
                                                 :error-messages="errors.operational_region ? errors.operational_region[0] : []"
                                                 label="Regione"
                                                 outlined
                                             ></v-autocomplete>
                                         </v-col>
                                        <v-col cols="12" md="3">
                                            <v-text-field :label="trans('form.cap')" outlined v-model="strutura.operational_zipcode"
                                                          :error-messages="errors.operational_zipcode ? errors.operational_zipcode[0] : []"
                                                          dense></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="9">
                                            <v-text-field :label="trans('form.address')" outlined
                                                          :error-messages="errors.operational_address ? errors.operational_address[0] : []"
                                                          v-model="strutura.operational_address" dense></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card outlined flat>
                        <v-card-title>{{'Informazioni di contatto'}}</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" >
                                    <v-text-field :label="trans('form.phone')" outlined
                                                  :error-messages="errors.phone ? errors.phone[0] : []"
                                                  v-model="strutura.phone" dense></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field :label="trans('form.fax')" outlined
                                                  :error-messages="errors.fax ? errors.fax[0] : []"
                                                  v-model="strutura.fax" dense></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" >
                                    <v-text-field :label="trans('form.email')" outlined
                                                  :error-messages="errors.email ? errors.email[0] : []"
                                                  v-model="strutura.email" dense></v-text-field>

                                </v-col>
                                <v-col cols="12">
                                    <v-text-field :label="trans('form.pec')" outlined v-model="strutura.pec"
                                                  :error-messages="errors.pec ? errors.pec[0] : []"
                                                  dense></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field :label="trans('form.site')" outlined
                                                  :error-messages="errors.website ? errors.website[0] : []"
                                                  v-model="strutura.website" dense></v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row >
                <v-col   cols="12" md="6">
                    <v-card outlined flat>
                        <v-card-title>{{trans('form.rap_legale')}}</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="12" >
                                    <v-text-field :label="trans('form.last_name')" outlined
                                                  :error-messages="errors.rappresentante_cognome ? errors.rappresentante_cognome[0] : []"
                                                  v-model="strutura.rappresentante_cognome" dense></v-text-field>
                                </v-col>
                                 <v-col cols="12" sm="12" >
                                    <v-text-field :label="trans('form.name')" outlined
                                                  :error-messages="errors.rappresentante_nome ? errors.rappresentante_nome[0] : []"
                                                  v-model="strutura.rappresentante_nome" dense></v-text-field>
                                 </v-col>
                                 <v-col cols="12" sm="12" >
                                    <v-text-field :label="trans('form.email')" outlined
                                                  :error-messages="errors.rappresentante_email ? errors.rappresentante_email[0] : []"
                                                  v-model="strutura.rappresentante_email" dense></v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card outlined flat>
                        <v-card-title>{{'Altre informazioni'}}</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" >
                                    <v-text-field dense readonly label="Domanda accreditamento" outlined @click='pickFile(0)'
                                                  :error-messages="errors.doc_file1 ? errors.doc_file1[0] : []"
                                                  prepend-inner-icon="mdi-cloud-upload" :value="doc1 ? doc1.name : '' "
                                    ></v-text-field>
                                    <input
                                        type="file"
                                        style="display: none"
                                        ref="file0"
                                        @change="handleFileUpload($event, 0)"
                                    >
                                </v-col>
                                <v-col cols="12" >
                                    <v-text-field dense readonly label="Logo struttura" outlined @click='pickFile(2)'
                                                  :error-messages="errors.doc_file3 ? errors.doc_file3[0] : []"
                                                  prepend-inner-icon="mdi-cloud-upload" :value="doc3 ? doc3.name : '' "
                                    ></v-text-field>
                                    <input
                                        type="file"
                                        style="display: none"
                                        ref="file2"
                                        @change="handleFileUpload($event, 2)"
                                    >
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field dense readonly label="Visura camerale" outlined @click='pickFile(1)'
                                                  :error-messages="errors.doc_file2 ? errors.doc_file2[0] : []"
                                                  prepend-inner-icon="mdi-cloud-upload" :value="doc2 ? doc2.name : '' "
                                    ></v-text-field>
                                    <input
                                        type="file"
                                        style="display: none"
                                        ref="file1"
                                        @change="handleFileUpload($event, 1)"
                                    >
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="12">
                    <v-btn
                        dense
                        :loading="submiting"
                        :disabled="submiting"
                        color="primary"
                        class="ma-0 white--text"
                        @click.prevent="save"
                    >
                        Salva
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script>
    export default {
        data() {
            return {
                strutura: {},
                doc1: null,
                doc2: null,
                doc3: '',
                errors: {},
                submiting: false,
                dataContratto: false,
                date: new Date().toISOString().substr(0, 10),
                nazioni: [],
                regions:[],
                accredit: [
                    {id:1, value: 'MIUR'},
                    {id:2, value: 'MEDIAFORM'},
                    {id:3, value: 'IIQ'},
                    {id:4, value: 'LRN'},
                    {id:5, value: 'DILE'},

                ],
                province: [],
                towns:[]
            }
        },
        mounted() {
         this.getLocations();
        },
        methods: {
            getLocations(){
                    axios.get(`/amministrazione/api/locations`)
                        .then(response => {
                            this.nazioni = response.data.countries;
                            this.province = response.data.provinces;
                            this.towns = response.data.towns;
                            this.regions = response.data.regions;
                        })
                        .catch(error => {
                        });
            },
            save(){
                if (!this.submiting) {
                    this.submiting = true;
                    let formData = new FormData();
                    formData.append('doc_file1', this.doc1);
                    formData.append('doc_file2', this.doc2);
                    formData.append('doc_file3', this.doc3);
                    formData.append('structure', JSON.stringify(this.strutura))
                    axios.post(`/amministrazione/api/structure/store`,
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }

                        }).then(response => {
                        this.submiting = false
                        if (response.data.status == 'success') {
                            swal("Good job!", response.data.msg, "success");
                            this.doc = {};
                            this.doc_file = null;
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
            },
            pickFile(i) {
                if (i == 0) {
                    this.$refs.file0.click()
                } else if (i == 1) {
                    this.$refs.file1.click()
                }else if (i == 2) {
                    this.$refs.file2.click()
                }
            },
            handleFileUpload(e, i) {
                if (i == 0) {
                    this.doc1 = e.target.files[0];
                } else if (i == 1) {
                    this.doc2 = e.target.files[0];
                }else if (i == 2) {
                    this.doc3 = e.target.files[0];
                }
            },
        }
    }
</script>

<style>
    .gel > div {
        margin-bottom: 15px !important;
    }

    .gel .col-md-6.col-12 {
        padding: 0 12px;
    }

    .v-menu__content {
        margin-top: 40px !important;
    }

    .v-menu__content.v-autocomplete__content {
        margin-top: 0 !important;
    }

    .v-menu__content.gdate {
        margin-top: 0 !important;
    }

    .add-stru .v-card__title {
        background: #388E3C;
        color: white;
        padding: 10px 15px;
        box-shadow: 0 19px 20px -12px rgba(0, 0, 0, 0.25);
        background: linear-gradient(45deg, #388E3C, #81C784);
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: normal;
    }

    .v-application--is-ltr .v-text-field--outlined fieldset {
        background: #f2f2f2;
        border-color: #bfbfbf;
    }

    .gel {
        padding-bottom: 0;
    }

    .gel div:last-child {
        margin-bottom: 0 !important;
    }
</style>
