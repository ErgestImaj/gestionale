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
                    v-model="user.first_name"
                    dense
                    :error-messages="errors.first_name ? errors.first_name[0] : []"
                  ></v-text-field>
                  <v-text-field
                    label="Cognome"
                    outlined
                    v-model="user.last_name"
                    dense
                    :error-messages="errors.last_name ? errors.last_name[0] : []"
                  ></v-text-field>
                  <v-text-field
                    label="Email"
                    outlined
                    v-model="user.email"
                    dense
                    :error-messages="errors.email ? errors.email[0] : []"
                  ></v-text-field>
									<v-text-field
                    label="Password"
                    outlined
										type="password"
                    v-model="user.password"
                    dense
                    :error-messages="errors.password ? errors.password[0] : []"
                  ></v-text-field>
									<v-row>
										<v-col cols="10">
											<v-text-field
												dense
												readonly
												label="Immagine Profilo"
												outlined
												@click="pickFile()"
												:error-messages="errors.image ? errors.image[0] : []"
												prepend-inner-icon="mdi-cloud-upload"
												:value="image ? image.name : '' "
											></v-text-field>
											<input
												type="file"
												style="display: none"
												ref="file"
												@change="handleFileUpload($event)"
											/>
										</v-col>
										<v-col cols="2" v-if="user.avatar" class="text-right">
											<v-btn class="icon-space" :href="user.avatar" color="primary" target="_blank" dark>
												<v-icon dark>mdi-eye</v-icon>
											</v-btn>
										</v-col>
									</v-row>
                    <v-select
                        v-if="isTutor"
                        dense outlined label="Corsi" multiple
                        v-model="user.corsi"
                        :items="corsi"
												item-text="name"
												item-value="id"
                        :error-messages="errors.corsi ? errors.corsi[0] : []"
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
            color="info"
            class="ma-0 white--text"
            @click="modify"
          >Modifica utente</v-btn>
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
      isTutor: false,
      submiting: false,
			image:'',
      user: {
        type: this.userType,
      },
      corsi: [],
      errors: {}
    };
  },
  mounted() {
    if (this.userType === "tutori") {
      this.isTutor = true;
      this.getCourses()
    }
   this.getUser()
  },
  methods: {
    modify() {
			if (!this.submiting) {
				this.submiting = true;
				let formData = new FormData();
				formData.append("image", this.image);
				formData.append("user", JSON.stringify(this.user));
				axios.post(`/utenti/api/${getUrlData(2)}/update`,formData,
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
		pickFile() {
				this.$refs.file.click();
		},
		handleFileUpload(e, i) {
				this.image = e.target.files[0];
		},
		getCourses(){
			axios.get(`/filter-courses`)
				.then(response => {
					if (response.data) {
						this.corsi = response.data;
					}
				})
				.catch(error => {

				})
		},
		getUser(){
			axios.get(`/utenti/api/${getUrlData(2)}/edit`)
				.then(response => {
					if (response.data) {
						this.user = response.data.user;
						this.user.corsi = response.data.corsi;
					}
				})
				.catch(error => {

				})
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
.icon-space {
	margin-top: 2px;
}
</style>
