<template>
	<div>
		<v-btn :href="createUrl" class="gadd">Nuovo Sessione</v-btn>
		<v-card>
			<v-card-title>
				Lista Mediaform
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
				<template v-slot:item.course.name="{ item }">
					<v-chip
						v-if="item.fast_track"
						color="lighten-4"
						:color="getColor(item.fast_track)"
						class="ml-0 mr-2 black--text"
						label
						small
					>
						Fast Track
					</v-chip>
					<strong>{{item.course.name}}</strong>
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

		<div class="add-student">
			<v-dialog v-model="showAddStudent" persistent fullscreen>
				<div v-if="activeExam">

					<v-card>
						<v-card-title>
							<span class="headline">Add Students</span>
						</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" md="6">
									<v-row>
										<v-col>
											<v-text-field
												v-model="searchAll"
												label="Cerca"
												dense outlined
											></v-text-field>
										</v-col>
									</v-row>

									<v-data-table
										v-model="selectedStudents"
										:headers="studentsHeaders"
										:items="allStudent"
										:search="searchAll"
										item-key="hashid"
										show-select
									>
									</v-data-table>
								</v-col>
								<v-col cols="12" md="6">
									<v-row flex justify="space-between">
										<v-col md="4">
											<v-text-field
												v-model="searchActive"
												label="Cerca"
												dense outlined
											></v-text-field>
										</v-col>
										<v-col md="2">
											<v-text-field class="sml-input" dense outlined v-model="allOraInizio" label="Ora Inizio"></v-text-field>
										</v-col>
										<v-col md="2">
											<v-text-field class="sml-input" dense outlined v-model="allOraFine" label="Ora fine"></v-text-field>
										</v-col>
										<v-col md="4">
											<v-btn color="primary" @click="setTimeForAll()">Set for all students</v-btn>
										</v-col>
									</v-row>

									<v-data-table
										v-model="selectedActiveStudents"
										:headers="activeStudentHeaders"
										:items="activeStudents"
										:search="searchActive"
										item-key="hashid"
										show-select
									>
										<template v-slot:item.orainizio="{ item }">
											<v-text-field class="sml-input" dense outlined v-model="item.orainizio"
											></v-text-field>
										</template>
										<template v-slot:item.orafine="{ item }">
											<v-text-field class="sml-input" dense outlined v-model="item.orafine"
											></v-text-field>
										</template>
									</v-data-table>
								</v-col>
							</v-row>
						</v-card-text>
						<v-card-actions>
							<v-btn color="primary" text :disabled="selectedStudents.length === 0" @click="addSelected()">Add Selected</v-btn>
							<v-btn color="warning" text :disabled="selectedActiveStudents.length === 0" @click="removeSelected()">Remove Selected</v-btn>
							<v-spacer></v-spacer>
							<v-btn color="grey darken-1" text @click="closeAddStudent()">{{trans('form.doc_close')}}</v-btn>
							<v-btn color="primary darken-1">
								{{trans('form.save')}}
							</v-btn>
						</v-card-actions>
					</v-card>

				</div>
			</v-dialog>
		</div>
	</div>
</template>

<script>
    import moment from 'moment'
    export default {
        props: ['category', 'createUrl','examType'],
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
                    { id: 1, title: "Download materiale d'esame", icon: "mdi-download" },
                    { id: 2, title: "Download dati d'esame", icon: "mdi-download" },
                    { id: 3, title: "Download risultati", icon: "mdi-download" },
                    { id: 4, title: "Edit", icon: "mdi-pencil-outline" },
                    { id: 5, title: "View", icon: "mdi-eye-outline" },
                    { id: 6, title: "Add Student", icon: "mdi-account-multiple-plus" },
                ],
                exams: [],
                editData: null,
                editDialog: false,
								activeExam: null,
								allStudent: [],
								selectedStudents: [],
								studentsHeaders: [
                    { text: "#", value: "id" },
                    { text: "Nome", value: "firstname" },
                    { text: "Cognome", value: "lastname" },
								],
								activeStudentHeaders: [
                    { text: "#", value: "id" },
                    { text: "Nome", value: "firstname" },
                    { text: "Cognome", value: "lastname" },
                    { text: "Ora Inizio", value: "orainizio" },
                    { text: "Ora Fine", value: "orafine" },
								],
								activeStudents: [],
								selectedActiveStudents: [],
								allOraInizio: '',
								allOraFine: '',
            }
        },
        mounted() {
            this.footerProps = this.globalService.tableConfig().footerProps;
            this.getExams();
            this.getAllStudent();
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
                        text: '',
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
						getColor(fastTrack){
								if (fastTrack == 2){
									return 'green'
								}else if(fastTrack ==3){
									return 'red'
								}else if (fastTrack==1){
									return 'yellow'
								}
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
                axios.get(`/exams/api/mf-exams/3`).then(response => {
                    let exams = response.data;
                    exams.forEach(item => {
                        let participants = item.participants;
                        item.students = participants;
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
						getAllStudent () {
                // /utenti/api/get-user/studenti
                axios.get(`/utenti/api/get-user/studenti`).then(response => {
                    this.allStudent = response.data;
                });
						},
            menuClick(id, item) {
                switch (id) {
                    case 4:
                        this.edit(item);
                        break;
                    case 5:
                        this.view(item);
                        break;
                    case 6:
                        this.addStudent(item);
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
						addStudent(item) {
                this.activeExam = item;
                this.showAddStudent = true;
                this.activeStudents = item.students;
                console.log(item)
						},
						closeAddStudent() {
                this.activeExam = null;
                this.showAddStudent = false;
						},
						addSelected() {
                this.selectedStudents.forEach(student => {
                    let isAlready = this.activeStudents.find(s => s.hashid === student.hashid);
                    if (!isAlready) {
                        this.activeStudents.push(student);
										}
								});
								this.selectedStudents = [];
						},
						removeSelected() {
                this.selectedActiveStudents.forEach(student => {
                    this.activeStudents.forEach((s, index) => {
                        if (student.hashid === s.hashid) {
                            this.activeStudents.splice(index, 1);
												}
										})
                });
                this.selectedActiveStudents = [];
						},
            setTimeForAll () {
                let ccStudents = JSON.parse(JSON.stringify(this.activeStudents));
                ccStudents.forEach(st => {
                    st.orainizio = this.allOraInizio;
                    st.orafine = this.allOraFine;
								});
                this.activeStudents = ccStudents;
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
