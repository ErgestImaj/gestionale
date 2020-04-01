<template>
  <v-form class="add-discount">
    <v-container>
      <v-row>
        <v-col cols="12" md="12">
          <v-card outlined flat>
            <v-card-title class="addd">
              <span>Sconti</span>
              <v-btn color="white" class="ma-0 primary--text" v-if="sconti.length != 1" @click="addNew">Aggiungi</v-btn>
            </v-card-title>
            <v-card-text>
              <v-row v-for="(s, index) in sconti" v-bind:key="index" class="justify-space-between">
                <v-col cols="12" md="5" class="gel">
                  <v-text-field label="Corsi" outlined dense
																v-model="sconti[index].corsi"
																:error-messages="errors[index+'.corsi'] ?errors[index+'.corsi'] : []"
									></v-text-field>
                </v-col>
                <v-col cols="12" md="5" class="gel">
                  <v-text-field label="Sconto" outlined dense
																v-model="sconti[index].sconto"
																:error-messages="errors[index+'.sconto'] ?errors[index+'.sconto'] : []"
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

      <v-row>
          <v-col cols="12" md="12">
          <v-card>
            <v-card-title>
                Sconti Precendenti
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    label="Cerca"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="prevSconti"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
								  	<a icon class="delete-btn" :data-content="trans('messages.delete_record')" :data-action="`/amministrazione/api/sconto/${item.hashid}`" href="#">
                        <v-icon>mdi-delete</v-icon>
                    </a>
                </template>
            </v-data-table>
        </v-card>
        </v-col>
      </v-row>
    </v-container>
		<v-container>
			<v-row>
				<v-col cols="12" md="12">
					<v-card outlined flat>
						<v-card-title class="addd">
							<span>Assegna corsi</span>
						</v-card-title>
						<v-card-text>
							<v-row class="justify-space-between">
								<v-col cols="12" md="5" class="gel">
									<v-select
										dense outlined label="Corsi"
										v-model="trasaction.course"
										:items="courses"
										item-text="name"
										item-value="id"
										:error-messages="corsiErrors.course ?corsiErrors.course[0] : []"
									></v-select>
								</v-col>
								<v-col cols="12" md="5" class="gel">
									<v-text-field label="Numero corsi" outlined dense
																v-model="trasaction.qty"
																:error-messages="corsiErrors.qty ? corsiErrors.qty[0] : []"
																 type="number"
									></v-text-field>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>

			<v-row>
				<v-col cols="12" sm="12">
					<v-btn
						:loading="submitingCourse"
						:disabled="submitingCourse"
						color="primary"
						class="ma-0 white--text"
						@click="addCourse"
					>Salva</v-btn>
				</v-col>
			</v-row>

			<v-row>
				<v-col cols="12" md="12">
					<v-card>
						<v-card-title>
							Corsi Assegnati
							<v-spacer></v-spacer>
							<v-text-field
								v-model="searchcourses"
								label="Cerca"
								single-line
								hide-details
							></v-text-field>
						</v-card-title>
						<v-data-table
							:headers="headersCourses"
							:items="prevAssignedCourses"
							:search="searchcourses"
							:loading="loadingcourses"
						>
							<template v-slot:item.actions="{ item }">
								<a icon class="delete-btn" :data-content="trans('messages.delete_record')" :data-action="`/amministrazione/api/transaction/${item.hashid}/destroy`" href="#">
									<v-icon>mdi-delete</v-icon>
								</a>
							</template>
						</v-data-table>
					</v-card>
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
        submitingCourse: false,
        sconti: [],
		  	trasaction: {},
			  courses:[],
        prevSconti: [],
        prevAssignedCourses: [],
        search: '',
        searchcourses: '',
	  		errors: {},
		  	corsiErrors: {},
        headers: [
            {text: '#', value: 'id'},
            {text: 'Nr Corsi', value: 'corsi'},
            {text: 'Sconto %', value: 'sconto'},
            {text: 'Creato a', value: 'created_at'},
            {text: 'Creato da', value: 'user.display_name'},
            {text: 'Azioni', value: 'actions', sortable: false, align: 'right'},
        ],
			   headersCourses: [
            {text: '#', value: 'id'},
            {text: 'Corso', value: 'course.name'},
            {text: 'Quantità', value: 'qty'},
            {text: 'Creato a', value: 'created'},
            {text: 'Creato da', value: 'user.display_name'},
            {text: 'Azioni', value: 'actions', sortable: false, align: 'right'},
        ],
        loading: true,
        loadingcourses: true,
    };
  },
  mounted() {
    this.addNew();
    this.getSconti();
    this.getCourses();
    this.getAssignedCourses();
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
			if (!this.submiting) {
				this.submiting = true;
				axios.post(`/amministrazione/api/${this.stuctureId}/sconto/store`,this.sconti)
					.then(response => {
					this.submiting = false
					if (response.data.status == 'success') {
						swal("Good job!", response.data.msg, "success");
						this.getSconti()
					} else if (response.data.status === 'error') {
						swal({
							title: "Whoops!",
							text: response.data.msg,
							icon: "warning",
							dangerMode: true,
						});
						this.submiting = false
					}
				}).catch(error => {
					this.submiting = false
					this.errors = error.response.data.errors
				})
			}
    },
		addCourse() {
			if (!this.submitingCourse) {
				this.submitingCourse = true;
				axios.post(`/amministrazione/api/${this.stuctureId}/transaction/store`, this.trasaction)
					.then(response => {
					this.submitingCourse = false
					if (response.data.status == 'success') {
						swal("Good job!", response.data.msg, "success");
						this.getAssignedCourses()
					} else if (response.data.status === 'error') {
						swal({
							title: "Whoops!",
							text: response.data.msg,
							icon: "warning",
							dangerMode: true,
						});
						this.submitingCourse = false
					}
				}).catch(error => {
					this.submitingCourse = false
					this.corsiErrors = error.response.data.errors
				})
			}
    },
    getSconti() {
			axios.get(`/amministrazione/api/${this.stuctureId}/sconto/`)
				.then(response => {
					this.loading = false;
				  this.prevSconti = response.data.discounts
				})
				.catch(error => {
					this.loading = false;
				});


    },
		getAssignedCourses() {
			axios.get(`/amministrazione/api/${this.stuctureId}/coursetransactions/`)
				.then(response => {
					this.loadingcourses = false;
				  this.prevAssignedCourses = response.data
				})
				.catch(error => {
					this.loadingcourses = false;
				});


    },
		getCourses(){
			axios.get(`/filter-courses`)
				.then(response => {
					if (response.data) {
						this.courses = response.data;
					}
				})
				.catch(error => {

				})
		}
  }
};
</script>
<style>
.add-discount .v-card__title.addd {
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
