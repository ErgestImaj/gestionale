<template>
	<v-form class="add-tracking">
		<v-container>
			<v-row>
				<v-col cols="12" xl="8" lg="9" md="12" class="gmidrow">
					<v-card outlined flat>
						<v-card-title>Informazioni di base</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-autocomplete
										dense outlined
										label="Corso"
										v-model="content.course_id"
										:items="courses"
										item-text="name"
										item-value="id"
										:error-messages="getError('course_id')"
									></v-autocomplete>

									<v-menu content-class="gdate" v-model="datePicker1" :close-on-content-click="false"
													transition="scale-transition" offset-y min-width="290px">
										<template v-slot:activator="{ on }">
											<v-text-field readonly outlined dense v-on="on"
																		v-model="date"
																		label="Data"
																		:error-messages="getError('date')"
											></v-text-field>
										</template>
										<v-date-picker v-model="content.date" @input="datePicker1 = false"></v-date-picker>
									</v-menu>

									<v-text-field dense outlined disabled
																label="Chiusura prenotazioni"
																v-model="content.end_date"
																:error-messages="getError('end_date')"
									></v-text-field>

									<v-row v-if="show">
										<v-col  cols="12" md="6">
											<v-menu ref="menu" :close-on-content-click="false" transition="scale-transition"
												offset-y max-width="290px" min-width="290px" content-class="gdate"
												v-model="timePicker1"
												:return-value.sync="content.start_hour"
											>
												<template v-slot:activator="{ on }">
													<v-text-field
														v-model="content.start_hour"
														label="Ora inizio"
														readonly dense outlined
														v-on="on"
													></v-text-field>
												</template>
												<v-time-picker
													v-if="timePicker1"
													v-model="content.start_hour"
													full-width format="24hr"
													min="7:00"
													max="21:45"
													@click:minute="$refs.menu.save(content.start_hour)"
												></v-time-picker>
											</v-menu>
										</v-col>
										<v-col  cols="12" md="6">
											<v-menu ref="menu2" :close-on-content-click="false" transition="scale-transition"
												offset-y max-width="290px" min-width="290px" content-class="gdate"
												v-model="timePicker2"
												:return-value.sync="content.end_hour"
											>
												<template v-slot:activator="{ on }">
													<v-text-field
														v-model="content.end_hour"
														label="Ora fine"
														readonly dense outlined
														v-on="on"
													></v-text-field>
												</template>
												<v-time-picker
													v-if="timePicker2"
													v-model="content.end_hour"
													full-width format="24hr"
													min="7:00"
													max="21:45"
													@click:minute="$refs.menu2.save(content.end_hour)"
												></v-time-picker>
											</v-menu>
										</v-col>
									</v-row>

									<span class="mr-3">Sede:</span>

									<v-btn-toggle v-model="content.location_id" group mandatory color="primary">
										<v-btn value="0">Sede Operativa</v-btn>
										<v-btn value="1">Altra Sede</v-btn>
									</v-btn-toggle>

									<v-text-field dense outlined v-if="content.location_id == 1"
																label="Sede"
																v-model="content.location"
																:error-messages="getError('location')"
									></v-text-field>

									<v-autocomplete
										dense outlined
										label="Esaminatore"
										v-model="content.examiner_id"
										:items="esaminators"
										item-text="display_name"
										item-value="id"
										:error-messages="getError('examiner_id')"
									></v-autocomplete>
									<v-autocomplete
										dense outlined
										label="Invigilator"
										v-model="content.invigilator_id"
										:items="invigilators"
										item-text="display_name"
										item-value="id"
										:error-messages="getError('invigilator_id')"
									></v-autocomplete>
									<v-autocomplete
										dense outlined
										label="Investigatore"
										v-model="content.investigator_id"
										:items="investigators"
										item-text="display_name"
										item-value="id"
										:error-messages="getError('investigator_id')"
									></v-autocomplete>
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
						@click="save"
					>Salva</v-btn>
				</v-col>
			</v-row>
		</v-container>
	</v-form>
</template>

<script>
    import moment from 'moment'
    export default {
    	props:['type'],
        data() {
            return {
              	show:false,
                submiting: false,
                content: {},
                errors: {},
                datePicker1: false,
                timePicker1: false,
                timePicker2: false,
                courses: [],
								esaminators: [],
                invigilators: [],
								investigators: []
            };
        },
        mounted() {
        	this.getAvailableCourses();
        	this.getEsaminators();
        	this.getInvigilators();
        	this.getInvestigators();
        },
        methods: {
            save() {
							if (!this.submiting){
								this.submiting = true;
								axios.post(`/exams/api/lrn-exams/store`,this.content)
									.then(response => {
										if (response.data.status == "success") {
											swal("Good job!", response.data.msg, "success");
											// setTimeout(function () {
											// 	window.location.href = response.data.redirect;
											// }, 1500)
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
										this.errors = error.response.data.errors
									})
									.finally(() => {
										this.submiting = false;
									})
							}
            },
					  getAvailableCourses(){
							axios.get(`/amministrazione/api/get-structure-available-course/${this.type}`).then(response => {
								this.courses = response.data;
							});
						},
				  	getEsaminators(){
							axios.get(`/amministrazione/api/structure/get-examiners/${this.type}`).then(response => {
								this.esaminators = response.data;
							});
						},
				  	getInvigilators(){
							axios.get(`/amministrazione/api/structure/get-invigilators/${this.type}`).then(response => {
								this.invigilators = response.data;
							});
						},
					  getInvestigators(){
							axios.get(`/utenti/api/ispettori`).then(response => {
								this.investigators = response.data;
							});
						},
            getError(field) {
                return this.errors[field] ? this.errors[field][0] : []
            },
            moment: function () {
                return moment();
            },
        },
        computed: {
            date() {
                if (!this.content.date) { return  '' }
                return moment(this.content.date, 'YYYY-MM-DD').format('DD-MM-YYYY').toString();
            }
        },
        watch: {
            date(val) {
                if (!!val) {
                    let expiry = moment(val, 'DD-MM-YYYY').add(-7, 'days').format('DD-MM-YYYY');
                    this.$set(this.content, 'end_date', expiry.toString());
                }
            }
        }
    };
</script>

<style>
	.add-tracking .v-card__title {
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
