<template>
	<v-form class="add-promo">
		<v-container>
			<v-row>
				<v-col cols="12" md="12" class="gmidrow">
					<v-card outlined flat>
						<v-card-title>Informazioni di base</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-text-field dense outlined
																label="Nome"
																v-model="content.name"
																:error-messages="getError('name')"
									></v-text-field>

									<label>{{trans('form.description')}}</label>
									<tiptap-vuetify v-model="content.description" :extensions="extensions" />
									<div class="invalid-feedback d-block" v-if="errors.description">{{errors.description[0]}}</div>
									<v-text-field dense outlined
																label="Prezzo"
																v-model="content.price"
																:error-messages="getError('price')"
									></v-text-field>

									<v-menu content-class="gdate" v-model="datePicker1" :close-on-content-click="false"
													transition="scale-transition" offset-y min-width="290px">
										<template v-slot:activator="{ on }">
											<v-text-field readonly outlined dense v-on="on"
																		v-model="content.expiry_date"
																		label="Data scadenza"
																		:error-messages="getError('expiry_date')"
											></v-text-field>
										</template>
										<v-date-picker v-model="content.expiry_date" @input="datePicker1 = false"></v-date-picker>
									</v-menu>

									<span class="mr-3">Stato:</span>

									<v-btn-toggle v-model="content.status" group mandatory color="primary">
										<v-btn value="0">Sospeso</v-btn>
										<v-btn value="1">Attivo</v-btn>
									</v-btn-toggle>

									<v-row>
										<v-col cols="12" md="6">
													<v-text-field
														v-model="searchAll"
														label="Cerca Corsi"
														dense
													></v-text-field>

											<v-data-table
												v-model="selectedCourses"
												:headers="coursesHeaders"
												:items="courses"
												:search="searchAll"
												item-key="hashid"
												show-select
											>
											</v-data-table>
										</v-col>
										<v-col cols="12" md="6">
													<v-text-field
														v-model="searchActive"
														label="Cerca Corsi"
														dense
													></v-text-field>

											<v-data-table
												v-model="selectedActiveCourses"
												:headers="activeCoursesHeaders"
												:items="activeCourses"
												:search="searchActive"
												item-key="hashid"
												show-select
											>
												<template v-slot:item.quantity="{ item }">
													<v-text-field dense outlined
																				:error-messages="getError('corsi.' + activeCourses.map(function(x) {return x.hashid; }).indexOf(item.hashid) +'.quantity')"
																				v-model="item.quantity"
													></v-text-field>
												</template>
											</v-data-table>
										</v-col>
									</v-row>
									<v-btn color="primary" text :disabled="selectedCourses.length === 0" @click="addSelected()">Add Selected</v-btn>
									<v-btn color="warning" text :disabled="selectedActiveCourses.length === 0" @click="removeSelected()">Remove Selected</v-btn>
								</v-col>
								<v-col cols="12"><div class="invalid-feedback d-block" v-if="errors.corsi">{{errors.corsi[0]}}</div></v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row>
				<v-col cols="12" sm="12">
					<v-btn
						:loading="submiting"
						:disabled="submiting"
						color="primary"
						class="ma-0 white--text"
						@click="save"
					>Salva</v-btn>
				</v-col>
			</v-row>
		</v-container>
	</v-form>
</template>

<script>
    import moment from 'moment'
    import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList,
        ListItem, Link, Blockquote, HardBreak, HorizontalRule, History} from "tiptap-vuetify";
    export default {
        props: ['isEdit', 'data'],
        data() {
            return {
              	show:false,
                submiting: false,
                content: {},
                errors: {},
                datePicker1: false,
                courses: [],
                selectedCourses: [],
                searchAll: '',
                searchActive: '',
                selectedActiveCourses: [],
                activeCourses: [],
                coursesHeaders: [
                    { text: "#", value: "id" },
                    { text: "Nome", value: "name" },
                ],
                activeCoursesHeaders: [
                    { text: "#", value: "id" },
                    { text: "Nome", value: "name" },
                    { text: "Quantità", value: "quantity" },
                ],
                extensions: [ History, Blockquote, Link, Underline, Strike, Italic, ListItem, BulletList, OrderedList,
                    [ Heading, { options: { levels: [1, 2, 3] } } ],
                    Bold, Code, HorizontalRule, Paragraph, HardBreak
                ]
            };
        },
        components: {
            TiptapVuetify
        },
        mounted() {
        	 this.getCourses();
        	 if (!!this.isEdit) {
        	     this.handleIfEdit();
					 }
        },
        methods: {
            handleIfEdit() {
                if (this.data) {
                    this.content = this.data;
                    // this.content.expiry_date = this.moment(this.data.expiry_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
                    this.activeCourses = this.data.courses;
                    this.activeCourses.forEach(c => {
                        c.quantity = c.pivot.qty;
										});
								}
						},
					save() {
						if (!this.submiting) {
							this.content.corsi = this.activeCourses
							this.submiting = true;
              let path = '/amministrazione/api/promo-pack/store';
              if (!!this.isEdit){
								path = '/amministrazione/api/promo-pack/'+this.content.hashid+'/update';
							}
							axios.post(`${path}`,this.content)
								.then(response => {
									if (response.data.status == "success") {
										swal("Good job!", response.data.msg, "success");
										setTimeout(function () {
											window.location.href = response.data.redirect;
										}, 1500)
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
								this.submiting = false;
							});
						}
					},
					 getCourses(){
						 axios.get(`/filter-courses`)
							 .then(response => {
								 if (response.data) {
									 this.courses = response.data;
								 }
							 })
							 .catch(error => {

							 })
						},
            getError(field) {
                return this.errors[field] ? this.errors[field][0] : []
            },
            moment: function () {
                return moment();
            },
            addSelected() {
                this.selectedCourses.forEach(course => {
                    let isAlready = this.activeCourses.find(c => c.hashid === course.hashid);
                    if (!isAlready) {
                        this.activeCourses.push(course);
                    }
                });
                this.selectedCourses = [];
            },
            removeSelected() {
                this.selectedActiveCourses.forEach(course => {
                    this.activeCourses.forEach((c, index) => {
                        if (course.hashid === c.hashid) {
                            this.activeCourses.splice(index, 1);
                        }
                    })
                });
                this.selectedActiveCourses = [];
            },
        },
        computed: {
        },
        watch: {
        },
        beforeDestroy() {
            this.editor.destroy();
        },
    };
</script>

<style>
	.add-promo .v-card__title {
		background: #388e3c;
		color: white;
		padding: 10px 15px;
		box-shadow: 0 19px 20px -12px rgba(0, 0, 0, 0.25);
		background: linear-gradient(45deg, #388e3c, #81c784);
		margin-bottom: 10px;
		font-size: 18px;
		font-weight: normal;
	}
</style>
