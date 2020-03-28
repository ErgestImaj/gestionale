<template>
	<v-form class="add-user">
		<v-container>
			<v-row>
				<v-col cols="12" md="8">
					<v-card outlined flat>
						<v-card-title>{{ trans('headers.base_info') }}</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-text-field
										:label="trans('form.name')"
										outlined
										v-model="course.name"
										dense
										:error-messages="getError('name')"
									></v-text-field>
								</v-col>
							</v-row>
							<v-row>
								<v-col cols="12" md="6" class="gel">
									<v-select
										dense outlined
										:label="trans('form.cat_eipass')"
										v-model="course.category"
										item-value="hashid"
										item-text="name"
										:items="categories"
										:error-messages="getError('category')"
									></v-select>
								</v-col>
								<v-col cols="12" md="6" class="gel">
									<v-text-field
										:label="trans('form.code')"
										outlined
										v-model="course.code"
										dense
										:error-messages="getError('code')"
									></v-text-field>
								</v-col>
							</v-row>
							<v-row>
								<v-col cols="12" md="6" class="gel">
									<v-text-field
										:label="trans('form.duration')"
										outlined
										v-model="course.duration"
										dense
										:error-messages="getError('duration')"
									></v-text-field>
								</v-col>
								<v-col cols="12" md="6" class="gel">
									<v-select
										dense outlined
										:label="trans('form.expiry')"
										v-model="course.expiry"
										item-value="hashid"
										item-text="name"
										:items="expirations"
										:error-messages="getError('expiry')"
									></v-select>
								</v-col>
							</v-row>

							<div class="mb-4">
								<label>{{trans('form.description')}}</label>
								<tiptap-vuetify  v-model="course.description" :extensions="extensions" />
								<div class="invalid-feedback d-block" v-if="errors.description">{{errors.description[0]}}</div>
							</div>

							<div class="mb-4">
								<label>{{trans('form.skills')}}</label>
								<tiptap-vuetify v-model="course.skills" :extensions="extensions" />
								<div class="invalid-feedback d-block" v-if="errors.skills">{{errors.skills[0]}}</div>
							</div>

							<div class="mb-4">
								<label>{{trans('form.program_description')}}</label>
								<tiptap-vuetify  v-model="course.program_description" :extensions="extensions" />
								<div class="invalid-feedback d-block" v-if="errors.program_description">{{errors.program_description[0]}}</div>
							</div>

						</v-card-text>
					</v-card>
				</v-col>

				<v-col cols="12" md="4">
					<v-card outlined flat>
						<v-card-title>{{ trans('headers.costs_info') }}</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="12" sm="12" class="gel">
									<v-text-field dense outlined
										:label="trans('form.costo')"
										v-model="course.price"
										:error-messages="getError('price')"
									></v-text-field>
									<v-text-field dense outlined
										:label="trans('form.min_order_partner')"
										v-model="course.min_order_partner"
										:error-messages="getError('min_order_partner')"
									></v-text-field>
									<v-text-field dense outlined
										:label="trans('form.min_order_master')"
										v-model="course.min_order_master"
										:error-messages="getError('min_order_master')"
									></v-text-field>
									<v-text-field dense outlined
										:label="trans('form.min_order_affiliate')"
										v-model="course.min_order_affiliate"
										:error-messages="getError('min_order_affiliate')"
									></v-text-field>
									<v-select dense outlined
										:label="trans('form.vat_rate')"
										v-model="course.vat_rate"
										item-value="hashid"
										item-text="name"
										:items="vatrates"
										:error-messages="getError('vat_rate')"
									></v-select>

								</v-col>
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
					>{{trans('form.save')}}</v-btn>
				</v-col>
			</v-row>
		</v-container>
	</v-form>
</template>


<script>
    import {
        TiptapVuetify,
        Heading,
        Bold,
        Italic,
        Strike,
        Underline,
        Code,
        Paragraph,
        BulletList,
        OrderedList,
        ListItem,
        Link,
        Blockquote,
        HardBreak,
        HorizontalRule,
        History,
        Image,
    } from "tiptap-vuetify";
    export default {
        props: ['oldCourse', 'categories', 'expirations', 'vatrates'],
        dependencies: 'globalService',
        data() {
            return {
                rrp: null,
                course: {
                    vat_rate: this.vatrates[0],
								},
								errors: {},
								loading: true,
                submiting: false,
                extensions: [
                History,
                Blockquote,
                Link,
                Underline,
                Strike,
                Italic,
                ListItem,
                BulletList,
                OrderedList,
                [
                    Heading,
                    {
                        options: {
                            levels: [1, 2, 3]
                        }
                    }
                ],
                Bold,
                Code,
                HorizontalRule,
                Paragraph,
                HardBreak,
                    Image,
            ],
						}
    		},
				components: {
            TiptapVuetify
        },
				mounted() {
            if (this.isEdit() ) {
            	console.log(this.oldCourse)
                this.course = this.oldCourse;
                this.categories.forEach(item => {
                    if (item.id === this.course.category_id) {
                        this.course.category = item;
										}
								});
                this.expirations.forEach(item => {
                    if (item.id === this.course.expiry) {
                        this.course.expiry = item;
										}
								});
                this.vatrates.forEach(item => {
                    if (item.id === this.course.vat_rate) {
                        this.course.vat_rate = item;
										}
								});
						}
				},
        methods: {
           save() {
                if (this.isEdit() && !this.submiting) {
											this.submiting = true;
											let data = JSON.parse(JSON.stringify(this.course));
											data.course_name = data.name;
											data.course_code = data.code;
											data.category = data.category.hashid;
											data.expiry = data.expiry.hashid;
											data.vat_rate = data.vat_rate.hashid;
											data.course_description = data.description;
											axios.patch(`/amministrazione/courses/${this.course.hashid}`, data)
													.then(response => {
														if (response.data.status == "success") {
															swal("Good job!", response.data.msg, "success");
															// setTimeout(function () {
															// 	location.reload();
															// }, 1500)
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
															this.errors = error.response.data.errors
													})
													.finally(() => {
															this.submiting = false;
													})

								}else{
                   if (!this.submiting){
										 this.submiting = true;
										 axios.post(`/amministrazione/courses`,this.course)
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
												 this.errors = error.response.data.errors
											 })
											 .finally(() => {
												 this.submiting = false;
											 })
									 }
								}
                //
            },

						getError(field) {
                return this.errors[field] ? this.errors[field][0] : []
						},
						isEdit() {
                return this.oldCourse && this.oldCourse.hashid
						}
        }
    }
</script>

<style scoped>

</style>
