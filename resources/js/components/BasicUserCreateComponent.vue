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
                  <v-text-field
                    label="Nome"
                    outlined
                    v-model="user.firstname"
                    dense
                    :error-messages="errors.firstname ? errors.firstname[0] : []"
                  ></v-text-field>
                  <v-text-field
                    label="Cognome"
                    outlined
                    v-model="user.lastname"
                    dense
                    :error-messages="errors.lastname ? errors.lastname[0] : []"
                  ></v-text-field>
                  <v-text-field
                    label="Email"
                    outlined
                    v-model="user.email"
                    dense
                    :error-messages="errors.email ? errors.email[0] : []"
                  ></v-text-field>
                    <v-select
                        v-if="isTutor"
                        dense outlined label="Corsi" multiple
                        v-model="user.corsi"
                        :items="corsi"
                        :error-messages="errors.structure_id ? errors.structure_id[0] : []"
                    ></v-select>
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
          >Add User</v-btn>
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
      isInspector: false,
      isTutor: false,
      submiting: false,
      user: {
        type: this.userType,
        firstname: "",
        lastname: "",
        email: ""
      },
      corsi: ['cors1', 'cors2', 'cors3'],
      errors: {}
    };
  },
  mounted() {
    if (this.userType === "ispettori") {
      this.isInspector = true;
    } else if (this.userType === "tutori") {
      this.isTutor = true;
    } else {
      return;
    }
  },
  methods: {
    send() {
        //
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
