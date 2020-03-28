<template>
  <div class="st-det">
    <v-row>
      <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-subheader>Informazioni di base</v-subheader>

          <v-list-item v-for="item in details.info" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>

      <v-col cols="12" md="6" v-if="details.contact && details.contact.length">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="bl">Titoli di studio</v-subheader>

          <v-list-item v-for="item in details.contact" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" md="6" v-if="details.exam && details.exam.length">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="yl">Informazioni personali</v-subheader>

          <v-list-item v-for="item in details.exam" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>


      <v-col cols="12" md="6" v-if="details.legal">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="pr">Informazioni di domicilio</v-subheader>

          <v-list-item v-for="item in details.legal" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>
    </v-row>

    <v-row v-if="!loading && details.files">
        <v-col cols="12" md="6" v-if="details.files.document_exists">
        <v-list two-line subheader v-if="!loading">
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>Documento di identità</v-list-item-title>
							<v-btn class="mt-3" large color="success"  elevation="2" :href="details.files.document" target="_blank">Vedi File</v-btn>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        </v-col>

        <v-col cols="12" md="6" v-if="details.files.cv_exists">
        <v-list two-line subheader v-if="!loading">
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>Curriculum Vitae</v-list-item-title>
							<v-btn class="mt-3" large color="success"  elevation="2" :href="details.files.cv" target="_blank">Vedi File</v-btn>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="6" v-if="details.otherinfo">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="tl">Altre informazioni</v-subheader>
          <v-list-item v-for="item in details.otherinfo" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>
      <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="cl">User Details</v-subheader>
          <v-list-item v-for="item in details.user" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>
    </v-row>
		<v-row v-if="baseinfo.corsi && baseinfo.corsi.length">
			<v-col cols="12" md="6">
				<v-list two-line subheader v-if="!loading">
					<v-subheader class="yl">Corsi</v-subheader>
					<v-list-item v-for="item in baseinfo.corsi" v-bind:key="item">
						<v-list-item-content>
							<v-list-item-title>{{item}}</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				</v-list>
			</v-col>
		</v-row>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  props: ["base_info","user_details","personal_info","address_info","education","other_info"],
  data() {
    return {
      details: {
        info: []
      },
      loading: false
    };
  },
	computed: {
		baseinfo: function(){
			return JSON.parse(this.base_info);
		},
		userdetails: function(){
			return JSON.parse(this.user_details);
		},
		personalinfo: function(){
			return JSON.parse(this.personal_info);
		},
		addressinfo: function(){
			return JSON.parse(this.address_info);
		},
		educationinfo: function(){
			return JSON.parse(this.education);
		},
		otherinfo: function(){
			return JSON.parse(this.other_info);
		},
	},
	mounted() {
    this.formatData()
	},
	methods: {
    formatData() {
			console.log(this.baseinfo.corsi)
      this.details = {
        info: [
          { n: "Nome", v: this.userdetails.firstname },
          { n: "Cognome", v: this.userdetails.lastname },
          { n: "Email", v: this.userdetails.email },
          { n: "Telefono", v: this.baseinfo.phone },
          { n: "Cellulare", v: this.baseinfo.mobile },
          { n: "Tipo utente", v: this.baseinfo.lrn_user },
        ],
        legal: [
            {n: 'Nazione', v: this.addressinfo.country},
            {n: 'Citta', v: this.addressinfo.town},
            {n: 'Regione', v: this.addressinfo.region},
            {n: 'Provinca', v: this.addressinfo.prov},
            {n: 'Cap', v: this.addressinfo.zipcode},
            {n: 'Indirizzo', v: this.addressinfo.address},
        ],
        exam: [
            {n: 'Codice fiscale', v: this.personalinfo.fiscal_code},
            {n: 'Sesso', v: this.personalinfo.gender},
            {n: 'Data di nascita', v: this.personalinfo.birth_date},
            {n: 'Luogo di nascita', v: this.personalinfo.birth_place},
            {n: 'Nazionalità', v: this.personalinfo.nationality},
        ],
        contact: [
            {n: 'Diploma', v: this.educationinfo.high_school_diploma_name},
            {n: 'Data diploma', v: this.educationinfo.high_school_diploma_date},
            {n: 'Istituto diploma', v: this.educationinfo.high_school_diploma_institute},
            {n: 'Facoltà universitaria', v: this.educationinfo.university_degree_faculty},
            {n: 'Laurea', v: this.educationinfo.university_degree_name},
            {n: 'Data laurea', v: this.educationinfo.university_degree_date},
            {n: 'Università', v: this.educationinfo.university_degree_institute},
        ],
				otherinfo: [
            {n: 'Regione istituto scolastico', v: this.otherinfo.school_region},
            {n: 'Istituto', v: this.otherinfo.school_name},
            {n: 'Codice meccanografico', v: this.otherinfo.school_codice_meccanografico},
            {n: 'Occupazione', v: this.otherinfo.employment},
            {n: 'Titolo di studio', v: this.otherinfo.education},
            {n: 'Tipo di documento', v: this.otherinfo.document_type},
            {n: 'Numero di documento', v: this.otherinfo.document_number},
            {n: 'Data scadenza documento', v: this.otherinfo.document_expire_date},
            {n: 'Struttura', v: this.otherinfo.structure},
        ],
        files: {
            cv: this.otherinfo.cv,
				  	cv_exists: this.otherinfo.cv_exists,
            document: this.otherinfo.document,
				  	document_exists: this.otherinfo.document_exists
        },
        user: [
          {n: 'Creato da', v: this.userdetails.created_by},
          {n: 'Creato a', v: this.userdetails.created_at},
          {n: 'Last Login', v: this.userdetails.last_login},
          {n: 'Last Login Ip', v: this.userdetails.last_login_ip},
          {n: 'Aggiornato da', v: this.userdetails.updated_by},
          {n: 'Data Aggiornato', v: this.userdetails.updated_at}
        ]

      };
    },
    moment: function () {
      return moment();
    }
  },
  filters: {
    moment: function (date) {
      if (!date || date === 'non disponibile') { return '-' }
      return moment(date).format('YYYY/MM/DD');
    }
  }
};
</script>

<style>
.statuses > div.active {
    border-color: #66BB6A;
}
a.v-btn {
	text-decoration: none;
}
.statuses > div.inactive {
    border-color: #ef5350;
}

.statuses > div h4 {
    font-size: 18px;
}
.statuses > div p {
    margin: 0;
}
@media all and (min-width: 900px) {
  .row.statuses {
    margin: 10px -10px;
    flex-wrap: nowrap;
  }
}
.row.statuses > div {
  margin-bottom: 10px;
}

.statuses > div {
    background: white;
    box-sizing: border-box;
    border-bottom: 5px solid white;
    margin: 0 10px;
    flex: auto;
}
.st-det .v-subheader {
    border-bottom: 1px solid #81C784;
    position: relative;
    font-weight: bold;
    color: #474747 !important;
    background: #E8F5E9;
}
.st-det .v-subheader.bl {
    border-color: #4DD0E1;
    background-color: #E0F7FA;
}
.st-det .v-subheader.yl {
    border-color: #FFEB3B;
    background: #F9FBE7;
}
.st-det .v-subheader.tl {
    border-color: #009688;
    background: #B2DFDB;
}
.st-det .v-subheader.cl {
    border-color: #00BCD4;
    background: #B2EBF2;
}
.st-det .v-subheader.pr {
    border-color: #AB47BC;
    background: #F3E5F5;
}
.statuses > div i {
    position: absolute !important;
    bottom: 10px;
    right: 10px;
}
.statuses > div i.mdi-checkbox-marked-circle-outline {
  color: #66BB6A;
}
.statuses > div i.mdi-minus-circle-outline {
  color: #ef5350;
}
</style>
