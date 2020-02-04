<template>
	<v-form>
		<v-container>
			<v-row>
				<v-col cols="12" sm="6">
					<v-card outlined flat>
						<v-card-title>Informazioni di accesso</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-text-field label="Nome" outlined v-model="strutura.infoAccesso.nome" dense></v-text-field>
									<v-text-field label="Username" outlined v-model="strutura.infoAccesso.username" dense></v-text-field>
									<v-text-field label="Password" outlined v-model="strutura.infoAccesso.password" dense
																:append-icon="showpass ? 'mdi-eye' : 'mdi-eye-off'"
																:type="showpass ? 'text' : 'password'"
																@click:append="showpass = !showpass"
									></v-text-field>
									<v-text-field label="P.iva" outlined v-model="strutura.infoAccesso.piva" dense></v-text-field>

									<v-select dense v-model="strutura.infoAccesso.lingua" :items="lingua"
														label="Lingua" outlined
									></v-select>

									<v-select dense v-model="strutura.infoAccesso.catEipass" :items="catEipass"
														label="Categoria EIPASS" outlined
									></v-select>

									<v-menu
										v-model="dataContratto"
										:close-on-content-click="false"
										transition="scale-transition"
										offset-y
										min-width="290px"
									>
										<template v-slot:activator="{ on }">
											<v-text-field
												v-model="date"
												label="Data contratto EIPASS"
												readonly
												v-on="on"
												outlined
												dense
											></v-text-field>
										</template>
										<v-date-picker v-model="date" @input="dataContratto = false"></v-date-picker>
									</v-menu>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
				<v-col cols="12" sm="6">
					<v-card outlined flat>
						<v-card-title>Sede legale</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-autocomplete
										dense v-model="strutura.sedeLegale.nazione" :items="nazioni"
										label="Nazione"
										outlined
									></v-autocomplete>

									<v-text-field label="Indirizzo" outlined v-model="strutura.sedeLegale.indirizzo" dense></v-text-field>

									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field label="Città" outlined v-model="strutura.sedeLegale.citta" dense></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-autocomplete
												dense v-model="strutura.sedeLegale.provinca" :items="province"
												label="Provincia"
												outlined
											></v-autocomplete>
										</v-col>
									</v-row>

									<v-text-field label="Cap" outlined v-model="strutura.sedeLegale.cap" dense></v-text-field>

									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field label="Telefono" outlined v-model="strutura.sedeLegale.telefono" dense></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field label="Fax" outlined v-model="strutura.sedeLegale.fax" dense></v-text-field>
										</v-col>
									</v-row>

									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field label="Email" outlined v-model="strutura.sedeLegale.email" dense></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field label="PEC" outlined v-model="strutura.sedeLegale.pec" dense></v-text-field>
										</v-col>
									</v-row>

									<v-text-field label="CODICE UNIVOCO PER LA FATTURAZIONE ELETTRONICA" outlined v-model="strutura.sedeLegale.codUnivoco" dense></v-text-field>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>

			<v-row>
				<v-col cols="12" sm="6">
					<v-card outlined flat>
						<v-card-title>Sedi esame</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">

									<v-text-field label="Nome" outlined v-model="strutura.sediEsame.nome" dense></v-text-field>

									<v-autocomplete
										dense v-model="strutura.sediEsame.nazione" :items="nazioni"
										label="Nazione"
										outlined
									></v-autocomplete>

									<v-text-field label="Indirizzo" outlined v-model="strutura.sediEsame.indirizzo" dense></v-text-field>

									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field label="Città" outlined v-model="strutura.sediEsame.citta" dense></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-autocomplete
												dense v-model="strutura.sediEsame.provinca" :items="province"
												label="Provincia"
												outlined
											></v-autocomplete>
										</v-col>
									</v-row>

									<v-text-field label="Cap" outlined v-model="strutura.sediEsame.cap" dense></v-text-field>

									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field label="Telefono" outlined v-model="strutura.sediEsame.telefono" dense></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field label="Fax" outlined v-model="strutura.sediEsame.fax" dense></v-text-field>
										</v-col>
									</v-row>

									<v-row>
										<v-col cols="12" sm="6">
											<v-text-field label="Email" outlined v-model="strutura.sediEsame.email" dense></v-text-field>
										</v-col>
										<v-col cols="12" sm="6">
											<v-text-field label="Sito" outlined v-model="strutura.sediEsame.sito" dense></v-text-field>
										</v-col>
									</v-row>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
				<v-col cols="12" sm="6">
					<v-card outlined flat>
						<v-card-title>Sede spedizione</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-text-field label="Destinatario" outlined v-model="strutura.sedeSpedizione.destinatario" dense></v-text-field>

									<v-autocomplete
										dense v-model="strutura.sedeSpedizione.nazione" :items="nazioni"
										label="Nazione"
										outlined
									></v-autocomplete>

									<v-text-field label="Indirizzo e n.civico" outlined v-model="strutura.sedeSpedizione.indirizzoNrCivico" dense></v-text-field>
									<v-text-field label="Città" outlined v-model="strutura.sedeSpedizione.citta" dense></v-text-field>

									<v-autocomplete
										dense v-model="strutura.sedeSpedizione.provinca" :items="province"
										label="Provincia"
										outlined
									></v-autocomplete>

									<v-text-field label="Cap" outlined v-model="strutura.sedeSpedizione.cap" dense></v-text-field>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row>
				<v-col cols="12" sm="6">
					<v-card outlined flat>
						<v-card-title>Rappresentante legale</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-text-field label="Cognome" outlined v-model="strutura.rappresentanteLegale.cognome" dense></v-text-field>
									<v-text-field label="Nome" outlined v-model="strutura.rappresentanteLegale.nome" dense></v-text-field>
									<v-text-field label="Email" outlined v-model="strutura.rappresentanteLegale.email" dense></v-text-field>
									<v-text-field label="Telefono" outlined v-model="strutura.rappresentanteLegale.telefono" dense></v-text-field>
									<v-text-field label="Fax" outlined v-model="strutura.rappresentanteLegale.fax" dense></v-text-field>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
				<v-col cols="12" sm="6">
					<v-card outlined flat>
						<v-card-title>Rappresentante eipass designato</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-text-field label="Cognome" outlined v-model="strutura.rappresentanteEipass.cognome" dense></v-text-field>
									<v-text-field label="Nome" outlined v-model="strutura.rappresentanteEipass.nome" dense></v-text-field>
									<v-text-field label="Email" outlined v-model="strutura.rappresentanteEipass.email" dense></v-text-field>
									<v-text-field label="Telefono" outlined v-model="strutura.rappresentanteEipass.telefono" dense></v-text-field>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>





			<v-row>
				<v-col cols="12" sm="12">
					<v-text-field dense :label="trans('form.choose_file')" outlined @click='pickFile' prepend-inner-icon="mdi-cloud-upload" :value="doc_file ? doc_file.name : '' "></v-text-field>
					<input
						type="file"
						style="display: none"
						ref="image"
						@change="handleFileUpload($event)"
					>
				</v-col>
			</v-row>
			<v-row>
				<v-col cols="12" sm="12">
					<v-btn
						dense
						:loading="submiting"
						:disabled="submiting"
						color="primary"
						class="ma-0 white--text"
					>
						{{trans('form.add_doc')}}
						<v-icon right dark>mdi-cloud-upload</v-icon>
					</v-btn>
				</v-col>
			</v-row>
		</v-container>
	</v-form>
</template>

<script>
    export default {
        data() {
            return {
                strutura: {
                    infoAccesso: {
                        nome: null,
                        username: null,
                        password: null,
                        piva: null,
                        lingua: null,
                        catEipass: null,
                        dataContratoEipass: null
                    },
                    sedeLegale: {
                        nazione: null,
                        indirizzo: null,
                        citta: null,
                        provinca: null,
                        cap: null,
                        telefono: null,
                        fax: null,
                        email: null,
                        pec: null,
                        codUnivoco: null
                    },
                    sediEsame: {
                        nome: null,
                        nazione: null,
                        indirizzo: null,
                        citta: null,
                        provinca: null,
                        cap: null,
                        telefono: null,
                        fax: null,
                        email: null,
                        sito: null
                    },
                    sedeSpedizione: {
                        destinatario: null,
                        nazione: null,
                        indirizzoNrCivico: null,
                        citta: null,
                        provinca: null,
                        cap: null
                    },
                    rappresentanteLegale: {
                        cognome: null,
                        nome: null,
                        email: null,
                        telefono: null,
                        fax: null
                    },
                    rappresentanteEipass: {
                        cognome: null,
                        nome: null,
                        email: null,
                        telefono: null
                    }
                },
                doc_file: null,
                errors: {},
                submiting: false,
                categories: [],
                roles: [],
								showpass: false,
                dataContratto: false,
                date: new Date().toISOString().substr(0, 10),
								nazioni: ['Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Anguilla', 'Antartide', 'Antigua e Barbuda', 'Antille Olandesi', 'Arabia Saudita', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrein', 'Bangladesh', 'Barbados', 'Belgio', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bielorussia', 'Bolivia', 'Bosnia Erzegovina', 'Botswana', 'Brasile', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambogia', 'Camerun', 'Canada', 'Capo Verde', 'Christmas Island', 'Ciad', 'Cile', 'Cina', 'Cipro', 'Cocos (Keeling) Islands', 'Colombia', 'Comore', 'Congo', 'Congo,Rep. Democratica', 'Corea del Nord', 'Corea del Sud', 'Costa d\'Avorio', 'Costa Rica', 'Croazia', 'Cuba', 'Danimarca', 'Dominica', 'Ecuador', 'Egitto', 'EIRE', 'El Salvador', 'Emirati Arabi Uniti', 'Eritrea', 'Estonia', 'Etiopia', 'Falkland Islands (Malvinas)', 'Figi', 'Filippine', 'Finlandia', 'Francia', 'Gabon', 'Gambia', 'Georgia', 'Germania', 'Ghana', 'Giamaica', 'Giappone', 'Gibilterra', 'Gibuti', 'Giordania', 'Gran Bretagna', 'Grecia', 'Grenada', 'Groenlandia', 'Guadalupa', 'Guam', 'Guatemala', 'Guiana Francese', 'Guinea', 'Guinea Equatoriale', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Holy See (Vatican City State)', 'Honduras', 'Hong Kong', 'India', 'Indonesia', 'Iran', 'Iraq', 'Islanda', 'Isola Bouvet', 'Isola di Norfolk', 'Isole Cayman', 'Isole di Cook', 'Isole Faroe', 'Isole Heard e McDonald', 'Isole Maldive', 'Isole Marianne del Nord', 'Isole Marshall', 'Isole Minor Outlying, USA', 'Isole Solomone', 'Isole Turks e Caicos', 'Isole Vergini, GB', 'Isole Vergini, USA', 'Israele', 'Italia', 'Kazakistan', 'Kenya', 'Kirgizistan', 'Kiribati', 'Kosovo', 'Kuwait', 'Laos', 'Lesotho', 'Lettonia', 'Libano', 'Liberia', 'Libia', 'Liechtenstein', 'Lituania', 'Lussemburgo', 'Macao', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Mali', 'Malta', 'Marocco', 'Martinica', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldova, Republic of', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norvegia', 'Nuova Caledonia', 'Nuova Guinea', 'Nuova Zelanda', 'Oceano Indiano, territorio britannico', 'Oman', 'Paesi Bassi', 'Pakistan', 'Palau', 'Panama', 'Paraguay', 'Peru', 'Pitcairn', 'Polinesia Francese', 'Polonia', 'Porto Rico', 'Portogallo', 'Qatar', 'R?union', 'Repubblica Ceca', 'Repubblica Centrafricana', 'Repubblica Dominicana', 'Romania', 'Russia', 'Rwanda', 'Sahara Occidentale', 'Saint Kitts e Nevis', 'Saint Pierre e Miquelon', 'Saint Vincent e le Grenadine', 'Samoa', 'Samoa Americane', 'San Marino', 'Sant\'Elena', 'Santa Lucia', 'Sao Tome e Principe', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Siria', 'Slovacchia', 'Slovenia', 'Somalia', 'Spagna', 'Sri Lanka', 'Sud Africa', 'Sud Georgia', 'Sudan', 'Suriname', 'Svalbard e Jan Mayen', 'Svezia', 'Svizzera', 'Swaziland', 'Tagikistan', 'Taiwan', 'Tanzania', 'Territori Francesi del Sud', 'Territori Palestinesi', 'Thailand', 'Timor Est', 'Togo', 'Tokelau', 'Tonga', 'Trinidad e Tobago', 'Tunisia', 'Turchia', 'Turkmenistan', 'Tuvalu', 'Ucraina', 'Uganda', 'Ungheria', 'Uruguay', 'USA', 'Uzbekistan', 'Vanuatu', 'Venezuela', 'Vietnam', 'Wallis e Futuna', 'Yemen', 'Zambia', 'Zimbabwe'],
								lingua: ['Italiani', 'Inglese'],
								catEipass: ['AFFILIATO BUSINESS', 'AFFILIATO ACADEMY', 'AFFILIATO MASTER'],
								province: ['Agrigento', 'Alessandria', 'Ancona', 'Aosta', 'Ascoli Piceno', 'L\'Aquila', 'Arezzo', 'Asti', 'Avellino', 'Bari', 'Bergamo', 'Biella', 'Belluno', 'Benevento', 'Bologna', 'Brindisi', 'Brescia', 'Barletta - Andria - Trani', 'Bolzano', 'Cagliari', 'Campobasso', 'Caserta', 'Chieti', 'Carbonia Iglesias', 'Caltanissetta', 'Cuneo', 'Como', 'Cremona', 'Cosenza', 'Catania', 'Catanzaro', 'Enna', 'Forlì Cesena', 'Ferrara', 'Foggia', 'Firenze', 'FERMO', 'Frosinone', 'Genova', 'Gorizia', 'Grosseto', 'Imperia', 'Isernia', 'Crotone', 'Lecco', 'Lecce', 'Livorno', 'Lodi', 'Latina', 'Lucca', 'Monza Brianza', 'Macerata', 'Messina', 'Milano', 'Mantova', 'Modena', 'Massa Carrara', 'Matera', 'Napoli', 'Novara', 'Nuoro', 'Ogliastra', 'Oristano', 'Olbia Tempio', 'Palermo', 'Piacenza', 'Padova', 'Pescara', 'Perugia', 'Pisa', 'Pordenone', 'Prato', 'Parma', 'Pistoia', 'Pesaro Urbino', 'Pavia', 'Potenza', 'Ravenna', 'Reggio Calabria', 'Reggio Emilia', 'Ragusa', 'Rieti', 'Roma', 'Rimini', 'Rovigo', 'Salerno', 'Siena', 'Sondrio', 'La Spezia', 'Siracusa', 'Sassari', 'Sud Sardegna', 'Savona', 'Taranto', 'Teramo', 'Trento', 'Torino', 'Trapani', 'Terni', 'Trieste', 'Treviso', 'Udine', 'Varese', 'Verbania', 'Vercelli', 'Venezia', 'Vicenza', 'Verona', 'Medio Campidano', 'Viterbo', 'Vibo Valentia'],

						}
				},
				methods: {
            pickFile () {
                this.$refs.image.click ()
            },
            handleFileUpload(e){
                console.log(e.target.files[0].name);
                return this.doc_file = e.target.files[0];
            },
				}
    }
</script>

<style>
	.gel > div {
		margin-bottom: 15px !important;
	}
	.gel .col-sm-6.col-12 {
		padding: 0 12px;
	}
	.v-menu__content {
		margin-top: 40px !important;
	}
	.v-menu__content.v-autocomplete__content {
		margin-top: 0 !important;
	}
</style>
