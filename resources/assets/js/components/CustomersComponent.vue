<template>
    <div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Search by any column" v-model="searchText">
            </div>

            <button class="btn btn-primary pull-right">
                Excel Import
            </button>

            <add-customer-component v-if="response.createColumns"
                 :customColumns="response.customColumns"
                 :createColumns="response.createColumns"
            >
            </add-customer-component>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-condensed" v-if="response.customers.length">
                <thead>
                    <tr>
                        <th>##</th>
                        <th v-for="column in response.displayColumns" :key="column">{{ response.customColumns[column] }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in filteredCustomers" :key="customer.id">
                        <td>{{ index + 1 }}</td>
                        <td v-for="column in response.displayColumns" :key="column">
                            <span v-if="column == 'gender' && customer.gender == 'M'">Male</span>
                            <span v-else-if="column == 'gender' && customer.gender == 'F'">Female</span>
                            <span v-else>{{ customer[column] || '-' }}</span>
                        </td>
                        <td>
                            <a class="mr-4" href="#" @click.prevent="edit(customer)">Edit</a>
                            <a href="#" @click.prevent="destroy(customer.id)">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else>
                No customers created yet, add one from the button in the top right.
            </p>
        </div>
    </div>
</div>
</template>

<script>
    import eventHub from '../events.js'

    export default {
        data () {
            return {
                searchText: '',
                response: {
                    customers: [],
                    columns: [],
                    createColumns: [],
                    customColumns: [],
                    displayColumns: []
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
                    this.response = response.data
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
                    this.getCustomers()

                    eventHub.$emit('success-alert', 'Customer deleted.')
                })
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
