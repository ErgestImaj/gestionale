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
										label="Nome"
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
												:error-messages="getError('received_date')"
											></v-text-field>
										</template>
										<v-date-picker v-model="content.received_date" @input="datePicker2 = false"></v-date-picker>
									</v-menu>

									<v-text-field dense outlined disabled
										label="Expiry date"
										v-model="content.expiry_date"
										:error-messages="getError('expiry_date')"
									></v-text-field>

									<v-text-field dense outlined
										label="Numero certificati"
										v-model="content.certificate_nr"
										:error-messages="getError('certificate_nr')"
									></v-text-field>

									<v-autocomplete
										dense outlined
										label="Sessione d'esame"
										v-model="content.exam"
										:items="exams"
										item-text="displayValue"
										item-value="hashid"
										:error-messages="getError('exam')"
									></v-autocomplete>

									<v-text-field dense outlined disabled
										label="Structura"
										v-model="content.structure"
										:error-messages="getError('strutura')"
									></v-text-field>

									<span class="mr-3">Stato:</span>

									<v-btn-toggle v-model="content.status" group mandatory color="primary">
										<v-btn value="0">Non spedito</v-btn>
										<v-btn value="1">Spedito</v-btn>
										<v-btn value="2">In consegna</v-btn>
										<v-btn value="3">Consegnato</v-btn>
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
                user: {
                    type: this.userType,
                },
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
							//
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
                if (!this.content.received_date) { return  '' }
                return moment(this.content.received_date, 'YYYY-MM-DD').format('DD-MM-YYYY').toString();
            },
            sendDate() {
                if (!this.content.send_date) { return  '' }
                return moment(this.content.send_date, 'YYYY-MM-DD').format('DD-MM-YYYY').toString();
            },
						selExam() {
                return this.content.exam;
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
                console.log(val);
                this.exams.forEach(e => {
                    if (e.hashid == val) {
                        this.$set(this.content, 'structure', e.owner.firstname.toString());
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
