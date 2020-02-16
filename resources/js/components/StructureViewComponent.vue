<template>
    <div>
        <v-btn @click="addStrutura()" class="gadd">Add Strutura</v-btn>
        <v-card>
            <v-card-title>
                Struture - {{structureType | filterStructureType}}
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
                :items="struture"
                :search="search"
                :loading="loading"
            >
                <template v-slot:item.legal_name="{ item }">
                    <div v-html="item.legal_name" class="gname"></div>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-menu bottom left content-class="gactions">
                        <template v-slot:activator="{ on }">
                            <v-btn
                                icon
                                v-on="on"
                            >
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>

                        <v-list>
                            <v-list-item
                                v-for="(m, i) in menuItems"
                                :key="i"
                                @click="menuClick(m.title, item)"
                            >
                                <v-list-item-title>{{ m.title }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
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
                struture: [],
                search: '',
                headers: [
                    {text: '#', value: 'id'},
                    {text: 'piva', value: 'piva'},
                    {text: 'legal_name', value: 'legal_name'},
                    {text: 'code', value: 'code'},
                    {text: 'email', value: 'email'},
                    {text: 'phone', value: 'phone'},
                    {text: 'legal_prov', value: 'province.title'},
                    {text: 'actions', value: 'actions', sortable: false, align: 'right'},
                ],
                loading: true,
                menuItems: [
                    {title: 'Edit'},
                    {title: 'View'},
                    {title: 'Add Discount'},
                    {title: 'Switch Account'},
                    {title: '---'},
                ],
            }
        },
        mounted() {
            this.getStructures();
        },
        methods: {
            getStructures() {
                axios.get(`/amministrazione/api/struture/${this.structureType}`)
                    .then(response => {
                        this.struture = response.data;
                    })
                    .catch(error => {
                    }).finally(() => {
                    this.loading = false;
                });
            },
            menuClick(name, item) {
                switch (name) {
                    case 'Edit':
                        this.edit(item);
                        break;
                    case 'View':
                        this.view(item);
                        break;
                    case 'Add Discount':
                        this.addDiscount(item);
                        break;
                    case 'Switch Account':
                        this.switchAccount(item);
                        break;
                }
            },
            edit(item) {
                console.log('edit', item.hashid);
            },
            view(item) {
                console.log('view', item.id);
            },
            addDiscount(item) {
                console.log('add discount', item.id);
            },
            switchAccount(item) {
                console.log('switch', item.id);
            },
            addStrutura() {
                let nUrl = window.location.origin + '/amministrazione/struture/'+this.structureType+'/create';
                window.location.href = nUrl;
            }
        },
        filters:{
            filterStructureType: function (value) {
                if (!value) return '';
                if(value == 1) return 'Partner';
                if(value == 2) return 'Master';
                if(value == 3) return 'Affiliati';
                return value;
            }
        }
    }
</script>

<style>
    .v-data-table td,
    .v-data-table th {
        font-size: 12px;
        padding: 0 3px;
    }

    .v-data-table td:first-child,
    .v-data-table th:first-child {
        padding-left: 10px;
    }

    .v-data-table td:last-child,
    .v-data-table th:last-child {
        padding-right: 10px;
    }

    .gname {
        font-size: 12px;
        max-width: 220px;
    }

    .gactions .v-list-item {
        min-height: 33px;
    }

    button.gadd {
        position: relative;
        display: block;
        float: right;
        margin-top: -50px;
        margin-bottom: 10px;
    }
</style>
