<template>
	<div>
		<storehouse-export
			type="2,3"
			model="course-request"
			:show="true"
		>
		</storehouse-export>
		<v-card>
			<v-card-title>
				Gestione richieste assegnazione corsi
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="orders"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.items="{ item }">
					<div v-for="order in item.items" :key="order.id"
							 style="display: flex; justify-content: space-between; align-items: center;"
					>
						<span class="gnam">{{ order && order.course && order.course.name ? order.course.name : ''}}</span>
						<v-chip right label small outlined class="ma-1">
							quantità: {{ order.qty}}
						</v-chip>
					</div>

				</template>
				<template v-slot:item.price="{ item }">
					<span>{{item.price | price}}</span>
				</template>
				<template v-slot:item.status_name="{ item }">
					<span :class="'gstatus ' + item.status_name.split(' ').join('_').toLowerCase()">{{ item.status_name }}</span>
				</template>
				<template v-slot:item.actions="{ item }">
					<v-menu  v-if="item.status !=0" bottom left content-class="gactions">
						<template v-slot:activator="{ on }">
							<v-btn icon v-on="on">
								<v-icon>mdi-dots-vertical</v-icon>
							</v-btn>
						</template>

						<v-list dense>
							<template v-for="(m, i) in showActions(item)">
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
    export default {
        dependencies: 'globalService',
        data() {
            return {
                footerProps: null,
                search: '',
                loading: true,
                headers: [
                    { text: 'Fatto richiesta', value: "structure.legal_name" },
                    { text: 'Struttura madre', value: "parent_structure.legal_name" },
                    { text: 'Data', value: "date" },
                    { text: 'Identificativo Ordine', value: "order_number" },
                    { text: 'Dettaglio richiesta', value: "items" },
                    { text: 'Totale', value: "price" },
                    { text: 'Stato', value: "status_name" },
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ],
                menuItems: [
                    { id: 1, title: "Conferma richiesta", icon: "mdi-check-underline" },
                    { id: 2, title: "Blocca richiesta", icon: "mdi-lock" },
                    { id: 3, title: "Sblocca richiesta", icon: "mdi-lock-open-variant" },
                    { id: 4, title: "Richiesta confermata", icon: "mdi-emoticon-happy-outline" },
                ],
                orders: [],
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getOrders();
        },
        methods: {
						showActions(item){
							let actions = {};
							for (let k in this.menuItems) {

								if ((this.menuItems[k].id == 3 ||  this.menuItems[k].id == 4)  && item.status == 1)
									continue;
								else if ((this.menuItems[k].id == 1 || this.menuItems[k].id == 2|| this.menuItems[k].id == 3) && item.status == 2)
									continue;
								else if ((this.menuItems[k].id == 1 || this.menuItems[k].id == 2|| this.menuItems[k].id == 4) &&  item.status == 3)
									continue;
								actions[k]= this.menuItems[k];
							}
							return actions;
						},	menuClick(id, item) {
						switch (id) {
							case 1:
								this.confirmCoursesRequest(item.hashid)
								break;
							case 2:
								this.blockCoursesRequest(item.hashid)
								break;
							case 3:
								this.unBlockCoursesRequest(item.hashid)
								break;

						}
					},
					blockCoursesRequest(record) {
						axios.patch(`/cart/api/courses-requests/${record}/block`).then(response => {
							if (response.data.status == "success") {
								swal("Good job!", response.data.msg, "success");
								this.getOrders()
							} else if (response.data.status === "error") {
								swal({
									title: "Whoops!",
									text: response.data.msg,
									icon: "warning",
									dangerMode: true
								});
							}
						});
					},confirmCoursesRequest(record) {
						axios.patch(`/cart/api/courses-requests/${record}/confirm`).then(response => {
							if (response.data.status == "success") {
								swal("Good job!", response.data.msg, "success");
								this.getOrders()
							} else if (response.data.status === "error") {
								swal({
									title: "Whoops!",
									text: response.data.msg,
									icon: "warning",
									dangerMode: true
								});
							}
						});
					},
					unBlockCoursesRequest(record) {
						axios.patch(`/cart/api/courses-requests/${record}/unblock`).then(response => {
							if (response.data.status == "success") {
								swal("Good job!", response.data.msg, "success");
								this.getOrders()
							} else if (response.data.status === "error") {
								swal({
									title: "Whoops!",
									text: response.data.msg,
									icon: "warning",
									dangerMode: true
								});
							}
						});
					},
            getOrders() {
                axios.get(`/cart/api/courses-requests`).then(response => {
                    this.orders = response.data;
                    this.loading = false;
                });
            },
        },
        filters: {
            price: function (price) {
                if (!price || parseFloat(price) === 0) { return '0.00' }
                return parseFloat(price).toString() + ' €';
            }
        }
    }
</script>

<style>
	span.gstatus {
		background: #dedede;
		display: block;
		min-height: 100%;
		font-size: 14px;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	span.gstatus.completato {
		background: #81C784;
	}
	span.gstatus.aperto {
		background: #40C4FF;
	}
	span.gstatus.in_attesa {
		background: #D4E157;
	}
	span.gstatus.bloccata {
		background: #F50057;
	}
</style>
