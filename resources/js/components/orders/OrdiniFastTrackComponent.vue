<template>
	<div>
		<v-card>
			<v-card-title>
				Fast Track
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
				<template v-slot:item.order_items="{ item }">
					<div v-for="order in item.order_items" :key="order.id"
							 style="display: flex; justify-content: space-between; align-items: center;"
					>
						<span class="gnam">{{ order && order.course && order.course.name ? order.course.name : ''}} -- {{order && order.date ? order.date : ''}}</span>
						<v-chip right label small outlined class="ma-1">
							{{ order.participants_count + ' x '  }}{{ item.general_price | price }}
						</v-chip>
					</div>

				</template>
				<template v-slot:item.price="{ item }">
					<span>{{item.price | price}}</span>
				</template>
				<template v-slot:item.status_name="{ item }">
					<span :class="'gstatus ' + item.state_name.split(' ').join('_').toLowerCase()">{{ item.state_name }}</span>
				</template>
				<template v-slot:item.actions="{ item }">
					<v-menu  v-if="item.state !=0" bottom left content-class="gactions">
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
                    { text: 'Identificativo Ordine', value: "order_number" },
                    { text: 'Struttura', value: "user.firstname" },
                    { text: 'Sessione d\'esame', value: "order_items" },
                    { text: 'Totale', value: "price" },
                    { text: 'Metodo pagamento', value: "payment_name" },
                    { text: 'Data', value: "order_date" },
                    { text: 'Stato', value: "status_name" },
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ],
                menuItems: [
                    { id: 1, title: "Inoltra nuovamente fattura", icon: "mdi-email-send-outline" },
                    { id: 2, title: "Scarica fattura", icon: "mdi-download" },
                    { id: 3, title: "Scarica ricevuta", icon: "mdi-download" },
                    { id: 4, title: "Carica ricevuta di pagamento", icon: "mdi-upload" },
                    { id: 5, title: "Conferma pagamento", icon: "mdi-timer-sand" },
                    { id: 6, title: "Fattura elettronica", icon: "mdi-receipt" },
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

								if ((this.menuItems[k].id == 4 && item.state == 2) || this.menuItems[k].id == 5 && item.state == 2)
									continue;
								else if (this.menuItems[k].id == 3 && item.state == 2 && item.receipt=='')
									continue;
								else if (this.menuItems[k].id == 1 && item.state != 2)
									continue;
								else if (this.menuItems[k].id == 3 && item.state == 1 && item.payment_type==1)
									continue;
								else if (this.menuItems[k].id == 3 &&  item.payment_type==0)
									continue;
								else if (this.menuItems[k].id == 6 &&  item.state != 2)
									continue;
								actions[k]= this.menuItems[k];
							}
							return actions;
						},
            getOrders() {
                axios.get(`/cart/api/fast-track`).then(response => {
                    this.orders = response.data;
                    this.loading = false;
                });
            },
        },
        filters: {
            price: function (price) {
                if (!price || parseFloat(price) === 0) { return '' }
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
	span.gstatus.non_completato {
		background: #F50057;
	}
</style>
