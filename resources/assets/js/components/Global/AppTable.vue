<template>
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="col-sm-4">
                <div class="form-group has-feedback">
                    <AppInput v-model="searchText" placeholder="Search..." v-on:enter="searchRecords" v-on:clear="clearSearch"></AppInput>
                    <span v-if="searchText" class="glyphicon glyphicon-remove form-control-feedback grey handle" aria-hidden="true"></span>
                    <span v-if="!searchText" class="glyphicon glyphicon-search form-control-feedback grey" aria-hidden="true"></span>
                </div>
            </div>
            <AppButton @click.prevent="searchRecords">
                <i class="glyphicon glyphicon-search"></i> Search
            </AppButton>

            <div class="btn-group pull-right">
                <AppButton class="dropdown-toggle" size="small" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="glyphicon glyphicon-filter"></i>
                </AppButton>
                <ul class="dropdown-menu">
                    <li>
                        <label class="checkbox" style="padding-left: 40px;">
                            Form Fields
                        </label>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li v-for="field in fields">
                        <label class="checkbox" style="padding-left: 40px;">
                            <input :value="field" v-model="visibleFields" type="checkbox" > {{ field }}
                        </label>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <label class="checkbox" style="padding-left: 40px;">
                            <input v-model="deleted" @change="fetchDeleted()" type="checkbox"> Deleted Records
                        </label>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th v-for="header in fields" :key="header" @click.prevent="sortRecords(header)" class="handle">
                            {{ header }}

                            <i class="glyphicon glyphicon-sort-by-attributes-alt grey"></i>
                            <!--<i class="glyphicon glyphicon-sort-by-attributes"></i>-->
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="row in records">
                        <td v-for="field in fields">{{ row[field] }}</td>
                        <td>
                            <router-link class="btn btn-default btn-sm" :to="{ name: 'view-product', params: { resource: resource, id: row.id } }">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </router-link>
                            <router-link class="btn btn-default btn-sm" :to="{ name: 'edit-product', params: { resource: resource, id: row.id } }">
                                <i class="glyphicon glyphicon-edit"></i>
                            </router-link>
                            <AppButton size="small"  v-if="!row.deleted_at" @click="openDeleteModal(row)">
                                <i class="glyphicon glyphicon-trash red"></i>
                            </AppButton>
                            <AppButton size="small" v-if="row.deleted_at" @click="openRestoreModal(row)">
                                <i class="glyphicon glyphicon-refresh green"></i>
                            </AppButton>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <Paginator v-if="meta.last_page > 1"
                           :meta="meta"
                           v-on:pagination:switched="switchPage"
                           position="right"
                ></Paginator>

                <AppModal
                        name="deleteModal"
                        v-on:delete:confirmed="deleteRecord"
                        v-on:restore:confirmed="restoreRecord"
                >
                    <template slot="main">
                        <p>{{ modalMessage }}</p>
                    </template>
                </AppModal>
            </div>
        </div>
    </div>

</template>

<script>
    import AppTableRow from './AppTableRow';
    import AppButton from './AppButton';
    import Paginator from './Paginator';
    import AppModal from './AppModal';
    import AppInput from './AppInput';

    export default {
        components: {
            AppTableRow,
            AppButton,
            Paginator,
            AppModal,
            AppInput
        },

        props: {
            endpoint: {
                type: String,
                required: true,
            },
            resource: {
                type: String,
                required: true
            },

            records: {
                type: Array,
                required: true
            },

            fields: {
                type: Array,
                required: true
            },

            shownFields: {
                type: Object,
                required: false
            },

            links: {
                type: Object,
                required: true
            },

            meta: {
                type: Object,
                required: true
            },

            header: {
                type: String,
                required: false,
                default: 'Default Header'
            }
        },

        data () {
            return {
                visibleFields: [],
                searchText: '',
                deleted: false,
                modalMessage: '',
                sort: {
                    column: '',
                    order: 'desc'
                }
            };
        },

        methods: {
            switchPage (page) {
                this.$router.push('?page='+page)
                this.$emit('pagination:switched', page);
            },

            openDeleteModal (row) {
                this.modalMessage = 'Are you Sure you want to delete this record?';
                this.$emit('deleteModal:open', row);
            },

            deleteRecord (record) {
                this.$emit('delete:record', record);
            },

            searchRecords () {
                this.$emit('search:records', this.searchText);
            },

            clearSearch () {
                this.searchText = '';
                this.$emit('search:records', this.searchText);
            },

            sortRecords (column) {
                this.sort.column = column;
                this.sort.order = (this.sort.order === 'desc') ? 'asc' : 'desc';

                this.$emit('sort:records', this.sort);
            },

            fetchDeleted () {
                this.$emit('fetch:deleted', this.deleted)
            },

            openRestoreModal (record) {
                this.modalMessage = 'Are you Sure you want to restore this record?';
                this.$emit('deleteModal:restore', record)
            },

            restoreRecord (record) {
                this.$emit('restore:record', record)
            }
        },

        mounted () {

        },

        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            },

            lowercase: function (value) {
                if (!value) return ''
                return value.toString().toLowerCase();
            },

            uppercase: function (value) {
                if (!value) return ''
                return value.toString().toUpperCase();
            }
        }
    }
</script>

<style>
    .handle {
        cursor: pointer;
    }

    .grey {
        color: grey;
    }

    .red {
        color: red;
    }

    .green {
        color: green;
    }
</style>