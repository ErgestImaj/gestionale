<template>
    <div class="card">
        <div class="card-body px-0">
            <div class="row justify-content-between mx-2">
                <div class="col-7 col-md-5">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                                  <span class="input-group-text" @click="filter">
                                    <i class="fas fa-search"></i>
                                  </span>
                        </div>
                        <input type="text" class="form-control"  :placeholder="trans('form.search')" v-model.trim="filters.search" @keyup.enter="filter">
                    </div>
                </div>
                <div class="col-auto">
                    <multiselect
                        v-model="filters.pagination.per_page"
                        :options="[25,50,100,200]"
                        :searchable="false"
                        :show-labels="false"
                        :allow-empty="false"
                        @select="changeSize"
                        :placeholder="trans('form.search')">
                    </multiselect>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead>
                            <tr>
                                <th class="d-sm-table-cell" width="30%" >
                                    <a href="#" class="text-dark" @click.prevent="sort('module_name')">{{trans('form.name')}}</a>
                                    <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'module_name' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'module_name' && filters.orderBy.direction == 'desc'}"></i>
                                </th>

                                <th class="d-none d-sm-table-cell" width="14%">
                                    <a href="#" class="text-dark" @click.prevent="sort('module_credits')">{{trans('form.module_credits')}}</a>
                                    <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'module_credits' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'module_credits' && filters.orderBy.direction == 'desc'}"></i>
                                </th>
                                <th class="d-none d-sm-table-cell" width="14%">
                                    <a href="#" class="text-dark" @click.prevent="sort('module_credits_price')">{{trans('form.price')}}</a>
                                    <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'module_credits_price' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'module_credits_price' && filters.orderBy.direction == 'desc'}"></i>
                                </th>
                                <th class="d-none d-sm-table-cell" width="21%">
                                    <a href="#" class="text-dark" @click.prevent="sort('module_percentage_success')">{{trans('form.module_percentage')}}</a>
                                    <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'module_percentage_success' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'module_percentage_success' && filters.orderBy.direction == 'desc'}"></i>
                                </th>
                                <th class="d-sm-table-cell">{{trans('form.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="m in modules">
                                <td class="d-sm-table-cell">{{m.module_name  | textCut}}</td>
                                <td class="d-none d-sm-table-cell">{{m.module_credits}}</td>
                                <td class="d-none d-sm-table-cell">{{m.module_credits_price | currency}}</td>
                                <td class="d-none d-sm-table-cell">{{m.module_percentage_success | percent}}</td>
                                <td class="d-sm-table-cell">
                                    <a class="btn block-btn btn-dark" :data-tooltip="trans('headers.edit_module')" @click.prevent="updateModule(m.hashid)" href="#">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-success" :data-tooltip="trans('form.add_content')" href="#">
                                        <i class="fas fa-cube"></i>
                                    </a>
                                    <a class="delete-btn btn btn-danger" :data-content="trans('messages.delete_module')" :data-tooltip="trans('form.delete')" :data-action="'/module/'+m.hashid" href="#">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mx-2" v-if='!loading && filters.pagination.total > 0'>
                <div class="col pt-2">
                    {{filters.pagination.from}}-{{filters.pagination.to}} of {{filters.pagination.total}}
                </div>
                <div class="col" v-if="filters.pagination.last_page>1">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item" :class="{'disabled': filters.pagination.current_page <= 1}">
                                <a class="page-link" href="#" @click.prevent="changePage(filters.pagination.current_page -  1)"><i class="fas fa-angle-left"></i></a>
                            </li>
                            <li class="page-item" v-for="page in filters.pagination.last_page" :class="{'active': filters.pagination.current_page == page}">
                                <span class="page-link" v-if="filters.pagination.current_page == page">{{page}}</span>
                                <a class="page-link" href="#" v-else @click.prevent="changePage(page)">{{page}}</a>
                            </li>
                            <li class="page-item" :class="{'disabled': filters.pagination.current_page >= filters.pagination.last_page}">
                                <a class="page-link" href="#" @click.prevent="changePage(filters.pagination.current_page +  1)"><i class="fas fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="no-items-found text-center mt-5" v-if="!loading && !modules.length > 0">
                <i class="fas fa-search fa-3x text-muted"></i>
                <p class="mb-0 mt-3"><strong>{{trans('messages.not_found')}}</strong></p>
                <p class="text-muted">{{trans('messages.not_found_help')}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       data(){
           return{
               modules: [],
               filters: {
                   pagination: {
                       from: 0,
                       to: 0,
                       total: 0,
                       per_page: 25,
                       current_page: 1,
                       last_page: 0
                   },
                   orderBy: {
                       column: 'id',
                       direction: 'asc'
                   },
                   search: ''
               },
               loading: true

           }
       },
        filters:{
            textCut(value){
                if(value != '' && value != null && value.length > 20){
                    return value.substring(0,40) + '...'
                }
                return value
            }
        },
        mounted () {
            if (localStorage.getItem("filtersCourseModules")) {
                this.filters = JSON.parse(localStorage.getItem("filtersCourseModules"))
            } else {
                localStorage.setItem("filtersCourseModules", this.filters);
            }
            this.getModules()
        },
        methods:{
            getModules () {
                this.loading = true
                this.modules = []

                localStorage.setItem("filtersCourseModules", JSON.stringify(this.filters));

                axios.post(`/course/${getUrlData(2)}/modules/filter?page=${this.filters.pagination.current_page}`, this.filters)
                    .then(response => {
                        this.modules = response.data.data
                        delete response.data.data
                        this.filters.pagination = response.data
                        this.loading = false
                    })
            },
            updateModule(record){
                this.$emit('editModule',record)
            },
            // filters
            filter() {
                this.filters.pagination.current_page = 1
                this.getModules()
            },
            changeSize (perPage) {
                this.filters.pagination.current_page = 1
                this.filters.pagination.per_page = perPage
                this.getModules()
            },
            sort (column) {
                if(column == this.filters.orderBy.column) {
                    this.filters.orderBy.direction = this.filters.orderBy.direction == 'asc' ? 'desc' : 'asc'
                } else {
                    this.filters.orderBy.column = column
                    this.filters.orderBy.direction = 'asc'
                }

                this.getModules()
            },
            changePage (page) {
                this.filters.pagination.current_page = page
                this.getModules()
            }
        }
    }
</script>

<style scoped>

</style>
