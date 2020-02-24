<template>
  <div class="st-det">
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

    <v-row class="statuses" v-if="!loading">
      <v-col cols="12" md="3" :class="details.statuses.status_lrn == 1 ? 'active' : 'inactive'">
        <h4>LRN</h4>
        <p>{{details.statuses.date_lrn ? details.statuses.date_lrn : '-'}}</p>
      </v-col>
      <v-col cols="12" md="3" :class="details.statuses.status_dile == 1 ? 'active' : 'inactive'">
        <h4>DILE</h4>
        <p>{{details.statuses.date_dile ? details.statuses.date_dile : '-'}}</p>
      </v-col>
      <v-col cols="12" md="3" :class="details.statuses.status_iiq == 1 ? 'active' : 'inactive'">
        <h4>IIQ</h4>
        <p>{{details.statuses.date_iiq ? details.statuses.date_iiq : '-'}}</p>
      </v-col>
      <v-col cols="12" md="3" :class="details.statuses.status_miur == 1 ? 'active' : 'inactive'">
        <h4>MIUR</h4>
        <p>{{details.statuses.date_miur ? details.statuses.date_miur : '-'}}</p>
      </v-col>
    </v-row>
  </div>
</template>

<script>
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
      this.details = {
        info: [
          { n: "Nome", v: data.name },
          { n: "Ragione", v: data.legal_name },
          { n: "PIVA", v: data.piva },
          { n: "Codice Fiscale", v: data.tax_code },
          { n: "Codice Destionario", v: data.codice_destinatario }
        ],
        legal: [
            {n: 'Nazione', v: data.country.name},
            {n: 'Citta', v: data.town.title},
            {n: 'Regione', v: data.region.title},
            {n: 'Provinca', v: data.province.title},
            {n: 'Cap', v: data.legal_zipcode},
            {n: 'Indirizzo', v: data.legal_address},
        ],
        exam: [
            {n: 'Nazione', v: data.operational_country.name},
            {n: 'Citta', v: data.operational_town.title},
            {n: 'Regione', v: data.operational_region.title},
            {n: 'Provinca', v: data.operational_province.title},
            {n: 'Cap', v: data.operational_zipcode},
            {n: 'Indirizzo', v: data.operational_address},
        ],
        contact: [
            {n: 'Telefono', v: data.phone},
            {n: 'Fax', v: data.fax},
            {n: 'Email', v: data.email},
            {n: 'PEC', v: data.pec},
            {n: 'Sito', v: data.website},
        ],
        files: {
            validation_request: data.validation_request,
            visura_camerale: data.visura_camerale
        },
        statuses: data.status
      
      };
    }
  }
};
</script>

<style>
.statuses > div.active {
    border-color: #66BB6A;
}

.statuses > div h4 {
    font-size: 18px;
}
.statuses > div p {
    margin: 0;
}
.row.statuses {
    margin: 10px -10px 0;
    flex-wrap: nowrap;
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
</style>