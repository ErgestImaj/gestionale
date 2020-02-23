<template>
  <v-form class="add-discount">
    <v-container>
      <v-row>
        <v-col cols="12" md="12">
          <v-card outlined flat>
            <v-card-title>
              <span>Sconti</span>
              <v-btn color="white" class="ma-0 primary--text" v-if="sconti.length != 1" @click="addNew">Add</v-btn>
            </v-card-title>
            <v-card-text>
              <v-row v-for="(s, index) in sconti" v-bind:key="index" class="justify-space-between">
                <v-col cols="12" md="5" class="gel">
                  <v-text-field label="Corsi" outlined dense v-model="sconti[index].corsi"></v-text-field>
                </v-col>
                <v-col cols="12" md="5" class="gel">
                  <v-text-field label="Sconto" outlined dense v-model="sconti[index].sconto" 
                    suffix="%" type="number" min="0" max="100"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="1">
                    <v-btn text icon color="grey" @click="remove(index)" v-if="sconti.length != 1">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-btn text icon v-else color="primary" class="mr-2 white--text" @click="addNew">
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" sm="12">
          <v-btn
            :loading="submiting"
            :disabled="submiting"
            color="primary"
            class="ma-0 white--text"
            @click="send"
          >Salva</v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>
<script>
export default {
  props: ['stuctureId'],
  data() {
    return {
        submiting: false,
        sconti: []
    };
  },
  mounted() {
    this.addNew();
    console.log(this.stuctureId);
  },
  methods: {
    addNew() {
      this.sconti.push({
        corsi: "",
        sconto: ""
      });
    },
    remove(i) {
        this.sconti = this.sconti.filter((s, index) => index !== i );
    },
    send() {
        //
    }
  }
};
</script>
<style>
.add-discount .v-card__title {
  background: #388e3c;
  color: white;
  padding: 10px 15px;
  box-shadow: 0 19px 20px -12px rgba(0, 0, 0, 0.25);
  background: linear-gradient(45deg, #388e3c, #81c784);
  margin-bottom: 10px;
  font-size: 18px;
  font-weight: normal;
  display: flex;
  justify-content: space-between;
}
</style>