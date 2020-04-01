<template>
	<div>
		<v-btn :href="createUrl" class="gadd">Crea Nuovo</v-btn>
		<v-card>
			<v-card-title>
				Sistema - Tracciabilità
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
					<span :class="'gstatus ' + item.status_name.split(' ').join('_').toLowerCase()">{{ item.status_name }}</span>
				</template>
				<template v-slot:item.actions="{ item }">
					<v-menu  bottom left content-class="gactions">
						<template v-slot:activator="{ on }">
							<v-btn icon v-on="on">
								<v-icon>mdi-dots-vertical</v-icon>
							</v-btn>
						</template>

						<v-list dense>
							<template  v-for="(m, i) in showActions(item.status)">
								<v-list-item  :key="i" @click="menuClick(m.id, item)">
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
                    { id: 2, title: "Confim order recieved", icon: "mdi-gift-outline" },
                    { id: 3, title: "Order not recieved", icon: "mdi-gift" },
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
        },
        methods: {
					showActions($status){
						let actions = {};
						for (let k in this.menuItems) {

							if (this.menuItems[k].id == 2 && $status == 2)
								continue;
              else if (this.menuItems[k].id == 3 && $status == 4)
								continue;
							else if (this.menuItems[k].id != 4 && $status == 3)
								continue;
							actions[k]= this.menuItems[k];
						}
						return actions;
					},
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
                        this.edit(item)
                        break;
                    case 2:
                    case 3:
                    case 4:
											this.updateTrackingStatus(id,item)
											break;
                }
            },
					  edit(item){
							let nUrl = window.location.origin + "/tracking/"+item.hashid+"/edit";
							window.location.href = nUrl;
						},
				  	updateTrackingStatus(id,item){
							axios.patch(`/tracking/${item.hashid}/${id}/received`)
								.then(response => {
									if (response.data.status == "success") {
										swal("Good job!", response.data.msg, "success");
											this.getTrackings();
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
								})
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
	span.gstatus.expired {
		background: #E53935;
	}
	span.gstatus.da_spedire {
		background: #42A5F5;
	}span.gstatus.non_ricevuto {
		background: #4DD0E1;
	}
	a.gadd span {
		display: block;
		line-height: 36px;
	}
</style>
