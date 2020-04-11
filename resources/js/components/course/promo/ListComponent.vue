<template>
	<div>
		<v-btn :href="createUrl" class="gadd">Nuovo Promo Pack</v-btn>
		<v-card>
			<v-card-title>
				Lista Promo Pack
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="items"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.state="{ item }">
					<v-icon>{{ item.state == 1 ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
				</template>
				<template v-slot:item.description="{ item }">
					<p v-html="item.description"></p>
				</template>
				<template v-slot:item.courses="{ item }">
						<ul class="promo-courses">
							<li v-for="course of item.courses" :key="course.id">{{ course.name }}</li>
						</ul>
				</template>
				<template v-slot:item.price="{ item }">
					{{ item.price | price }}
				</template>
				<template v-slot:item.expiry_date="{ item }">
					{{ item.expiry_date | moment }}
				</template>
				<template v-slot:item.created="{ item }">
					{{ item.created | moment }}
				</template>
			</v-data-table>
		</v-card>
	</div>
</template>

<script>
    import moment from 'moment'
    export default {
        props: ['createUrl'],
        dependencies: 'globalService',
        data() {
            return {
                showAddStudent: false,
                footerProps: null,
                search: '',
								searchAll: '',
								searchActive: '',
                loading: true,
                menuItems: [
                    { id: 1, title: "Edit", icon: "mdi-pencil-outline" },
                    { id: 2, title: "View", icon: "mdi-eye-outline" },
                ],
                items: [],
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getData();
        },
				computed: {
            searchText() {

						},
            headers() {
                return [
                    { text: "#", value: "id" },
                    { text: "Promo", value: "name" },
                    { text: "Descrizione promo", value: "description" },
                    { text: "Prezzo", value: "price" },
                    { text: "Data fine", value: "expiry_date" },
                    { text: "Corsi", value: "courses" },
                    { text: "Stato", value: "state" },
                    { text: "Creato il", value: "created" },
                    { text: "Creato da", value: "created_by" },
                    {
                        text: '',
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ]
						}
				},
        methods: {
            getData() {
                axios.get(`/amministrazione/api/promo-pack`).then(response => {
                    let items = response.data;
                    this.items = items;
                    this.loading = false;
                });
            },
            menuClick(id, item) {
                switch (id) {
                    case 1:
                        this.edit(item);
                        break;
                    case 2:
                        this.view(item);
                        break;
                }
            },
            edit(item) {
                // let nUrl = window.location.origin + "/lms-content/" + item.hashid+"/edit";
                // window.location.href = nUrl;
            },
            view(item) {
                // let nUrl = window.location.origin + "/lms-content/" + item.hashid;
                // window.location.href = nUrl;
            },
            moment: function () {
                return moment();
            },
						momentDate: function(date) {
                if (!date) { return '-' }
                return moment(date).format('DD-MM-YYYY');
						}
        },
        filters: {
            moment: function (date) {
                if (!date) { return '-' }
                return moment(date).format('DD-MM-YYYY');
            },
            price: function (price) {
                if (!price || parseFloat(price) === 0) { return '' }
                return parseFloat(price).toString() + ' €';
            }
        },
    }
</script>

<style>
	ul.promo-courses li::before {
		content: "";
		width: 10px;
		display: inline-block;
		height: 2px;
		background: rgb(56, 142, 60);
		top: -4px;
		position: relative;
		margin-left: -15px;
		margin-right: 5px;
	}
	ul.promo-courses {
		list-style: none;
		padding-left: 15px;
	}
</style>
