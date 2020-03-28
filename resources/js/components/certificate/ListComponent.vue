<template>
	<div>
		<v-card>
			<v-card-title>
				Report formazione
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="certificates"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.actions="{ item }">
					<v-btn
						small
						color="blue-grey"
						class="ma-2 white--text"
					> <v-icon left dark>mdi-download</v-icon>
						Scarica pdf
					</v-btn>
				</template>
			</v-data-table>
		</v-card>
	</div>
</template>

<script>
    export default {
        dependencies: 'globalService',
        data() {
            return {
                footerProps: null,
                search: '',
                loading: true,
                headers: [
                    { text: 'Centro', value: "exam_session.owner.firstname" },
                    { text: 'Nominativo', value: "nominativo" },
                    { text: 'Codice utente', value: "user.hashid" },
                    { text: 'Corso', value: "exam_session.course.name" },
                    { text: 'Tipo', value: "type_name" },
                    { text: 'Data', value: "exam_session.date" },
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ],
                certificates: [],
                editData: null,
                editDialog: false,
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getTrackings();
        },
        methods: {
            getTrackings() {
                axios.get(`/amministrazione/api/certificates`).then(response => {
                    let certificates = response.data;
                    certificates.forEach(c => {
                        if (c.user) {
                            c.nominativo = c.user.firstname + ' ' + c.user.lastname;
												}
										});
                    this.certificates = certificates;
                    this.loading = false;
                });
            },
        }
    }
</script>

<style>
	span.gstatus {
		background: #dedede;
		display: block;
		height: 47px;
		text-align: center;
		line-height: 47px;
		font-size: 14px;
	}
	span.gstatus.ricevuto {
		background: #81C784;
	}
</style>
