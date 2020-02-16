<template>
  <div>
    <v-btn @click="addUtente()" class="gadd">Add Utente</v-btn>
    <v-card>
      <v-card-title>
        Utenti - {{userType}}
        <v-spacer></v-spacer>
        <v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
      </v-card-title>
      <v-data-table :headers="headers" :items="utenti" :search="search" :loading="loading">
        <template v-slot:item.actions="{ item }">
          <v-menu bottom left content-class="gactions">
            <template v-slot:activator="{ on }">
              <v-btn icon v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item v-for="(m, i) in menuItems" :key="i" @click="menuClick(m.title, item)">
                <v-list-item-title>{{ m.title }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
export default {
  props: ["userType"],
  data() {
    return {
        search: "",
        loading: "",
        isDocente: false,
        isEsaminatore: false,
        isSupervisore: false,
        isFormatore: false,
        utenti: [],
        menuItems: [
            { title: "Edit" },
            { title: "View" },
            { title: "---" }
        ],
        headers: [
            {
                text: "#",
                value: "id"
            },
            { text: "actions", value: "actions", sortable: false, align: "right" }
        ],
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
    menuClick(name, item) {
      switch (name) {
        case "Edit":
          this.edit(item);
          break;
        case "View":
          this.view(item);
          break;
      }
    },
    edit(item) {
      console.log("edit", item.id);
    },
    view(item) {
      console.log("view", item.id);
    },
    addUtente() {
      let nUrl = window.location.origin + "/amministrazione/utenti/"+ this.userType +"/create";
      window.location.href = nUrl;
    }
  }
};
</script>

<style>
</style>
