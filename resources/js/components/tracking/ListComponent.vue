<template>
	<div>
		<v-btn :href="createUrl" class="gadd">{{ trans('form.add_content') }}</v-btn>
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
					<v-menu bottom left content-class="gactions">
						<template v-slot:activator="{ on }">
							<v-btn icon v-on="on">
								<v-icon>mdi-dots-vertical</v-icon>
							</v-btn>
						</template>

						<v-list dense>
							<template v-for="(m, i) in menuItems">
								<v-list-item :key="i" @click="menuClick(m.id, item)">
									<v-list-item-icon>
										<v-icon v-text="m.icon"></v-icon>
									</v-list-item-icon>
									<v-list-item-title>{{ m.title }}</v-list-item-title>
								</v-list-item>
							</template>
						</v-list>
					</v-menu>
				</template>
			</v-data-table>
		</v-card>
	</div>
</template>

<script>
	import moment from 'moment';
    export default {
        props: ['createUrl'],
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
                    { text: 'Sessione d\'esame', value: "exam" },
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
                menuItems: [
                    { id: 1, title: "Edit", icon: "mdi-pencil-outline" },
                    { id: 2, title: "Confim order recieved", icon: "" },
                    { id: 3, title: "Order not recieved", icon: "" },
                    { id: 4, title: "Delete", icon: "mdi-trash-can-outline" }
                ],
                trackings: [],
                editData: null,
                editDialog: false,
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getTrackings();
            console.log(this.createUrl);
        },
        methods: {
            getTrackings() {
                axios.get(`/api/tracking`).then(response => {
                    let trackings = response.data;

                    trackings.forEach(t => {
                        t.exam = t.lrnexam.course.name + ' -- ' + moment(t.lrnexam.date, 'YYYY-MM-DD').format('DD-MM-YYYY').toString();
										});

                    this.trackings = trackings;
                    this.loading = false;
                });
            },
						menuClick(id, item) {
                switch (id) {
                    case 1:
                        // edit
                        break;
                    case 2:
                        // confirm received
                        break;
                    case 3:
                        // not received
                        break;
                    case 4:
                        // delete
                        break;
                }
            },
						moment() {
                return moment;
						}
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
	a.gadd span {
		display: block;
		line-height: 36px;
	}
</style>
