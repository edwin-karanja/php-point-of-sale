<template>
    <div>
    <div class="panel panel-default">
        <div class="panel-body">

            <search title="Customers"
                    v-on:search:front="updateResults"
                    floated="left"
                    size=50
            >
            </search>

            <add-customer v-if="response.createColumns"
                 :customColumns="response.customColumns"
                 :createColumns="response.createColumns"
            >
            </add-customer>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-responsive" v-if="response.customers.length">
                <thead>
                    <tr>
                        <th>##</th>

                        <th v-for="column in response.displayColumns" :key="column">
                            {{ response.customColumns[column] }}
                        </th>

                        <th v-if="response.allow.creation">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in filteredCustomers" :key="customer.id">
                        <td>
                            {{ index + 1 }}
                        </td>

                        <td v-for="column in response.displayColumns" :key="column">
                            <span v-if="column == 'name'">
                                <a :href="'customers/' + customer.id + '/account'" class="b">{{ customer[column] || '-' }}</a>
                            </span>

                            <span v-else>{{ customer[column] || '-' }}</span>
                        </td>

                        <td width="12%" v-if="response.allow.creation">
                            <div class="to-hide">
                                <a class="mr-4" href="#" @click.prevent="edit(customer)">
                                    <b>Edit</b>
                                </a>
                                |
                                <a href="#" @click.prevent="destroy(customer.id)" v-if="response.allow.deletion">
                                    <b>Delete</b>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else>
                <b>No customers created yet, add one from the button in the top right.</b>
            </p>
        </div>
    </div>
</div>
</template>

<script type="text/babel">
    import eventHub from '../../events.js';
    import AddCustomer from '../Customer/AddCustomerComponent';
    import Search from '../Global/Search.vue';

    export default {
        components: {
            AddCustomer,
            Search
        },

        data () {
            return {
                searchText: '',
                response: {
                    customers: [],
                    columns: [],
                    createColumns: [],
                    customColumns: [],
                    displayColumns: [],
                    allow: {
                        creation: false,
                        deletion: false,
                    }
                },
                sort: {
                    key: 'id',
                    order: 'asc'
                }
            };
        },

        methods: {
            getCustomers () {
                return axios.get('/ajax/customers').then((response) => {
                    this.response = response.data.data
                })
            },

            edit (customer) {
                eventHub.$emit('editing-customer', customer);
            },

            destroy (id) {
                if (!window.confirm('Are you sure you want to delete this customer?')) {
                    return;
                }

                axios.delete('/ajax/customers/' + id).then(() => {
                    this.getCustomers();

                    eventHub.$emit('success-alert', 'Customer deleted.');
                })
            },

            updateResults (text) {
                this.searchText = text;
            }
        },

        computed: {
            filteredCustomers () {
                let data = this.response.customers

                data = data.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.searchText.toLowerCase()) > -1
                    })
                })

                if (this.sort.key) {
                    data = _.orderBy(data, (i) => {
                        let value = i[this.sort.key]

                        if (!isNaN(parseFloat(value))) {
                            return parseFloat(value)
                        }

                        return String(i[this.sort.key]).toLowerCase()
                    }, this.sort.order)
                }

                return data
            }
        },

        mounted () {
            this.getCustomers()

            eventHub.$on('customer-created', this.getCustomers)
        }
    }
</script>

<style scoped>
    tr:hover {
        background-color: #F5F8FC;
    }

    tr:hover > td > div.to-hide {
        display: inline;
    }

    .table > thead > tr > th {
        font-size: 14px;
        font-weight: semibold;
        color: #4A4A4A;
        text-transform: uppercase;
        background-color: #F5F8FC;
    }

    .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
        padding: 15px;
        line-height: 1.6;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    .to-hide {
        display: none;
        font-size: 14px;
    }
</style>