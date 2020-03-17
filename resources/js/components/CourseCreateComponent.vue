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
										item-value="id"
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
										v-model="course.expiration"
										item-value="id"
										item-text="name"
										:items="expirations"
										:error-messages="getError('expiration')"
									></v-select>
								</v-col>
							</v-row>

							<div class="mb-4">
								<label>{{trans('form.description')}}</label>
								<tiptap-vuetify v-model="course.description" :extensions="extensions" />
							</div>

							<div class="mb-4">
								<label>{{trans('form.skills')}}</label>
								<tiptap-vuetify v-model="course.skills" :extensions="extensions" />
							</div>

							<div class="mb-4">
								<label>{{trans('form.program_description')}}</label>
								<tiptap-vuetify v-model="course.program_description" :extensions="extensions" />
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
										v-model="course.vatRate"
										item-value="id"
										item-text="name"
										:items="vatrates"
										:error-messages="getError('vatRate')"
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
						@click="send"
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
        History
    } from "tiptap-vuetify";
    export default {
        props: ['categories', 'expirations', 'vatrates'],
        data() {
            return {
                course: {
                    vatRate: 1,
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
                HardBreak
            ],
						}
    		},
				components: {
            TiptapVuetify
        },
				mounted() {
            console.log(this.categories);
				},
        methods: {
            send() {
                //
            },
						getError(field) {
                return this.errors[field] ? this.errors[field][0] : []
						}
        }
    }
</script>

<style scoped>

</style>
