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
									<v-text-field dense outlined
										label="Codice"
										v-model="content.code"
										:error-messages="getError('code')"
									></v-text-field>

									<v-menu content-class="gdate" v-model="datePicker1" :close-on-content-click="false"
										transition="scale-transition" offset-y min-width="290px">
										<template v-slot:activator="{ on }">
											<v-text-field readonly outlined dense v-on="on"
												v-model="sendDate"
												label="Data di spedizione"
												:error-messages="getError('send_date')"
											></v-text-field>
										</template>
										<v-date-picker v-model="content.send_date" @input="datePicker1 = false"></v-date-picker>
									</v-menu>

									<v-menu content-class="gdate" v-model="datePicker2" :close-on-content-click="false"
										transition="scale-transition" offset-y min-width="290px">
										<template v-slot:activator="{ on }">
											<v-text-field readonly outlined dense v-on="on"
												v-model="receivedDate"
												label="Data ricevuta"
												:error-messages="getError('estimate_date')"
											></v-text-field>
										</template>
										<v-date-picker v-model="content.estimate_date" @input="datePicker2 = false"></v-date-picker>
									</v-menu>

									<v-text-field dense outlined disabled
										label="Data di scadenza"
										v-model="content.expiry_date"
										:error-messages="getError('expiry_date')"
									></v-text-field>

									<v-text-field dense outlined
										label="Numero certificati"
										v-model="content.nr_certificates"
										:error-messages="getError('nr_certificates')"
									></v-text-field>

									<v-autocomplete
										dense outlined
										label="Sessione d'esame"
										v-model="content.lrn_exam_session_id"
										:items="exams"
										item-text="displayValue"
										item-value="id"
										:error-messages="getError('lrn_exam_session_id')"
									></v-autocomplete>

									<v-text-field dense outlined disabled
																label="Structura"
																v-model="content.structure"
									></v-text-field>

									<span class="mr-3">Stato:</span>

									<v-btn-toggle v-model="content.status" group mandatory color="primary">
										<v-btn value="0">Da spedire</v-btn>
										<v-btn value="1">In consegna</v-btn>
										<v-btn value="2">Ricevuto</v-btn>
										<v-btn value="3">Expired</v-btn>
									</v-btn-toggle>

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
        data() {
            return {
                submiting: false,
								content: {},
                errors: {},
                datePicker1: false,
                datePicker2: false,
								exams: [],
            };
        },
        mounted() {
            this.getExams();
        },
        methods: {
            save() {
							if (!this.submiting){
								this.submiting = true;
								axios.post(`/tracking/store`,this.content)
									.then(response => {
										if (response.data.status == "success") {
											swal("Good job!", response.data.msg, "success");
											setTimeout(function () {
												window.location.href = response.data.redirect;
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
										this.errors = error.response.data.errors
									})
									.finally(() => {
										this.submiting = false;
									})
							}
            },
						getExams() {
                axios.get(`/exams/api/lrn-exams`).then(response => {
                    let exams = response.data;
                    exams.forEach(e => {
                        e.displayValue = e.course.name + ' --- ' + moment(e.date, 'YYYY-MM-DD').format('DD-MM-YYYY');
										});
                    this.exams = exams;
								})
						},
            getError(field) {
                return this.errors[field] ? this.errors[field][0] : []
            },
            moment: function () {
                return moment();
            },
        },
				computed: {
            receivedDate() {
                if (!this.content.estimate_date) { return  '' }
                return moment(this.content.estimate_date, 'YYYY-MM-DD').format('DD-MM-YYYY').toString();
            },
            sendDate() {
                if (!this.content.send_date) { return  '' }
                return moment(this.content.send_date, 'YYYY-MM-DD').format('DD-MM-YYYY').toString();
            },
						selExam() {
                return this.content.lrn_exam_session_id;
						}
        },
				watch: {
            receivedDate(val) {
                if (!!val) {
                    let expiry = moment(val, 'DD-MM-YYYY').add('days', 10).format('DD-MM-YYYY');
                    this.$set(this.content, 'expiry_date', expiry.toString());
								}
						},
						selExam(val) {
                this.exams.forEach(e => {
                    if (e.id == val) {
                        this.$set(this.content, 'structure', e.owner.firstname.toString());
                        this.$set(this.content, 'user_id', e.owner.id);
										}
								})
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
