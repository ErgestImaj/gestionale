<template>
  <v-form class="add-user">
    <v-container>
      <v-row>
        <v-col cols="12" md="6">
          <v-card outlined flat>
            <v-card-title>Informazioni di base</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="12" class="gel">
                  <v-text-field label="Nome" outlined v-model="user.firstname" dense
				  	:error-messages="errors.firstname ? errors.firstname[0] : []"
				  ></v-text-field>
                  <v-text-field label="Cognome" outlined v-model="user.lastname" dense 
				  	:error-messages="errors.lastname ? errors.lastname[0] : []"></v-text-field>
                  <v-text-field label="Email" outlined v-model="user.email" dense 
				  	:error-messages="errors.email ? errors.email[0] : []"></v-text-field>
                  <v-text-field label="Telefono" outlined v-model="user.phone" dense 
				  	:error-messages="errors.phone ? errors.phone[0] : []"></v-text-field>
                  <v-text-field label="Cellulare" outlined v-model="user.mobile" dense 
				  	:error-messages="errors.mobile ? errors.mobile[0] : []"></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="6">
          <v-card outlined flat>
            <v-card-title>Informazioni personali</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="12" class="gel">
                  <v-text-field label="Codice fiscale" outlined v-model="user.fiscal_code" dense 
				  :error-messages="errors.fiscal_code ? errors.fiscal_code[0] : []"></v-text-field>
                  <v-select
                    dense
                    v-model="user.gender"
                    :items="sesso"
                    label="Sesso"
                    outlined
                  	:error-messages="errors.gender ? errors.gender[0] : []"></v-select>
                  <v-menu
                    content-class="gdate"
                    v-model="datePicker1"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="user.birth_date"
                        label="Data di nascita"
                        readonly
                        outlined
                        dense
                        v-on="on"
						:error-messages="errors.birth_date ? errors.birth_date[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="user.birth_date"
                      @input="datePicker1 = false"
                    ></v-date-picker>
                  </v-menu>
                  <v-select
                    dense
                    v-model="user.nationality"
                    :items="nazionalita"
                    label="Nazionalità"
                    outlined
                  	:error-messages="errors.nationality ? errors.nationality[0] : []"></v-select>
                  <v-select
                    dense
                    v-model="user.birth_place"
                    :items="luogo"
                    label="Luogo di nascita"
                    outlined
                  	:error-messages="errors.birth_place ? errors.birth_place[0] : []"></v-select>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="6">
          <v-card outlined flat>
            <v-card-title>Informazioni di domicilio</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="12" class="gel">
                  <v-select
                    dense
                    v-model="user.state"
                    :items="stati"
                    label="Stato"
                    outlined
                  	:error-messages="errors.state ? errors.state[0] : []"></v-select>
                  <v-select
                    dense
                    v-model="user.town"
                    :items="citta"
                    label="Città"
                    outlined
                  	:error-messages="errors.town ? errors.town[0] : []"></v-select>
                  <v-text-field
                    v-model="user.region"
                    label="Regione"
                    readonly
                    outlined
                    dense
					:error-messages="errors.region ? errors.region[0] : []"
                  ></v-text-field>
                  <v-text-field
                    v-model="user.prov"
                    label="Provincia"
                    readonly
                    outlined
                    dense
					:error-messages="errors.prov ? errors.prov[0] : []"
                  ></v-text-field>
                  <v-text-field
                    v-model="user.address"
                    label="Indirizzo"
                    outlined
                    dense
					:error-messages="errors.address ? errors.address[0] : []"
                  ></v-text-field>
                  <v-text-field
                    v-model="user.zipcode"
                    label="Codice postale"
                    outlined
                    dense
					:error-messages="errors.zipcode ? errors.zipcode[0] : []"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="6">
          <v-card outlined flat>
            <v-card-title>Altre informazioni</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="12" class="gel">
                  <v-select
                    dense
                    v-model="user.school_region"
                    :items="regioneIstituto"
                    label="Regione istituto scolastico"
                    outlined
                  	:error-messages="errors.school_region ? errors.school_region[0] : []"></v-select>
                  <v-text-field label="Istituto" outlined v-model="user.school_name" dense 
				  	:error-messages="errors.school_name ? errors.school_name[0] : []"></v-text-field>
                  <v-text-field
                    label="Codice meccanografico"
                    outlined
                    v-model="user.school_codice_meccanografico"
                    dense
					:error-messages="errors.school_codice_meccanografico ? errors.school_codice_meccanografico[0] : []"
                  ></v-text-field>
                  <v-select
                    dense
                    v-model="user.education"
                    :items="titoloStudio"
                    label="Titolo di studio"
                    outlined
                  :error-messages="errors.fiscal_code ? errors.fiscal_code[0] : []"></v-select>
                  <v-select
                    dense
                    v-model="user.employment"
                    :items="occupazione"
                    label="Occupazione"
                    outlined
                  :error-messages="errors.employment ? errors.employment[0] : []"></v-select>

                  <v-text-field
                    dense
                    readonly
                    label="Curriculum Vitae"
                    outlined
                    @click="pickFile(0)"
                    prepend-inner-icon="mdi-cloud-upload"
                    :value="doc1 ? doc1.name : '' "
					:error-messages="errors.cv ? errors.cv[0] : []"
                  ></v-text-field>
                  <input
                    type="file"
                    style="display: none"
                    ref="file0"
                    @change="handleFileUpload($event, 0)"
                  />

                  <v-select
                    dense
                    v-model="user.document_type"
                    :items="tipoDocument"
                    label="Tipo di documento"
                    outlined
                  :error-messages="errors.document_type ? errors.document_type[0] : []"></v-select>

                  <v-text-field
                    label="Numero di documento"
                    outlined
                    v-model="user.document_number"
                    dense
					:error-messages="errors.document_number ? errors.document_number[0] : []"
                  ></v-text-field>

                  <v-menu
                    content-class="gdate"
                    v-model="datePicker2"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="user.document_expire_date"
                        label="Data scadenza documento"
                        readonly
                        outlined
                        dense
                        v-on="on"
						:error-messages="errors.document_expire_date ? errors.document_expire_date[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="user.document_expire_date"
                      @input="datePicker2 = false"
                    ></v-date-picker>
                  </v-menu>

                  <v-text-field
                    dense
                    readonly
                    label="Documento di identità"
                    outlined
                    @click="pickFile(1)"
                    prepend-inner-icon="mdi-cloud-upload"
                    :value="doc2 ? doc2.name : '' "
					:error-messages="errors.document ? errors.document[0] : []"
                  ></v-text-field>
                  <input
                    type="file"
                    style="display: none"
                    ref="file1"
                    @change="handleFileUpload($event, 1)"
                  />

                  <v-select
                    dense
                    v-model="user.structure_id"
                    :items="struture"
                    label="Struttura"
                    outlined
                  	:error-messages="errors.structure_id ? errors.structure_id[0] : []"></v-select>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row v-if="isDocente">
        <v-col cols="12" md="6">
          <v-card outlined flat>
            <v-card-title>Titoli di studio</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="12" class="gel">
                  <v-text-field v-model="user.high_school_diploma_name" label="Diploma" outlined dense 
				  :error-messages="errors.high_school_diploma_name ? errors.high_school_diploma_name[0] : []"></v-text-field>

                  <v-menu
                    content-class="gdate"
                    v-model="datePicker3"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="user.high_school_diploma_date"
                        label="Data diploma"
                        readonly
                        outlined
                        dense
                        v-on="on"
						:error-messages="errors.high_school_diploma_date ? errors.high_school_diploma_institute[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="user.high_school_diploma_date"
                      @input="datePicker3 = false"
                    ></v-date-picker>
                  </v-menu>

                  <v-text-field
                    v-model="user.high_school_diploma_institute"
                    label="Istituto diploma"
                    outlined
                    dense
					:error-messages="errors.high_school_diploma_institute ? errors.high_school_diploma_institute[0] : []"
                  ></v-text-field>
                  <v-text-field
                    v-model="user.university_degree_faculty"
                    label="Facoltà universitaria"
                    outlined
                    dense
					:error-messages="errors.university_degree_faculty ? errors.university_degree_faculty[0] : []"
                  ></v-text-field>
                  <v-text-field v-model="user.university_degree_name" label="Laurea" outlined dense 
				  :error-messages="errors.university_degree_name ? errors.university_degree_name[0] : []"></v-text-field>

                  <v-menu
                    content-class="gdate"
                    v-model="datePicker4"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="user.university_degree_date"
                        label="Data laurea"
                        readonly
                        outlined
                        dense
                        v-on="on"
						:error-messages="errors.university_degree_date ? errors.university_degree_date[0] : []"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="user.university_degree_date"
                      @input="datePicker4 = false"
                    ></v-date-picker>
                  </v-menu>

                  <v-text-field
                    v-model="user.university_degree_institute"
                    label="Università"
                    outlined
                    dense
					:error-messages="errors.university_degree_institute ? errors.university_degree_institute[0] : []"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
export default {
  props: ["userType"],
  data() {
    return {
      isDocente: false,
      isEsaminatore: false,
      isSupervisore: false,
      isFormatore: false,
      date: new Date().toISOString().substr(0, 10),
      datePicker1: false,
      datePicker2: false,
      datePicker3: false,
      datePicker4: false,
      doc1: null,
      doc2: null,
      user: {
        type: this.userType,
		firstname: '',
		lastname: '',
		email: '',
        lrn_user: "",
        fiscal_code: "",
        gender: "",
        birth_date: "",
        birth_place: "",
        nationality: "",
        phone: "",
        mobile: "",
        country: "",
        region: "",
        prov: "",
        town: "",
        address: "",
        zipcode: "",
        education: "",
        employment: "",
        school_region: "",
        school_name: "",
        school_codice_meccanografico: "",
        english_level: "",
        english_level_declaration: "",
        cv: "", //file
        document_type: "",
        document: "", //file
        document_number: "",
        document_expire_date: "",
        high_school_diploma_name: "",
        high_school_diploma_date: "",
        high_school_diploma_institute: "",
        university_degree_faculty: "",
        university_degree_name: "",
        university_degree_date: "",
        university_degree_institute: "",
        structure_id: "",
        token: "",
        state: ""
      },
      sesso: ["M", "F"],
      nazionalita: [],
      luogo: [],
      stati: [],
      citta: [],
      regioneIstituto: [],
      titoloStudio: [],
      occupazione: [],
      tipoDocument: [],
	  struture: [],
	  errors: {}
    };
  },
  mounted() {
    if (this.userType === "docente") {
      this.isDocente = true;
    } else if (this.userType === "supervisore") {
      this.isSupervisore = true;
    } else if (this.userType === "esaminatore") {
      this.isEsaminatore = true;
    } else if (this.userType === "formatori") {
      this.isFormatore = true;
    } else {
      return;
    }
  },
  methods: {
    pickFile(i) {
      if (i == 0) {
        this.$refs.file0.click();
      } else if (i == 1) {
        this.$refs.file1.click();
      }
    },
    handleFileUpload(e, i) {
      if (i == 0) {
        this.doc1 = e.target.files[0];
      } else if (i == 1) {
        this.doc2 = e.target.files[0];
      }
    }
  }
};
</script>

<style>
.add-user .v-card__title {
  background: #388e3c;
  color: white;
  padding: 10px 15px;
  box-shadow: 0 19px 20px -12px rgba(0, 0, 0, 0.25);
  background: linear-gradient(45deg, #388e3c, #81c784);
  margin-bottom: 10px;
  font-size: 18px;
  font-weight: normal;
}
</style>
