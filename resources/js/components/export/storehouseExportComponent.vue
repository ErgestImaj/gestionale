<template>
<div>
	<v-card class="mb-5">
		<v-card-title>
			Esporta
		</v-card-title>
		<v-card-text>
			<v-row >
				<v-col md="3" cols="12" >
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
				<v-col  md="3" cols="12">
					<v-autocomplete
					  outlined
						label="Struttura (Opzionale)"
						v-model="esport.structure"
						:items="structures"
						item-text="legal_name"
						item-value="id"
					></v-autocomplete>
				</v-col>
				<v-col  md="3" cols="12">
					<v-menu content-class="gdate" v-model="datePicker2" :close-on-content-click="false"
									transition="scale-transition" offset-y min-width="290px">
						<template v-slot:activator="{ on }">
							<v-text-field readonly outlined  v-on="on"
														v-model="esport.to_date"
														label="Struttura (Opzionale)"
														clearable
														@click:clear="esport.to_date = null"
							></v-text-field>
						</template>
						<v-date-picker v-model="esport.to_date"  @input="datePicker2 = false"></v-date-picker>
					</v-menu>
				</v-col>
				<v-col cols="12" md="6">
					<v-btn
						:loading="submiting"
						:disabled="submiting"
						color="primary mb-3"
						x-large
						class="white--text"
						@click.prevent="exporta"
					>Esporta PDF</v-btn>
					<v-btn
						:loading="submiting"
						:disabled="submiting"
						color="primary mb-3"
						x-large
						class="white--text"
						@click.prevent="exporta"
					>Esporta Excel</v-btn>
				</v-col>
			</v-row>
		</v-card-text>
	</v-card>
</div>
</template>

<script>
		export default {
			  props:['type','model'],
			  data(){
        	return {
						datePicker1: false,
						datePicker2: false,
						structures:[],
						esport:{
							model:this.model,
							type:this.type
						},
						submiting: false,
					}
				},
			mounted() {
        	this.getStructures()
			},
			methods:{
        	exporta(){
					if (!this.submiting) {
					  	this.submiting = true;
 							axios.post(`/amministrazione/export`,this.esport).then(response => {
								window.location= response.data.redirect
							})
								.catch(error => {})
								.finally(() => {
									this.submiting = false;
								});
					}
				},
				getStructures() {
					axios.get(`/amministrazione/api/struture/${this.type}`).then(response => {
						   this.structures = response.data
					})
				},
			}
    }
</script>

