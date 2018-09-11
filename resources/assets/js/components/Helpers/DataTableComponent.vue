<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    <AppButton theme="link" class="b" v-if="response.allow.creation" @click.prevent="creating.active = !creating.active">
                        <i v-show="!creating.active" class="fa fa-plus"></i>
                        <i v-show="creating.active" class="fa fa-minus"></i>
                        {{ creating.active ? 'Hide' : 'New record' }}
                    </AppButton>
                </div>
                <div class="col-sm-4 pull-right">
                    <AppInput placeholder="Search Category" v-model="searchText" />
                </div>
            </div>

        </div>

        <transition name="fade">
            <div class="well" v-if="response.allow.creation && creating.active">
                <form action="#" class="form-horizontal" @submit.prevent="store">
                    <div class="form-group" v-for="column in response.updatable" :class="{ 'has-error': creating.errors[column] }" :key="column">
                        <label :for="column" class="col-md-3 control-label">{{ response.customColumns[column] || column }}</label>

                        <div class="col-md-6" v-if="response.columnTypes[column] === 'text'">
                            <input type="text" class="form-control" :id="column" v-model="creating.form[column]">

                            <span class="help-block" v-if="creating.errors[column]">
                                <strong>{{ creating.errors[column][0] }}</strong>
                            </span>
                        </div>

                        <div class="col-md-6" v-if="response.columnTypes[column] === 'textarea'">
                            <!-- <textarea class="form-control" :id="column" cols="30" rows="5" v-model="creating.form[column]"></textarea> -->
                            <AppTextArea :name="column" v-model="creating.form[column]" />

                            <span class="help-block" v-if="creating.errors[column]">
                                <strong>{{ creating.errors[column][0] }}</strong>
                            </span>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <AppButton @click.prevent="store" theme="primary"> Create </AppButton>
                        </div>
                    </div>
                </form>
            </div>
        </transition>


        <div class="panel-body">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>##</th>
                        <th v-for="column in response.displayColumns" :key="column">{{ response.customColumns[column] || column | capitalize }}</th>
                        <th v-if="response.allow.creation">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, index) in filteredRecords" :key="record.id">
                        <td>{{ index + 1 }}</td>
                        <td v-for="column in response.displayColumns" :key="column">
                            {{ record[column] }}
                        </td>
                        <th v-if="response.allow.creation">
                            <a href="#" class="" @click.prevent="edit(record)">Edit</a> |
                            <a href="#" class="" v-if="response.allow.deletion" @click.prevent="destroy(record.id)">
                                Delete
                            </a>
                        </th>
                    </tr>
                </tbody>
            </table>
            <pagination v-if="response.meta.last_page > 1"
                        :meta="response.meta"
                        v-on:pagination:switched="getRecords"
                        position="right"
            ></pagination>
        </div>

         <!--Edit Record Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" v-html="title"></h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" class="form-horizontal" @submit.prevent="update">
                            <div class="form-group" v-for="column in response.updatable" :class="{ 'has-error': editing.errors[column] }" :key="column">
                                <label :for="column" class="col-md-3 control-label">{{ column }}</label>

                                <div class="col-md-6" v-if="response.columnTypes[column] === 'text'">
                                    <input type="text" class="form-control" :id="column" v-model="editing.form[column]">

                                    <span class="help-block" v-if="editing.errors[column]">
                                <strong>{{ editing.errors[column][0] }}</strong>
                            </span>
                                </div>

                                <div class="col-md-6" v-if="response.columnTypes[column] === 'textarea'">
                                    <!-- <textarea class="form-control" :id="column" cols="30" rows="5" v-model="editing.form[column]"></textarea> -->
                                    <AppTextArea :name="column" v-model="editing.form[column]" />

                                    <span class="help-block" v-if="editing.errors[column]">
                                <strong>{{ editing.errors[column][0] }}</strong>
                            </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <AppButton theme="primary" @click.prevent="update">
                                        <i class="fa fa-save"></i>
                                        Update
                                    </AppButton>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <AppButton @click.prevent="closeModal">
                            Close
                        </AppButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import Pagination from '../Global/Paginator.vue';
    import Search from '../Global/Search.vue';
    import eventHub from '../../events';
    import AppInput from  '../Global/AppInput';
    import AppButton from '../Global/AppButton';
    import AppTextArea from '../Global/AppTextArea';

    export default {
        props: {
            endpoint: {
                type: String
            },

            title: {
                default: 'Default'
            }
        },

        components: {
            Pagination,
            Search,
            AppInput,
            AppButton,
            AppTextArea
        },

        data () {
            return {
                response: {
                    data: [],
                    displayColumns: [],
                    customColumns: [],
                    columnTypes: [],
                    allow: {
                        creation: null,
                        deletion: null,
                    },
                    meta: {},
                    updatable: []
                },
                creating: {
                    active: false,
                    form: {},
                    errors: []
                },
                editing: {
                    id: null,
                    form: {},
                    errors: []
                },
                searchText: '',
                sort: {
                    key: 'updated_at',
                    order: 'desc'
                },
            }
        },

        methods: {
            getRecords (page = this.response.meta.current_page, search = null) {
                return axios.get(`${this.endpoint}`, {
                    params: {
                        page: page,
                        search: search
                    }
                }).then((response) => {
                    this.response = response.data;
                })
            },

            searchRecords (search) {

                const page = this.response.meta ?
                    this.response.meta.current_page :
                    null;

                this.getRecords(page || null, search);
            },

            updateResults (text) {
                this.searchText = text;
            },

            edit (record) {
                if (this.creating.active) this.creating.active = false;

                this.editing.id = record.id;

                $('#editModal').modal('show');
                this.editing.form = record;
            },

            update () {
                axios.put(`${this.endpoint}/${this.editing.id}`, this.editing.form).then(() => {
                    this.getRecords().then(() => {
                        this.editing.id = null;
                        this.editing.form = {};
                        this.editing.errors = [];
                        this.closeModal();

                        eventHub.$emit('success-alert',  this.title + " updated.");
                    })
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.editing.errors = error.response.data.errors;
                    }
                })
            },

            destroy (record){
                if (!window.confirm('Are you sure you want to delete this record?')) {
                    return;
                }

                axios.delete(`${this.endpoint}/${record}`).then(() => {
                    this.getRecords();
                });
            },

            store () {
                axios.post(`${this.endpoint}`, this.creating.form).then(() => {
                    this.getRecords().then(() => {
                        this.creating.active = false;
                        this.creating.form = {};
                        this.creating.errors = [];

                        eventHub.$emit('success-alert', "New " + this.title + " created.");
                    })
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.errors = error.response.data.errors;
                    }
                })
            },

            closeModal () {
                $('#editModal').modal('hide');
            }
        },

        computed: {
            filteredRecords () {
                let data = this.response.data;

                data = data.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.searchText.toLowerCase()) > -1
                    })
                });

                if (this.sort.key) {
                    data = _.orderBy(data, (i) => {
                        let value = i[this.sort.key];

                        if (!isNaN(parseFloat(value))) {
                            return parseFloat(value)
                        }

                        return String(i[this.sort.key]).toLowerCase()
                    }, this.sort.order)
                }

                return data;
            }
        },

        filters: {
            capitalize: function (value) {
                if (!value) return '';

                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },

        mounted() {
            this.getRecords(1);
        }
    }
</script>


<style lang="scss">
    .well {
        border-radius: 0;
    }

    .b {
        font-weight: bold;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>