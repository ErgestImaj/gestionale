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
									<v-text-field label="Nome" outlined v-model="user.infoBase.nome" dense></v-text-field>
									<v-text-field label="Cognome" outlined v-model="user.infoBase.cognome" dense></v-text-field>
									<v-text-field label="Email" outlined v-model="user.infoBase.email" dense></v-text-field>
									<v-text-field label="Telefono" outlined v-model="user.infoBase.telefono" dense></v-text-field>
									<v-text-field label="Cellulare" outlined v-model="user.infoBase.cellulare" dense></v-text-field>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
				<v-col cols="12" md="6">
					<v-card outlined flat>
						<v-card-title>Informazioni personali</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-text-field label="Codice fiscale" outlined v-model="user.infoPersonali.codiceFiscale" dense></v-text-field>
									<v-select dense v-model="user.infoPersonali.sesso" :items="sesso"
														label="Sesso" outlined
									></v-select>
									<v-menu content-class="gdate" v-model="datePicker1"
										:close-on-content-click="false" transition="scale-transition"
										offset-y min-width="290px" >
										<template v-slot:activator="{ on }">
											<v-text-field
												v-model="user.infoPersonali.datNascita" label="Data di nascita"
												readonly outlined dense v-on="on"></v-text-field>
										</template>
										<v-date-picker v-model="user.infoPersonali.datNascita" @input="datePicker1 = false"></v-date-picker>
									</v-menu>
									<v-select dense v-model="user.infoPersonali.nazionalita" :items="nazionalita"
														label="Nazionalità" outlined
									></v-select>
									<v-select dense v-model="user.infoPersonali.luogoDiNascita" :items="luogo"
														label="Luogo di nascita" outlined
									></v-select>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row>
				<v-col cols="12" md="6">
					<v-card outlined flat>
						<v-card-title>Informazioni di domicilio</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-select dense v-model="user.infoDomicilio.stato" :items="stati"
														label="Stato" outlined
									></v-select>
									<v-select dense v-model="user.infoDomicilio.citta" :items="citta"
														label="Città" outlined
									></v-select>
									<v-text-field
										v-model="user.infoDomicilio.regione" label="Regione"
										readonly outlined dense></v-text-field>
									<v-text-field
										v-model="user.infoDomicilio.provincia" label="Provincia"
										readonly outlined dense></v-text-field>
									<v-text-field v-model="user.infoDomicilio.indirizzo" label="Indirizzo" outlined dense></v-text-field>
									<v-text-field v-model="user.infoDomicilio.codicePostale" label="Codice postale" outlined dense></v-text-field>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
				<v-col cols="12" md="6">
					<v-card outlined flat>
						<v-card-title>Altre informazioni</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-select dense v-model="user.altreInfo.regioneIstituto" :items="regioneIstituto"
														label="Regione istituto scolastico" outlined
									></v-select>
									<v-text-field label="Istituto" outlined v-model="user.altreInfo.Istituto" dense></v-text-field>
									<v-text-field label="Codice meccanografico" outlined v-model="user.altreInfo.codiceMeccanografico" dense></v-text-field>
									<v-select dense v-model="user.altreInfo.titoloStudio" :items="titoloStudio"
														label="Titolo di studio" outlined
									></v-select>
									<v-select dense v-model="user.altreInfo.occupazione" :items="occupazione"
														label="Occupazione" outlined
									></v-select>

									<v-text-field dense readonly label="Curriculum Vitae" outlined @click='pickFile(0)'
																prepend-inner-icon="mdi-cloud-upload" :value="doc1 ? doc1.name : '' "
									></v-text-field>
									<input
										type="file"
										style="display: none"
										ref="file0"
										@change="handleFileUpload($event, 0)"
									>

									<v-select dense v-model="user.altreInfo.tipoDocument" :items="tipoDocument"
														label="Tipo di documento" outlined
									></v-select>

									<v-text-field label="Numero di documento" outlined v-model="user.altreInfo.codiceMeccanografico" dense></v-text-field>

									<v-menu content-class="gdate" v-model="datePicker2"
													:close-on-content-click="false" transition="scale-transition"
													offset-y min-width="290px" >
										<template v-slot:activator="{ on }">
											<v-text-field
												v-model="user.altreInfo.dataScdenzaDoc" label="Data scadenza documento"
												readonly outlined dense v-on="on"></v-text-field>
										</template>
										<v-date-picker v-model="user.altreInfo.dataScdenzaDoc" @input="datePicker2 = false"></v-date-picker>
									</v-menu>

									<v-text-field dense readonly label="Documento di identità" outlined @click='pickFile(1)'
																prepend-inner-icon="mdi-cloud-upload" :value="doc2 ? doc2.name : '' "
									></v-text-field>
									<input
										type="file"
										style="display: none"
										ref="file1"
										@change="handleFileUpload($event, 1)"
									>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
		</v-container>
	</v-form>
</template>

<script>
    export default {
        data() {
            return {
                date: new Date().toISOString().substr(0, 10),
								datePicker1: false,
								datePicker2: false,
                doc1: null,
                doc2: null,
                user: {
                    infoBase: {},
										infoPersonali: {
                        datNascita: new Date().toISOString().substr(0, 10)
										},
                    infoDomicilio: {},
										altreInfo: {
                        dataScdenzaDoc: new Date().toISOString().substr(0, 10)
										}
								},
								sesso: ['M','F'],
                nazionalita: [],
                luogo: [],
								stati: [],
								citta: [],
                regioneIstituto: [],
                titoloStudio: [],
                occupazione: [],
                tipoDocument: []
						}
				},
        methods: {
            pickFile(i) {
                if(i == 0) {
                    this.$refs.file0.click()
                } else if (i == 1) {
                    this.$refs.file1.click()
                }
            },
            handleFileUpload(e, i){
                if(i == 0) {
                    this.doc1 = e.target.files[0];
                } else if (i == 1) {
                    this.doc2 = e.target.files[0];
                }
            },
        }
    }
</script>

<style>
	.add-user .v-card__title {
		background: #388E3C;
		color: white;
		padding: 10px 15px;
		box-shadow: 0 19px 20px -12px rgba(0, 0, 0, 0.25);
		background: linear-gradient(45deg, #388E3C, #81C784);
		margin-bottom: 10px;
		font-size: 18px;
		font-weight: normal;
	}
</style>
