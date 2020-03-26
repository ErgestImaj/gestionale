<template>
  <v-form class="add-lms">
    <v-overlay :value="loading">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-container>
      <v-row>
        <v-col cols="12" md="12">
          <v-card outlined flat>
            <v-card-title>{{trans('headers.base_info')}}</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" md="6" class="gel">
                  <v-text-field
                    :label="trans('form.title')"
                    outlined
                    v-model="content.title"
                    dense
                    :error-messages="errors.title ? errors.title[0] : []"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6" class="gel">
                  <v-text-field
                    :label="trans('form.code_module')"
                    outlined
                    v-model="content.code"
                    dense
                    :error-messages="errors.code ? errors.code[0] : []"
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" md="6" class="gel">
                  <v-select
                    dense
                    outlined
                    :label="trans('form.course')  | capitalize"
                    v-model="content.course"
                    :items="courses"
                    item-text="name"
                    item-value="hashid"
                    :error-messages="errors.course ? errors.course[0] : []"
										:disabled="!!prevCourse"
                  ></v-select>
                </v-col>
                <v-col cols="12" md="6" class="gel">
                  <v-select
                    dense
                    outlined
                    :label="trans('form.module')  | capitalize"
                    v-model="content.module"
                    :items="modules"
                    item-text="module_name"
                    item-value="hashid"
                    :error-messages="errors.module ? errors.module[0] : []"
										:disabled="!!selModule"
                  ></v-select>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" md="6" class="gel">
                  <v-select
                    dense
                    outlined
                    :label="trans('form.content_type')"
                    v-model="content.content_type"
                    :items="content_types"
                    item-text="name"
                    item-value="value"
                    :error-messages="errors.content_type ? errors.content_type[0] : []"
                  ></v-select>
                </v-col>
                <v-col cols="12" md="6" class="gel">
                  <v-text-field
                    v-if="showFile"
                    :label="trans('form.choose_file')"
                    outlined
                    @click="pickFile"
                    prepend-inner-icon="mdi-cloud-upload"
                    dense
                    :value="content.lms_file ? content.lms_file.name : ''"
                    :error-messages="errors.lms_file ? errors.lms_file[0] : []"
                  ></v-text-field>
                  <input
                    type="file"
                    style="display: none"
                    ref="image"
                    @change="handleFileUpload($event)"
                  />
                  <v-text-field
                    v-if="showUrl"
                    :label="trans('form.resource_link')"
                    outlined
                    v-model="content.file_path"
                    dense
                    :error-messages="errors.file_path ? errors.file_path[0] : []"
                  ></v-text-field>
                </v-col>
								<v-col cols="6">
									<v-text-field dense outlined
																label="Ordine"
																v-model="content.order"
																:error-messages="errors.order ? errors.order[0] : []"
									></v-text-field>
								</v-col>
              </v-row>

              <label>{{trans('form.description')}}</label>
              <tiptap-vuetify v-model="content.description" :extensions="extensions" />
							<div class="invalid-feedback d-block" v-if="errors.description">{{errors.description[0]}}</div>
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
  props: ['isEdit', 'editContent', 'prevCourse', 'selModule'],
  data() {
    return {
      content: {
        title: null,
        code: null,
        course: null,
        module: null,
        content_type: null,
        lms_file: null,
        file_path: null,
        description: null
      },
      courses: [],
      modules: [],
      content_types: [
        { value: "file", name: "File" },
        { value: "video", name: "Video File" },
        { value: "audio", name: "Audio File" },
        { value: "video_url", name: "Video URL" },
        { value: "audio_url", name: "Audio URL" },
        { value: "url", name: "URL" }
      ],
      showFile: false,
      showUrl: false,
      loading: true,
      submiting: false,
      errors: {},
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
				initModule: true,
    };
  },
  components: {
    TiptapVuetify
  },
  mounted() {
      this.getCourses();
  },
  methods: {
      handleEdit() {
          if (this.isEdit == true) {
              this.content = this.editContent[0];
              this.$set(this.content, 'course', this.editContent[1]);
          }
			},
      handlePrevCourse(courseid) {
          if(courseid) {
              this.courses.forEach(course => {
                 if(course.id === courseid) {
                     this.content.course = course.hashid;
								 }
							});
					}
			},
      handlePrevModule(moduleid) {
          if(moduleid) {
              this.modules.forEach(module => {
                 if(module.id === moduleid) {
                     this.content.module = module.hashid;
								 }
							});
					}
			},
    send() {
			if (!this.submiting) {
				this.loading = true;
				this.submiting = true;
				if (this.isEdit==true){
					let formData = new FormData();
					formData.append("lms_file", this.content.lms_file);
					formData.append("content", JSON.stringify(this.content));
					axios
						.post(`/lms-content/${this.content.hashid}/update`, formData, {
							headers: {
								"Content-Type": "multipart/form-data"
							}
						})
						.then(response => {
							if (response.data.status == "success") {
								swal("Good job!", response.data.msg, "success");
							}
						})
						.catch(error => {
							this.errors = error.response.data.errors;
						}).finally(() => {
						this.submiting = false;
						this.loading = false;
					});
				}else {
					let formData = new FormData();
					this.courses.forEach(i => {
						if (i.hashid === this.content.course) {
							content.course = i;
						}
					});
					this.modules.forEach(i => {
						if (i.hashid === this.content.module) {
							content.module = i;
						}
					});

					formData.append("lms_file", this.content.lms_file);
					formData.append("content", JSON.stringify(this.content));

					axios
						.post(`/lms-content`, formData, {
							headers: {
								"Content-Type": "multipart/form-data"
							}
						})
						.then(response => {
							if (response.data.status == "success") {
								swal("Good job!", response.data.msg, "success");
								this.content = {};
							}
						})
						.catch(error => {
							this.errors = error.response.data.errors;
						}).finally(() => {
						this.submiting = false;
						this.loading = false;
					});
				}

      }
    },
    getCourses() {
      this.modules = [];
      axios.get(`/filter-courses`).then(response => {
        this.courses = response.data;
        this.handleEdit();
        if (this.prevCourse) {
            this.handlePrevCourse(this.prevCourse);
				}
        this.loading = false;
      });
    },
    pickFile() {
      this.$refs.image.click();
    },
    getCourseModules(cHash) {
      this.loading = true;
      axios.get(`/course/${cHash}/modules`).then(response => {
        this.modules = response.data;
        this.loading = false;
        if (this.selModule) {
            this.handlePrevModule(this.selModule);
				}
      });
    },
    handleFileUpload(e) {
      return (this.content.lms_file = e.target.files[0]);
    }
  },
  computed: {
    selCourse() {
      return this.content.course;
    },
    selType() {
      return this.content.content_type;
    },
		parsedContent(){
    	return JSON.parse(this.editContent.toString());
		}

  },
  watch: {
    selCourse(val) {
        console.log(val);
      this.modules = [];
      if (!!val) {
          if (!this.initModule) {
              this.content.module = null;
          }
					this.getCourseModules(val);
          this.initModule = false;
      }
    },
    selType(val) {
      this.content.lms_file = null;
      this.content.file_path = null;
      if (["file", "video", "audio"].indexOf(val) > -1) {
        this.showFile = true;
        this.showUrl = false;
      } else if (["video_url", "audio_url", "url"].indexOf(val) > -1) {
        this.showUrl = true;
        this.showFile = false;
      } else {
        this.showFile = false;
        this.showUrl = false;
      }
    }
  }
};
</script>

<style>
.v-input__icon.v-input__icon--prepend-inner {
  z-index: 2;
}
</style>
