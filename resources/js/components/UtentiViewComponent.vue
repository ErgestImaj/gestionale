<template>
  <div>
    <v-btn @click="addUtente()" class="gadd">Aggiungi {{userType}}</v-btn>
    <v-card>
      <v-card-title>
         {{userType | capitalize}}
        <v-spacer></v-spacer>
        <v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
      </v-card-title>
      <v-data-table :headers="headers" :items="utenti" :search="search" :loading="loading">
				<template v-slot:item.state="{ item }">
					<v-icon>{{item.state == 1 ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
				</template>
        <template v-slot:item.actions="{ item }">
          <v-menu bottom left content-class="gactions">
            <template v-slot:activator="{ on }">
              <v-btn icon v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>

						<v-list dense>
							<template v-for="(m, i) in menuItems">
								<v-list-item
									class="update-btn" v-if="m.id == 4" :key="i"
									link :data-action="`/amministrazione/admin/status/${item.hashid}`">
									<v-list-item-icon>
										<v-icon>{{item.state ? 'mdi-minus-circle-outline' : 'mdi-checkbox-marked-circle-outline' }}</v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ item.state ? m.title2 : m.title }}</v-list-item-title>
								</v-list-item>
								<v-list-item
									v-else-if="m.id == 5" :key="i"
									class="post-action"
									:data-content="trans('messages.send_reset_link_confirm')"
									:data-action="`/amministrazione/send-invitation-link/${item.hashid}`"
									link
								>
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>
								<v-list-item v-else-if="m.id == 6" :key="i"
														 class="sender-email"
														 :data-action="`/amministrazione/send-email-to-single-user/${item.hashid}`"
														 link
								>
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>
								<v-list-item v-else-if="m.id ==7" :key="i"
														 class="delete-btn"
														 :data-content="trans('messages.delete_record')"
														 :data-action="`/amministrazione/admin/delete/${item.hashid}`"
														 link
								>
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>

								<v-list-item v-else :key="i" @click="menuClick(m.id, item)">
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>
							</template>
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
        loading: true,
        isDocente: false,
        isEsaminatore: false,
        isSupervisore: false,
        isFormatore: false,
        utenti: [],
				menuItems: [
					{ id: 1, title: "Edit", icon: "mdi-pencil-outline" },
					{ id: 2, title: "View", icon: "mdi-eye-outline" },
					{ id: 3, title: "Switch Account", icon: "mdi-account-convert" },
					{ id: 4, title: "Enable", title2: "Disable", icon: "" },
					{ id: 5, title: "Invia link di accesso", icon: "mdi-account-key-outline" },
					{ id: 6, title: "Invia Email", icon: "mdi-email-send-outline" },
					{ id: 7, title: "Delete Account", icon: "mdi-trash-can-outline" }
				],
        headers: [
            {
                text: "#",
                value: "id"
            },
            {
              text: 'Nome',
              value: 'firstname'
            },
            {
              text: 'Cognome',
              value: 'lastname'
            },
            {
              text: 'Email',
              value: 'email'
            },{
              text: 'Codice Fiscale',
              value: 'user_info.fiscal_code'
            },{
              text: 'Tipo',
              value: 'user_info.type'
            }, {
              text: 'Sesso',
              value: 'user_info.gender'
            },{
              text: 'Creato da',
              value: 'user.display_name'
            }, {
              text: 'Stato',
              value: 'state'
            },
            { text: "Actions", value: "actions", sortable: false, align: "right" }
        ],
    };
  },
  mounted() {
		this.getUserType();

    if (this.userType === "docenti") {
      this.isDocente = true;
    } else if (this.userType === "supervisori") {
      this.isSupervisore = true;
    } else if (this.userType === "esaminatori") {
      this.isEsaminatore = true;
    } else if (this.userType === "formatori") {
      this.isFormatore = true;
    } else {
      return;
    }
  },
  methods: {
		menuClick(id, item) {
			switch (id) {
				case 1:
					this.edit(item);
					break;
				case 2:
					this.view(item);
					break;
				case 3:
					this.switchAccount(item);
					break;
			}
		},
		getUserType(){
				axios
					.get(`/utenti/api/get-user/${this.userType}`)
					.then(response => {
						this.utenti = response.data;
					})
					.catch(error => {})
					.finally(() => {
						this.loading = false;
					});
		},
		edit(item) {
			let nUrl =
				window.location.origin +
				"/amministrazione/struture/" +
				item.hashid +
				"/edit";
			window.location.href = nUrl;
		},
		view(item) {
			let nUrl =
				window.location.origin +
				"/amministrazione/struture/" +
				item.hashid +
				"/view";
			window.location.href = nUrl;
		},
		switchAccount(item) {
			let nUrl =
				window.location.origin +
				"/amministrazione/login-as-user/" +
				item.hashid;
			window.location.href = nUrl;
		},
    addUtente() {
      let nUrl = window.location.origin + "/utenti/"+ this.userType +"/create";
      window.location.href = nUrl;
    }
  }
};
</script>
<style>
	.update-btn,
	.delete-btn,
	.post-action,
	.sender-email {
		color: rgba(0, 0, 0, 0.87) !important;
	}
	.v-list-item--dense .v-list-item__icon, .v-list--dense .v-list-item .v-list-item__icon {
		height: 24px;
		margin-top: 6px;
		margin-bottom: 6px;
		margin-right: 14px;
	}
</style>
