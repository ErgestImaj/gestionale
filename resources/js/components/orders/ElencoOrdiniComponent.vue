<template>
	<div>
		<v-card>
			<v-card-title>
				Storico degli ordini
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
					<div v-if="item.type == 1 && item.paypal_transactions">
						<span content="gnam">{{item.paypal_transactions.user_full_name}}</span>
					</div>
					<div v-else v-for="order in item.order_items" :key="order.id"
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
				<template v-slot:item.status_name="{ item }">
					<span :class="'gstatus ' + item.status_name.split(' ').join('_').toLowerCase()">{{ item.status_name }}</span>
				</template>
				<template  v-slot:item.actions="{ item }">
					<v-menu v-if="item.status != 3 && item.status != 0 " bottom left content-class="gactions">
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
		<v-dialog v-model="editDialog" persistent max-width="600px">
			<v-card>
				<v-card-title>
					<span class="headline">Carica ricevuta di pagamento</span>
				</v-card-title>
				<v-card-text>
					<v-container>
						<v-form>
							<v-row>
								<v-col cols="12" sm="12">
									<v-text-field
										dense
										readonly
										label="File"
										outlined
										@click="pickFile()"
										:error-messages="errors.fattura ? errors.fattura[0] : []"
										prepend-inner-icon="mdi-cloud-upload"
										:value="image ? image.name : '' "
									></v-text-field>
									<input
										type="file"
										style="display: none"
										ref="file"
										@change="handleFileUpload($event)"
									/>
								</v-col>
							</v-row>
						</v-form>
					</v-container>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="grey darken-1" text @click="closeEdit()">{{trans('form.doc_close')}}</v-btn>
					<v-btn color="primary darken-1" @click="uploadInvoice(record)">
						Upload
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
    export default {
        dependencies: 'globalService',
        data() {
            return {
                footerProps: null,
								editDialog: false,
								search: '',
                loading: true,
                headers: [
                    { text: 'Identificativo Ordine', value: "order_number" },
                    { text: 'Struttura', value: "structure.firstname" },
                    { text: 'Acquisto', value: "order_items" },
                    { text: 'Totale', value: "price" },
                    { text: 'Tipologia ordine', value: "type_name" },
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
                    { id: 3, title: "Scarica ricevuta", icon: "mdi-file-download-outline" },
                    { id: 4, title: "Carica ricevuta di pagamento", icon: "mdi-upload" },
                    { id: 5, title: "Conferma pagamento", icon: "mdi-timer-sand" },
                    { id: 6, title: "Fattura elettronica", icon: "mdi-receipt" },
                ],
                orders: [],
								image:'',
								errors: {},
								record:null
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getOrders();
        },
        methods: {
					pickFile() {
						this.$refs.file.click();
					},
					handleFileUpload(e, i) {
						this.image = e.target.files[0];
					},
					closeEdit() {
						this.editDialog = false
						this.image = '';
					},
					openUpload(record){
						this.editDialog = true;
						this.record = record;
					},
					uploadInvoice(record){
						let formData = new FormData();
						formData.append("fattura", this.image);
						axios.post(`/cart/api/orders/${record}/upload`,formData,
							{
								headers: {
									"Content-Type": "multipart/form-data"
								}
							}
						)
							.then(response => {
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
							})
							.catch(error => {
								this.errors = error.response.data.errors;
							}).finally(()=>{
							this.closeEdit();
						});
					},confirmOrder(record){
						axios.patch(`/cart/api/orders/${record}/confirm`)
							.then(response => {
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
							})
							.catch(error => {})
							.finally(()=>{});
					},
						showActions(item){
							let actions = {};
							for (let k in this.menuItems) {
								if (this.menuItems[k].id == 5 && item.status == 2)
									continue;
								else if (this.menuItems[k].id == 3 && !item.receipt)
									continue;
								else if (( this.menuItems[k].id == 4 && item.payment_type ==0) ||(this.menuItems[k].id == 4 && item.status ==2)  || (this.menuItems[k].id == 4 && item.receipt))
									continue;
								else if ((this.menuItems[k].id == 2 || this.menuItems[k].id == 1 || this.menuItems[k].id == 6 ) && item.status != 2)
									continue;
								actions[k]= this.menuItems[k];
							}
							return actions;
						},
						menuClick(id, item) {
							switch (id) {
								case 1:
									this.sendInvoice(item.hashid)
									break;
								case 2:
									let nurl =	window.location.origin + `/cart/api/orders/${item.hashid}/download`;
									window.location.href = nurl;
									break;
								case 3:
									let url =
										window.location.origin + item.content_path+ item.token+'/'+ item.receipt;
									this.downloadItem(url,item.receipt)
									break;
								case 4:
									this.openUpload(item.hashid)
									break;
								case 5:
									this.confirmOrder(item.hashid)
									break;
								case 6:
									let durl =	window.location.origin + `/cart/generate-electronic-invoice/orders/${item.hashid}`;
									window.location.href = durl;
									break;
							}
						},
            getOrders() {
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
