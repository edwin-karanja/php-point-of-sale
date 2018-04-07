<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="input-group">
                        <search title="Suppliers"
                                v-on:search:front="updateResults"
                                floated="left"
                                size=50
                        >
                        </search>
                    </div>
                </div>

                <!-- <excel-upload-component :url="'/ajax/items/import'"></excel-upload-component> -->

                <create-supplier v-if="response.createColumns"
                 :customColumns="response.customColumns"
                 :createColumns="response.createColumns"
                >
                </create-supplier>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body" v-if="response.suppliers.length">
                <table class="table">
                    <thead>
                        <tr>
                            <th>##</th>
                            <th v-for="column in response.displayColumns" :key="column">
                                {{ response.customColumns[column] || column }}
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(supplier, index) in response.suppliers" :key="supplier.id">
                            <td>{{ index + 1 }}</td>
                            <td v-for="column in response.displayColumns" :key="column">
                                <span v-if="column == 'name'">
                                    <a :href="'suppliers/' + supplier.id + '/profile'" >{{ supplier[column] || '-' }}</a>
                                </span>

                                <span v-else>
                                    {{ supplier[column] || '-' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="panel-body" v-else>
                <div class="well well-sm b">No supplier created yet. <a href="#" @click.prevent="createSupplier" class="btn btn-link">Create a supplier?</a></div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventHub from '../../events.js';
    import Search from '../Global/Search.vue';
    import CreateSupplier from './CreateSupplierComponent';

    export default {
        components: {
            Search,
            CreateSupplier
        },

        data () {
            return {
                response: {
                    suppliers: [],
                    columns: [],
                    customColumns: [],
                    createColumns: [],
                    displayColumns: []
                },
                searchText: null
            };
        },

        methods: {
            getSuppliers () {
                return axios.get('/suppliers/ajax').then((response) => {
                    this.response = response.data
                })
            },

            createSupplier () {
                EventHub.$emit('create-supplier')
            }
        },

        mounted() {
            this.getSuppliers()

            EventHub.$on('supplier-created', this.getSuppliers)
        }
    }
</script>
