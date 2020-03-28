<template>
	<div>
		<v-btn @click="addLms()" class="gadd">{{ trans('form.add_content') }}</v-btn>
		<v-card>
			<v-card-title>
				Lista Lrn
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="exams"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.participants="{ item }">
					<v-menu bottom offset-y transition="scale-transition" class="gvm">
						<template v-slot:activator="{ on }">
							<v-btn small color="primary" text v-on="on" v-if="item.participants && item.participants.length > 0">
								Vedi <span class="gcc">{{ candidati( item.participants ).length }}</span>
							</v-btn>
						</template>
						<v-list dense>
							<v-list-item
								v-for="(item, index) in candidati( item.participants )"
								:key="index"
							>
								<v-list-item-title>{{ item }}</v-list-item-title>
							</v-list-item>
						</v-list>
					</v-menu>
				</template>
				<template v-slot:item.state="{ item }">
					<v-icon>{{ item.state == '1' ? 'mdi-checkbox-marked-circle-outline' : 'mdi-minus-circle-outline'}}</v-icon>
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
    import moment from 'moment'
    export default {
        props: ['category'],
        dependencies: 'globalService',
        data() {
            return {
                footerProps: null,
                search: '',
                loading: true,
                menuItems: [
                    { id: 2, title: "Download materiale d'esame", icon: "mdi-download" },
                    { id: 2, title: "Download dati d'esame", icon: "mdi-download" },
                    { id: 2, title: "Download risultati", icon: "mdi-download" },
                    { id: 1, title: "Edit", icon: "mdi-pencil-outline" },
                    { id: 2, title: "View", icon: "mdi-eye-outline" },
                ],
                exams: [],
                editData: null,
                editDialog: false
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getExams();
        },
				computed: {
            searchText() {

						},
            headers() {
                return [
                    { text: "#", value: "id" },
                    { text: 'Struttura', value: "owner.firstname" },
                    { text: 'Titolo corso', value: "course.name" },
                    { text: 'Sede', value: "location" },
                    { text: 'Candidati', value: "participants", sortable: false },
                    { text: 'Data', value: "date" },
                    { text: 'Orario', value: "orario" },
                    { text: 'Examiner', value: "examiner"},
                    { text: 'Invigilator', value: "invigilator" },
                    { text: 'Stato', value: "state", filterable: false},
                    {
                        text: this.trans("form.actions"),
                        value: "actions",
                        sortable: false,
                        align: "right"
                    }
                ]
						}
				},
        methods: {
            getName(val) {
                if (val && val.firstname && val.lastname) {
                    return val.firstname + ' ' + val.lastname;
								} else if (val && val.display_name) {
                    return val.display_name;
								}
                return '';
            },
						orario(start_hour, start_minute) {
                if (start_hour && start_minute) {
                    return start_hour + ':' + start_minute;
								}
                return '';
						},
            candidati(val) {
                return val.split('|');
						},
            getExams() {
                axios.get(`/exams/api/lrn-exams`).then(response => {
                    let exams = response.data;
                    exams.forEach(item => {
                        let participants = item.participants;
                        let names = [];
                        if (participants && participants.length > 0) {
                            participants.forEach(p => {
                                names.push( this.getName(p) );
                            })
                        }
                        item.participants = names.join('|');
                        item.orario = this.orario(item.start_hour, item.start_minute);
                        item.date = this.momentDate(item.date);
                        item.examiner = this.getName(item.examiner);
                        item.invigilator = this.getName(item.invigilator);

										});
                    this.exams = exams;
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
                let nUrl = window.location.origin + "/lms-content/" + item.hashid+"/edit";
                window.location.href = nUrl;
            },
            view(item) {
                let nUrl = window.location.origin + "/lms-content/" + item.hashid;
                window.location.href = nUrl;
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
            }
        }
    }
</script>

<style>
	#app.exams .v-menu__content {
		margin-top: 0 !important;
	}
</style>
