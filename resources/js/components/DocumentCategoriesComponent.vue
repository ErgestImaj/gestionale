<template>
	<v-row>
		<v-col cols="12" sm="6">
			<v-card class="mx-auto" >
				<v-toolbar color="primary" dark >
					<v-toolbar-title>Cateogories</v-toolbar-title>

					<v-spacer></v-spacer>

					<v-btn icon>
						<v-icon>mdi-magnify</v-icon>
					</v-btn>
				</v-toolbar>

				<v-list two-line>
							<v-list-item :key="item.title" v-for="item in categories">
								<template v-slot:default="{ active, toggle }">
									<v-list-item-avatar>
										<v-icon class="grey lighten-1 white--text">mdi-folder</v-icon>
										<span class="gcount">{{item.files}}</span>
									</v-list-item-avatar>

									<v-list-item-content>
										<v-list-item-title v-text="item.name"></v-list-item-title>
										<v-list-item-subtitle class="text--primary">{{ 'Files: ' + item.files}}</v-list-item-subtitle>
									</v-list-item-content>

									<v-list-item-action class="d-flex flex-row justify-space-between align-center">
											<v-btn icon>
												<v-icon color="grey lighten-1">mdi-pencil</v-icon>
											</v-btn>
											<v-btn icon>
												<v-icon color="grey lighten-1">mdi-eye</v-icon>
											</v-btn>
									</v-list-item-action>
								</template>
							</v-list-item>
				</v-list>
			</v-card>
		</v-col>

		<v-col cols="12" sm="6">
			<v-card class="mx-auto">
				<v-toolbar color="primary" dark >
					<v-toolbar-title>Add new category</v-toolbar-title>
				</v-toolbar>

				<div class="p-4">
					<v-row>
						<v-col cols="12" sm="12">
							<v-text-field
								:label="trans('form.name')"
								outlined v-model="cat.name"
							></v-text-field>
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
							>
								Add Category
							</v-btn>
						</v-col>
					</v-row>
				</div>
			</v-card>
		</v-col>
	</v-row>

</template>

<script>
    import modules from './ModulesListComponent'
    export default {
        components: {
            modules
        },
        data(){
            return {
                cat: [],
								submiting: false,
                categories: [
                    {
											name: 'Category 1',
											desc: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, tenetur.',
											files: 8
										},
                    {
                        name: 'Category 2',
                        desc: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, tenetur.',
                        files: 0
                    },
                    {
                        name: 'Category 3',
                        desc: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, tenetur.',
                        files: 5
                    }
								]
            }
        },
        methods: {
						send() {
						    this.submiting = true;
						}
				}
    }
</script>

<style scoped>

</style>
