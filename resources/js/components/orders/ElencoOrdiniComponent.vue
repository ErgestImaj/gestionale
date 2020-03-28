<template>
	<div>
		<v-card>
			<v-card-title>
				Elenco Ordini
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
						<span class="gnam">{{ order && order.course && order.course.name ? order.course.name : ''}}</span>
						<v-chip right label small outlined class="ma-1">
							{{ order.qty + ' x '  }}{{ order.price | price }}
						</v-chip>
					</div>

				</template>
				<template v-slot:item.price="{ item }">
					<span>{{item.price | price}}</span>
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
    export default {
        dependencies: 'globalService',
        data() {
            return {
                footerProps: null,
                search: '',
                loading: true,
                headers: [
                    { text: 'Identificativo Ordine', value: "order_number" },
                    { text: 'Struttura', value: "structure.firstname" },
                    { text: 'Acquisto', value: "order_items" },
                    { text: 'Totale', value: "price" },
                    { text: 'Tipologia ordine', value: "type_name" },
                    { text: 'Metodo pagamento', value: "payment_type" },
                    { text: 'Data', value: "order_date" },
                    { text: 'Stato', value: "status" },
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ],
                menuItems: [
                    { id: 1, title: "Inoltra nuovamente fattura", icon: "mdi-receipt" },
                    { id: 2, title: "Scarica fattura", icon: "mdi-download" },
                    { id: 2, title: "Scarica ricevuta", icon: "mdi-download" },
                ],
                orders: [],
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getTrackings();
        },
        methods: {
            getTrackings() {
                axios.get(`/cart/api/orders`).then(response => {
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
		height: 47px;
		text-align: center;
		line-height: 47px;
		font-size: 14px;
	}
	span.gstatus.ricevuto {
		background: #81C784;
	}
</style>
