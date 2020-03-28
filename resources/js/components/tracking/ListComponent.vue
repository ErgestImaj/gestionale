<template>
	<div>
		<v-card>
			<v-card-title>
				Lista Tracking
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="trackings"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.status_name="{ item }">
					<span :class="'gstatus ' + item.status_name.toLowerCase()">{{ item.status_name }}</span>
				</template>
				<template v-slot:item.actions="{ item }">

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
                    { text: 'Codice', value: "code" },
                    { text: 'Data stimata', value: "estimate_date" },
                    { text: 'Struttura', value: "structure.firstname" },
                    { text: 'Data di invio', value: "send_date" },
                    { text: 'Data di scadenza', value: "expiry_date" },
                    { text: 'Stato', value: "status_name" },
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ],
                trackings: [],
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
                axios.get(`/api/tracking`).then(response => {
                    this.trackings = response.data;
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
