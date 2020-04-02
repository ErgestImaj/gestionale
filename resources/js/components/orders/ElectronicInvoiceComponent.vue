<template>
	<div>
		<v-card>
			<v-card-title>
				Elenco fatturazione elettronica
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="invoices"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.invoice_number="{ item }">
					<span>{{item.invoice_number+'_G'}}</span>
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
                    { text: 'Numero progressivo', value: "invoice_number" },
                    { text: 'Identificativo Ordine', value: "invoice_oldnr" },
                    { text: 'Struttura', value: "user.firstname" },
                    { text: 'Tipologia ordine', value: "type_name" },
                    { text: 'Data', value: "created" },
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ],
                menuItems: [
                    { id: 1, title: "Download", icon: "mdi-download" },
                    { id: 2, title: "Cancella", icon: "mdi-delete" },

                ],
							  invoices: [],
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getInvoices();
        },
        methods: {
            getInvoices() {
                axios.get(`/cart/api/electronic-invoice`).then(response => {
                    this.invoices = response.data;
                    this.loading = false;
                });
            },
					menuClick(id, item) {
						switch (id) {
							case 1:
								//download
								break;
							case 2:
								//delete
								break;
						}
					},
        },
    }
</script>

