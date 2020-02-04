<template>
	<v-card>
		<v-card-title>
			Corsi
			<v-spacer></v-spacer>
			<v-text-field
				v-model="search"
				append-icon="search"
				label="Search"
				single-line
				hide-details
			></v-text-field>
		</v-card-title>
		<v-data-table
			:headers="headers"
			:items="corsi"
			:search="search"
			:loading="loading"
		>
			<template v-slot:header.code="{ header }"> {{ trans('form.code') }}</template>
			<template v-slot:header.category="{ header }" style="text-transform: capitalize">{{ trans('form.category') }}</template>
			<template v-slot:header.name="{ header }"> {{ trans('form.name') }}</template>
			<template v-slot:header.costo="{ header }"> {{ trans('form.costo') }}</template>
			<template v-slot:header.status="{ header }"> {{ trans('form.status') }}</template>
			<template v-slot:header.created_by="{ header }"> {{ trans('form.created_by') }}</template>
			<template v-slot:header.updated_by="{ header }"> {{ trans('form.updated_by') }}</template>
			<template v-slot:header.actions="{ header }"> {{ trans('form.actions') }}</template>
			<template v-slot:item.status="{ item }">
				<div v-html="item.status"></div>
			</template>
			<template v-slot:item.name="{ item }">
				<div v-html="item.name" class="gname"></div>
			</template>
		</v-data-table>
	</v-card>
</template>

<script>
    export default {
        data () {
            return {
                search: '',
                headers: [
                    {
                        text: '#',
                        value: 'id',
                    },
                    { text: 'code', value: 'code' },
                    { text: 'category', value: 'category' },
                    { text: 'name', value: 'name' },
                    { text: 'costo', value: 'costo' },
                    { text: 'status', value: 'status' },
                    { text: 'created_by', value: 'created_by' },
                    { text: 'updated_by', value: 'updated_by' },
                    { text: 'actions', sortable: false, align: 'right' },
                ],
                corsi: [],
								loading: true,
            }
        },
				mounted() {
            this.getCorsi();
				},
				methods: {
            getCorsi() {
                axios.get(`/amministrazione/courses`)
                    .then(response => {
                        console.log(response.data);
                        this.corsi = response.data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    }).finally(() => {
                        this.loading = false;
								});
						}
				}
    }
</script>

<style scoped>
	.gname {
		font-size: 12px;
		width: 330px;
		max-width: 330px;
	}
</style>
