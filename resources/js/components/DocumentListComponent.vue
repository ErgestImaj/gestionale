<template>
    <div>
        <v-btn @click="addDoc()" class="gadd">Add Document</v-btn>
        <v-card>
            <v-card-title>
                Documents
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    label="Cerca"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="documents"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.actions="{ item }">
                    <a icon :href="item.editlink">
                        <v-icon>mdi-pencil</v-icon>
                    </a>
                    <a
                        icon
                        class="delete-btn"
                        :data-content="item.remMessage"
                        :data-action="item.remlink"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </a>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>
<script>
    export default {
        props: ['structureType'],
        data() {
            return {
                documents: [],
                search: '',
                headers: [
                    {text: '#', value: 'id'},
                    {text: this.trans('form.name'), value: 'name'},
                    {text: this.trans('form.category'), value: 'category'},
                    {text: this.trans('form.shared_with'), value: 'shared_with'},
                    {text: this.trans('form.created'), value: 'created'},
                    {text: this.trans('form.created_by'), value: 'created_by'},
                    {text: this.trans('form.updated_by'), value: 'updated_by'},
                    {text: this.trans('form.actions'), value: 'actions', sortable: false, align: 'right'},
                ],
                loading: true,
            }
        },
        mounted() {
            this.getDocs();
        },
        methods: {
            getDocs() {
                axios.get(`/amministrazione/area-download/`)
                    .then(response => {
											this.documents = response.data.data;
                    })
                    .catch(error => {
                    }).finally(() => {
                    this.loading = false;
                });
            },
            addDoc() {
                let nUrl = window.location.origin + '/amministrazione/download/create';
                window.location.href = nUrl;
            }
        },

};
</script>
<style>
.v-data-table thead tr th {
    text-transform: CAPITALIZE;
}
</style>
