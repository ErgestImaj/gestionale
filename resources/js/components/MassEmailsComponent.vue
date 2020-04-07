<template>
	<v-form>
		<v-card outlined flat class="mb-4">
			<v-card-text class="pa-5">
				<v-row>
					<v-col cols="12">
						<v-text-field
							v-model="massemails.subject"
							:label="trans('form.subject')"
							outlined
							:error-messages="errors.subject ? errors.subject[0] : []"
						></v-text-field>
					</v-col>
					<v-col cols="12" >
						<label>{{trans('form.description')}}</label>
						<tiptap-vuetify v-model="massemails.description" :extensions="extensions" />
						<div class="invalid-feedback d-block" v-if="errors.description">{{errors.description[0]}}</div>
					</v-col>
					<v-col cols="12" md="6">
						<v-combobox
							chips
						 outlined
							:label="trans('form.target')"
							multiple
							:deletable-chips="true"
							v-model="massemails.target"
							:items="roles"
							item-text="name"
							item-value="id"
							attach
							:error-messages="errors.target ? errors.target[0] : []"
						></v-combobox>
					</v-col>
					<v-col cols="12" md="6">
						<v-combobox
							chips
							:deletable-chips="true"
							outlined label="Tipo"
							v-model="massemails.types"
							:items="types"
							multiple
							item-text="name"
							item-value="id"
							attach
							:error-messages="errors.types ? errors.types[0] : []"
						></v-combobox>
					</v-col>
					<v-col cols="12">
						<v-autocomplete
							 outlined
							:label="trans('form.exclude')"
							multiple
							v-model="massemails.exclude"
							:items="emails"
							item-text="email"
							item-value="email"
							@update:search-input="asyncFind"
							:error-messages="errors.exclude ? errors.exclude[0] : []"
						></v-autocomplete>
						<v-btn
							:loading="submiting"
							:disabled="submiting"
							color="primary"
							class="mt-4 ml-0 white--text"
							@click="create"
						>{{trans('form.save')}}</v-btn>
					</v-col>
				</v-row>
			</v-card-text>
		</v-card>
		<v-card>
			<v-card-title>
				{{trans('messages.comm_histoy')}}
				<v-spacer></v-spacer>
				<v-text-field v-model="search" label="Cerca" single-line hide-details></v-text-field>
			</v-card-title>
			<v-data-table
				:headers="headers"
				:items="messages"
				:search="search"
				:loading="loading"
				:footer-props="footerProps"
				class="pa-4"
			>
				<template v-slot:item.description="{ item }">
					<div v-html="item.description.replace(/<[^>]*>?/gm, '')"></div>
				</template>
				<template v-slot:item.actions="{ item }">
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
	</v-form>
</template>

<script>
	import {
		Blockquote,
		Bold,
		BulletList,
		Code,
		HardBreak,
		Heading,
		History,
		HorizontalRule,
		Italic,
		Link,
		ListItem,
		OrderedList,
		Paragraph,
		Strike,
		TiptapVuetify,
		Underline
	} from "tiptap-vuetify";
    export default {
			dependencies: 'globalService',
        data(){
            return{
							footerProps: null,
                roles:[],
                emails:[],
							  types:[],
							messages:[],
                massemails:{},
                errors: {},
                submiting: false,
							loading: true,
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
							search: "",
							check: null,
							headers: [
								{ text: "#", value: "id" },
								{ text: this.trans("form.subject"), value: "subject" },
								{ text: this.trans("form.description"), value: "description" },
								{ text: this.trans("form.target"), value: "send_to" },
								{ text: this.trans("form.exclude"), value: "exclude" },
								{ text: 'Tipo', value: "types" },
								{ text: this.trans("form.created"), value: "created" },
								{ text: this.trans("form.created_by"), value: "created_by" },
								{
									text: this.trans("form.actions"),
									value: "actions",
									sortable: false,
									align: "right"
								}
							],
            }
        },
				components: {
					TiptapVuetify
				},
        mounted() {
						this.footerProps = this.globalService.tableConfig().footerProps;
						this.loading = true;
            this.getRoles();
            this.getUserTypes();
            this.getMessages();
        },
        methods:{
            getRoles(){
                axios.get(`/amministrazione/api/getroles`)
                     .then(response=>{
                         this.roles = response.data
                     })
                     .catch(error=>{

                     })
            },
						getMessages() {
							axios.get(`/amministrazione/api/messaggi`).then(response => {
								this.messages = response.data;
								this.loading = false;
							});
						},
					asyncFind(query){
            	if (this.check == query){
            		return false;
							}
            	this.check = query
						axios.get(`/amministrazione/api/getemails/${query}`,)
							.then(response=>{
								this.emails= response.data
							})
							.catch(error=>{

							})
					},
           create () {
               if (!this.submiting) {
                   this.submiting = true
                   axios.post(`/amministrazione/messaggi`,this.massemails)
                   .then(response => {
                       console.log(response.data)
                       this.submiting = false
                       if (response.data.status == 'success'){
                           swal("Good job!", response.data.msg, "success");
                           this.getMessages()
                           this.massemails = {}
                       }else if (response.data.status == 'error'){
                           swal("Woops!", response.data.msg, "error");
                           this.massemails = {};
                       }
                   }).catch(error => {
                       this.submiting = false
                       this.errors = error.response.data.errors
                   })
               }
           },
       }
    }
</script>

