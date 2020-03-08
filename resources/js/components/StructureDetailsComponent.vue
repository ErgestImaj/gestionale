<template>
  <div class="st-det">
    <v-row class="statuses" v-if="!loading">
      <v-col cols="12" md="3" :class="details.statuses.status_mf == 1 ? 'active' : 'inactive'">
        <h4>MEDIAFORM</h4>
        <p>{{details.statuses.data_mf}}</p>
        <v-icon>{{details.statuses.data_mf != 'non disponibile' ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
      </v-col>
      <v-col cols="12" md="3" :class="details.statuses.status_lrn == 1 ? 'active' : 'inactive'">
        <h4>LRN</h4>
        <p>{{details.statuses.data_lrn}}</p>
        <v-icon>{{details.statuses.data_lrn != 'non disponibile' ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
      </v-col>
      <v-col cols="12" md="3" :class="details.statuses.status_dile == 1 ? 'active' : 'inactive'">
        <h4>DILE</h4>
        <p>{{details.statuses.data_dile}}</p>
        <v-icon>{{details.statuses.data_dile != 'non disponibile' ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
      </v-col>
      <v-col cols="12" md="3" :class="details.statuses.status_iiq == 1 ? 'active' : 'inactive'">
        <h4>IIQ</h4>
        <p>{{details.statuses.data_iiq}}</p>
        <v-icon>{{details.statuses.data_iiq != 'non disponibile' ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
      </v-col>
      <v-col cols="12" md="3" :class="details.statuses.status_miur == 1 ? 'active' : 'inactive'">
        <h4>MIUR</h4>
        <p>{{details.statuses.data_miur}}</p>
        <v-icon>{{details.statuses.data_miur != 'non disponibile' ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-subheader>Info Generale</v-subheader>

          <v-list-item v-for="item in details.info" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>


      <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="bl">Informazioni di contatto</v-subheader>

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
      <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="yl">Sedi Esame</v-subheader>

          <v-list-item v-for="item in details.exam" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>


      <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="pr">Sede Legale</v-subheader>

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
        <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>Domanda Accreditamento</v-list-item-title>
              <v-list-item-subtitle>{{details.files.validation_request}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        </v-col>

        <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>Visura Camerale</v-list-item-title>
              <v-list-item-subtitle>{{details.files.visura_camerale}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="6">
        <v-list two-line subheader v-if="!loading">
          <v-subheader class="yl">User Details</v-subheader>
          <v-list-item v-for="item in details.user" v-bind:key="item.n">
            <v-list-item-content>
              <v-list-item-title>{{item.n}}</v-list-item-title>
              <v-list-item-subtitle>{{item.v ? item.v : '-'}}</v-list-item-subtitle>
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
  props: ["structure"],
  data() {
    return {
      details: {
        info: []
      },
      loading: true
    };
  },
  mounted() {
    this.getDetails();
  },
  methods: {
    getDetails() {
      axios
        .get(`/amministrazione/struture/${this.structure}/show/`)
        .then(response => {
          this.formatData(response.data);
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    formatData(data) {
      let sd = data.structure_details;
      let ud = data.user_details;
      this.details = {
        info: [
          { n: "Nome", v: sd.name },
          { n: "Ragione", v: sd.legal_name },
          { n: "PIVA", v: sd.piva },
          { n: "Codice Fiscale", v: sd.tax_code },
          { n: "Codice Destionario", v: sd.codice_destinatario },
          { n: "Codice LRN", v: sd.lrn_code }
        ],
        legal: [
            {n: 'Nazione', v: sd.legal_country},
            {n: 'Citta', v: sd.legal_town},
            {n: 'Regione', v: sd.legal_region},
            {n: 'Provinca', v: sd.legal_prov},
            {n: 'Cap', v: sd.legal_zipcode},
            {n: 'Indirizzo', v: sd.legal_address},
        ],
        exam: [
            {n: 'Nazione', v: sd.operational_country},
            {n: 'Citta', v: sd.operational_town},
            {n: 'Regione', v: sd.operational_region},
            {n: 'Provinca', v: sd.operational_province},
            {n: 'Cap', v: sd.operational_zipcode},
            {n: 'Indirizzo', v: sd.operational_address},
        ],
        contact: [
            {n: 'Telefono', v: sd.phone},
            {n: 'Fax', v: sd.fax},
            {n: 'Email', v: sd.email},
            {n: 'PEC', v: sd.pec},
            {n: 'Sito', v: sd.website},
            {n: 'Strutura Madre', v: sd.structura_madre},
        ],
        files: {
            validation_request: sd.validation_request,
            visura_camerale: sd.visura_camerale
        },
        statuses: data.status_details,
        user: [
          {n: 'Creato da', v: ud.created_by},
          {n: 'Creato a', v: ud.created_at},
          {n: 'Username', v: ud.username},
          {n: 'Last Login', v: ud.last_login},
          {n: 'Last Login Ip', v: ud.last_login_ip},
          {n: 'Aggiornato da', v: ud.updated_by},
          {n: 'Data Aggiornato', v: ud.updated_at}
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
