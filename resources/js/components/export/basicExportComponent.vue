<template>
	<div>
		<v-card class="mb-5">
			<v-card-title>
				Esporta
			</v-card-title>
			<v-card-text>
				<v-row>
					<v-col v-if="!categories" :md="show ? 3 : 4" cols="12">
						<v-menu content-class="gdate" v-model="datePicker1" :close-on-content-click="false"
										transition="scale-transition" offset-y min-width="290px">
							<template v-slot:activator="{ on }">
								<v-text-field readonly outlined v-on="on"
															v-model="esport.from_date"
															label="Da (Opzionale)"
															clearable
															@click:clear="esport.from_date = null"
								></v-text-field>
							</template>
							<v-date-picker v-model="esport.from_date" @input="datePicker1 = false"></v-date-picker>
						</v-menu>
					</v-col>
					<v-col v-if="!categories" :md="show ? 3 : 4" cols="12">
						<v-menu content-class="gdate" v-model="datePicker2" :close-on-content-click="false"
										transition="scale-transition" offset-y min-width="290px">
							<template v-slot:activator="{ on }">
								<v-text-field readonly outlined v-on="on"
															v-model="esport.to_date"
															label="Fino a (Opzionale)"
															clearable
															@click:clear="esport.to_date = null"
								></v-text-field>
							</template>
							<v-date-picker v-model="esport.to_date" @input="datePicker2 = false"></v-date-picker>
						</v-menu>
					</v-col>
					<v-col  v-if="strutture" md="3" cols="12" >
						<v-autocomplete
							outlined
							@click:clear="esport.structure = null"
							clearable
							label="Struttura (Opzionale)"
							v-model="esport.structure"
							:items="structures"
							item-text="legal_name"
							item-value="hashid"
						></v-autocomplete>
					</v-col>
					<v-col v-if="categories"  cols="12" md="4">
						<v-autocomplete
							outlined
							@click:clear="esport.category = null"
							clearable
							 label="Categorie (Opzionale)"
							v-model="esport.category"
							:items="types"
							item-text="name"
							item-value="id"
						></v-autocomplete>
					</v-col>
					<v-col  v-if="show" cols="12" :md="!categories ? 3 : 4">
						<v-autocomplete
							outlined
							@click:clear="esport.course = null"
							clearable
							 label="Corso (Opzionale)"
							v-model="esport.course"
							:items="corsi"
							item-text="name"
							item-value="id"
						></v-autocomplete>
					</v-col>
					<v-col :md="show ? 3 : 4" cols="12">
						<v-btn
							:loading="submiting"
							:disabled="submiting"
							color="primary"
							x-large
							class="white--text"
							@click.prevent="exporta"
						>Esporta
						</v-btn>
					</v-col>
				</v-row>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
	export default {
		name: "basicExportComponent",
		props: ['type', 'model', 'show','categories','strutture','type-structura'],
		data() {
			return {
				datePicker1: false,
				datePicker2: false,
				corsi: [],
				types:[],
				structures:[],
				esport: {
					model: this.model,
					type: this.type
				},
				submiting: false,
			}
		},
		mounted() {
			if (this.show){
				this.getCourses();
			}
			if (this.categories){
				this.getUserTypes();
			}
			if (this.strutture){
				this.getStructures()
			}
		},
		methods: {
			exporta() {
				if (!this.submiting) {
					this.submiting = true;
					axios.post(`/amministrazione/export`, this.esport).then(response => {
						window.location = response.data.redirect
					})
						.catch(error => {
						})
						.finally(() => {
							this.submiting = false;
						});
				}
			},
			getCourses() {
				axios.get(`/filter-courses`)
					.then(response => {
						if (response.data) {
							this.corsi = response.data;
						}
					})

			},
			getStructures() {
				if (this.typeStructura){
					axios.get(`/amministrazione/api/structures_by_category/${this.typeStructura}`).then(response => {
						this.structures = response.data
					})
					return
				}

				axios.get(`/amministrazione/api/struture/${this.strutture}`).then(response => {
					this.structures = response.data
				})
			},
		}
	}
</script>
