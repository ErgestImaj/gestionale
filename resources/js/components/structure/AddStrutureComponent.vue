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
                  <v-text-field
                    :label="trans('form.nome_strutura')"
                    outlined
                    :error-messages="errors.nome  ? errors.nome[0] : []"
                    v-model="strutura.nome"
                    dense
                  ></v-text-field>
                  <v-text-field
                    :label="trans('form.ragione_sociale')"
                    outlined
                    :error-messages="errors.legal_name  ? errors.legal_name[0] : []"
                    v-model="strutura.legal_name"
                    dense
                  ></v-text-field>
                  <v-text-field
                    :label="trans('form.piva')"
                    outlined
                    :error-messages="errors.piva  ? errors.piva[0] : []"
                    v-model="strutura.piva"
                    dense
                  ></v-text-field>

                  <v-text-field
                    label="Codice Fiscale"
                    outlined
                    :error-messages="errors.tax_code  ? errors.tax_code[0] : []"
                    v-model="strutura.tax_code"
                    dense
                  ></v-text-field>

                  <v-select
                    dense
                    v-model="strutura.accredit"
                    :items="accredit"
                    item-text="value"
                    item-value="id"
                    @change="getValues"
                    :error-messages="errors.accredit  ? errors.accredit[0] : []"
                    multiple
                    :label="trans('form.accredit')"
                    outlined
                  ></v-select>
                  <v-text-field
                    label="Codice LRN"
                    outlined
                    v-if="lrn"
                    :error-messages="errors.lrn  ? errors.lrn[0] : []"
                    v-model="strutura.lrn"
                    dense
                  ></v-text-field>
                  <v-menu
                    v-if="lrn"
                    content-class="gdate"
                    v-model="datePicker1"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="strutura.accredit_lrn"
                        label="Data accreditamento LRN"
                        readonly
                        outlined
                        dense
                        v-on="on"
                        :error-messages="errors.accredit_lrn ? errors.accredit_lrn[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="strutura.accredit_lrn" @input="datePicker1 = false"></v-date-picker>
                  </v-menu>
                  <v-menu
                    v-if="mf"
                    content-class="gdate"
                    v-model="datePicker2"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="strutura.accredit_mf"
                        label="Data accreditamento MF"
                        readonly
                        outlined
                        dense
                        v-on="on"
                        :error-messages="errors.accredit_mf ? errors.accredit_mf[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="strutura.accredit_mf" @input="datePicker2 = false"></v-date-picker>
                  </v-menu>
                  <v-menu
                    v-if="dile"
                    content-class="gdate"
                    v-model="datePicker3"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="strutura.accredit_dile"
                        label="Data accreditamento DILE"
                        readonly
                        outlined
                        dense
                        v-on="on"
                        :error-messages="errors.accredit_dile ? errors.accredit_dile[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="strutura.accredit_dile" @input="datePicker3 = false"></v-date-picker>
                  </v-menu>
                  <v-menu
                    v-if="iiq"
                    content-class="gdate"
                    v-model="datePicker4"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="strutura.accredit_iiq"
                        label="Data accreditamento IIQ"
                        readonly
                        outlined
                        dense
                        v-on="on"
                        :error-messages="errors.accredit_iiq ? errors.accredit_iiq[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="strutura.accredit_iiq" @input="datePicker4 = false"></v-date-picker>
                  </v-menu>
                  <v-menu
                    v-if="miur"
                    content-class="gdate"
                    v-model="datePicker5"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="strutura.accredit_miur"
                        label="Data accreditamento MIUR"
                        readonly
                        outlined
                        dense
                        v-on="on"
                        :error-messages="errors.accredit_miur ? errors.accredit_miur[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="strutura.accredit_miur" @input="datePicker5 = false"></v-date-picker>
                  </v-menu>
                  <v-text-field
                    :label="trans('form.codice_destinatario')"
                    outlined
                    :error-messages="errors.codice_destinatario  ? errors.codice_destinatario[0] : []"
                    v-model="strutura.codice_destinatario"
                    dense
                  ></v-text-field>
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
                    dense
                    v-model="strutura.legal_country"
                    :items="nazioni"
                    item-text="name"
                    item-value="id"
                    :error-messages="errors.legal_country ? errors.legal_country[0] : []"
                    :label="trans('form.country')"
                    outlined
                  ></v-autocomplete>
                  <v-autocomplete
                    dense
                    v-model="strutura.legal_town"
                    :items="towns"
                    item-text="title"
                    item-value="id"
                    :error-messages="errors.legal_town ? errors.legal_town[0] : []"
                    :label="trans('form.city')"
                    outlined
                  ></v-autocomplete>

                  <v-autocomplete
                    dense
                    v-model="strutura.legal_region"
                    :items="regions"
                    item-text="title"
                    item-value="id"
                    :error-messages="errors.legal_region ? errors.legal_region[0] : []"
                    label="Regione"
                    outlined
                  ></v-autocomplete>

                  <v-autocomplete
                    dense
                    v-model="strutura.legal_prov"
                    :items="province"
                    item-text="title"
                    item-value="id"
                    :error-messages="errors.legal_prov ? errors.legal_prov[0] : []"
                    :label="trans('form.state')"
                    outlined
                  ></v-autocomplete>

                  <v-text-field
                    :label="trans('form.cap')"
                    outlined
                    v-model="strutura.legal_zipcode"
                    :error-messages="errors.legal_zipcode ? errors.legal_zipcode[0] : []"
                    dense
                  ></v-text-field>

                  <v-text-field
                    :label="trans('form.address')"
                    outlined
                    :error-messages="errors.legal_address ? errors.legal_address[0] : []"
                    v-model="strutura.legal_address"
                    dense
                  ></v-text-field>
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
                    dense
                    v-model="strutura.operational_country"
                    :items="nazioni"
                    :label="trans('form.country')"
                    item-text="name"
                    item-value="id"
                    :error-messages="errors.operational_country ? errors.operational_country[0] : []"
                    outlined
                  ></v-autocomplete>
                  <v-row>
                    <v-col cols="12">
                      <v-autocomplete
                        dense
                        v-model="strutura.operational_town"
                        :items="towns"
                        item-text="title"
                        item-value="id"
                        :error-messages="errors.operational_town ? errors.operational_town[0] : []"
                        :label="trans('form.city')"
                        outlined
                      ></v-autocomplete>
                    </v-col>
                    <v-col cols="12">
                      <v-autocomplete
                        dense
                        v-model="strutura.operational_prov"
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
                        dense
                        v-model="strutura.operational_region"
                        :items="regions"
                        item-text="title"
                        item-value="id"
                        :error-messages="errors.operational_region ? errors.operational_region[0] : []"
                        label="Regione"
                        outlined
                      ></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3">
                      <v-text-field
                        :label="trans('form.cap')"
                        outlined
                        v-model="strutura.operational_zipcode"
                        :error-messages="errors.operational_zipcode ? errors.operational_zipcode[0] : []"
                        dense
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="9">
                      <v-text-field
                        :label="trans('form.address')"
                        outlined
                        :error-messages="errors.operational_address ? errors.operational_address[0] : []"
                        v-model="strutura.operational_address"
                        dense
                      ></v-text-field>
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
                <v-col cols="12">
                  <v-text-field
                    :label="trans('form.phone')"
                    outlined
                    :error-messages="errors.phone ? errors.phone[0] : []"
                    v-model="strutura.phone"
                    dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    :label="trans('form.fax')"
                    outlined
                    :error-messages="errors.fax ? errors.fax[0] : []"
                    v-model="strutura.fax"
                    dense
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12">
                  <v-text-field
                    :label="trans('form.email')"
                    outlined
                    :error-messages="errors.email ? errors.email[0] : []"
                    v-model="strutura.email"
                    dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    :label="trans('form.pec')"
                    outlined
                    v-model="strutura.pec"
                    :error-messages="errors.pec ? errors.pec[0] : []"
                    dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    :label="trans('form.site')"
                    outlined
                    :error-messages="errors.website ? errors.website[0] : []"
                    v-model="strutura.website"
                    dense
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="6">
          <v-card outlined flat>
            <v-card-title>{{'Altre informazioni'}}</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    dense
                    readonly
                    label="Domanda accreditamento"
                    outlined
                    @click="pickFile(0)"
                    :error-messages="errors.doc_file1 ? errors.doc_file1[0] : []"
                    prepend-inner-icon="mdi-cloud-upload"
                    :value="doc1 ? doc1.name : '' "
                  ></v-text-field>
                  <input
                    type="file"
                    style="display: none"
                    ref="file0"
                    @change="handleFileUpload($event, 0)"
                  />
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    dense
                    readonly
                    label="Logo struttura"
                    outlined
                    @click="pickFile(2)"
                    :error-messages="errors.doc_file3 ? errors.doc_file3[0] : []"
                    prepend-inner-icon="mdi-cloud-upload"
                    :value="doc3 ? doc3.name : '' "
                  ></v-text-field>
                  <input
                    type="file"
                    style="display: none"
                    ref="file2"
                    @change="handleFileUpload($event, 2)"
                  />
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    dense
                    readonly
                    label="Visura camerale"
                    outlined
                    @click="pickFile(1)"
                    :error-messages="errors.doc_file2 ? errors.doc_file2[0] : []"
                    prepend-inner-icon="mdi-cloud-upload"
                    :value="doc2 ? doc2.name : '' "
                  ></v-text-field>
                  <input
                    type="file"
                    style="display: none"
                    ref="file1"
                    @change="handleFileUpload($event, 1)"
                  />
                </v-col>
                <v-col v-if="show" cols="12">
                  <v-autocomplete
                    dense
                    v-model="strutura.parent"
                    :items="parents"
                    item-text="legal_name"
                    item-value="id"
                    :error-messages="errors.parent ? errors.parent[0] : []"
                    label="Struttura madre"
                    outlined
                  ></v-autocomplete>
                </v-col>
								<v-col cols="12">
									<v-text-field
										dense
										v-model="strutura.minimum_order"
										:error-messages="errors.minimum_order ? errors.minimum_order[0] : []"
										label="Ordine minimo"
										outlined
									></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="6">
          <v-card outlined flat>
            <v-card-title>{{'Accessi di login'}}</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-switch
                    v-model="strutura.login"
                    label="Spedire via e-mail i credenziali di accesso"
                    value="1"
                  ></v-switch>
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
          >Salva</v-btn>
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
      doc1: "",
      doc2: "",
      doc3: "",
      show: false,
      lrn: false,
      mf: false,
      iiq: false,
      miur: false,
      dile: false,
      datePicker1: false,
      datePicker2: false,
      datePicker3: false,
      datePicker4: false,
      datePicker5: false,
      errors: {},
      submiting: false,
      dataContratto: false,
      date: new Date().toISOString().substr(0, 10),
      nazioni: [],
      regions: [],
      parents: [],
      accredit: [
        { id: 1, value: "MIUR" },
        { id: 2, value: "MEDIAFORM" },
        { id: 3, value: "IIQ" },
        { id: 4, value: "LRN" },
        { id: 5, value: "DILE" }
      ],
      province: [],
      towns: []
    };
  },
  mounted() {
    this.getLocations();
    this.showParentStructure();
  },
  methods: {
    getLocations() {
      axios
        .get(`/amministrazione/api/locations`)
        .then(response => {
          this.nazioni = response.data.countries;
          this.province = response.data.provinces;
          this.towns = response.data.towns;
          this.regions = response.data.regions;
        })
        .catch(error => {});
    },
    showParentStructure() {
      if (getUrlData(3) == 1) {
        return false;
      }
      axios
        .get(`/amministrazione/api/struture/${getUrlData(3)}/parent`)
        .then(response => {
          this.parents = response.data;
          this.show = true;
        })
        .catch(error => {});
    },
    getValues(val) {
      this.lrn = false;
      this.mf = false;
      this.iiq = false;
      this.miur = false;
      this.dile = false;
      if (val.includes(1)) {
        this.miur = true;
      }
      if (val.includes(2)) {
        this.mf = true;
      }
      if (val.includes(3)) {
        this.iiq = true;
      }
      if (val.includes(4)) {
        this.lrn = true;
      }
      if (val.includes(5)) {
        this.dile = true;
      }
    },
    save() {
      if (!this.submiting) {
        this.submiting = true;
        let formData = new FormData();
        formData.append("doc_file1", this.doc1);
        formData.append("doc_file2", this.doc2);
        formData.append("doc_file3", this.doc3);
        formData.append("structure", JSON.stringify(this.strutura));
        axios
          .post(
            `/amministrazione/api/structure/${getUrlData(3)}/store`,
            formData,
            {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            }
          )
          .then(response => {
            this.submiting = false;
            if (response.data.status == "success") {
              swal("Good job!", response.data.msg, "success");
							setTimeout(function () {
								location.reload();
							}, 1500)
            } else if (response.data.status === "error") {
              swal({
                title: "Whoops!",
                text: response.data.msg,
                icon: "warning",
                dangerMode: true
              });
            }
          })
          .catch(error => {
            this.submiting = false;
            this.errors = error.response.data.errors;
          });
      }
    },
    pickFile(i) {
      if (i == 0) {
        this.$refs.file0.click();
      } else if (i == 1) {
        this.$refs.file1.click();
      } else if (i == 2) {
        this.$refs.file2.click();
      }
    },
    handleFileUpload(e, i) {
      if (i == 0) {
        this.doc1 = e.target.files[0];
      } else if (i == 1) {
        this.doc2 = e.target.files[0];
      } else if (i == 2) {
        this.doc3 = e.target.files[0];
      }
    }
  }
};
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
  background: #388e3c;
  color: white;
  padding: 10px 15px;
  box-shadow: 0 19px 20px -12px rgba(0, 0, 0, 0.25);
  background: linear-gradient(45deg, #388e3c, #81c784);
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
