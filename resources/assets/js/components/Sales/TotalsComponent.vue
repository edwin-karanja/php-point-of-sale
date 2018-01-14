<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <div v-if="sale.customer.id">
                <p class="b">Name: <span class="pull-right">{{ sale.customer.name }}</span></p>
                <p class="b">Gender: <span class="pull-right">{{ sale.customer.gender }}</span></p>
                <p class="b">Due Balance: <span class="pull-right">NULL</span></p>
                <hr>
                <a href="#" class="pull-right" @click.prevent="removeCustomer">Remove</a>
            </div>

            <div v-else class="form-group" :class="{'has-error': errors['customer.id']}">
                <div class="form-group mr-6 ml-6">
                    <input type="text" class="form-control" v-model="searchCustomer" placeholder="Type customer name" :disabled="sale.items.length == 0">
                </div>

                <span class="help-block" v-if="errors['customer.id']">
                    <strong>{{ errors['customer.id'][0] }}</strong>
                </span>

                <add-customer-component
                    :disabled="sale.items.length == 0"
                    :customColumns="response.customColumns"
                    :createColumns="response.createColumns"
                >
                </add-customer-component>

                <table class="table dropdown-content" v-if="filteredCustomers.length">
                    <tbody>
                        <tr v-for="(cust, index) in filteredCustomers" :key="cust.id">
                            <td :class="{'active': filteredCustomers[index] == 0}">
                                <span>{{ index + 1 }}: {{ cust.name }}</span>
                                <button class="btn btn-default pull-right" @click="selectCustomer(cust)"><i class="fa fa-share"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="well well-sm dropdown-content" v-if="this.searchCustomer && filteredCustomers.length == 0">
                    No results
                </div>
            </div>
        </div>

        <div class="panel-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td class="b">Kshs. {{ getSubtotals || '-'}}</td>
                    </tr>
                    <tr>
                        <th>vat tax(16%)</th>
                        <td>Kshs. {{ getVatTax || '-' }}</td>
                    </tr>
                    <tr>
                        <th>Total amount</th>
                        <td class="b">Kshs. {{ getTotals || '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel-footer" :class="{'mpesa-green': sale.payment_mode == 'mpesa'}">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Payment Mode</th>
                        <td>
                            <select name="payment_mode" id="payment_mode" class="form-control" @change="updateFormPayment" v-model="sale.payment_mode">
                                <option value="cash">Cash</option>
                                <option value="mpesa">M-Pesa</option>
                                <option value="oncredit">On credit</option>
                            </select>
                        </td>
                    </tr>
                    <tr v-if="sale.payment_mode == 'mpesa'">
                        <th>M-pesa Ref#</th>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="sale.mpesa_ref">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Amount Tendered</th>
                        <td>
                            <div class="form-group" :class="{'has-error': tendered_error}">
                                <input type="text" class="form-control" v-model="tendered" :disabled="sale.payment_mode === 'mpesa'">

                                <span class="help-block" v-if="tendered_error">
                                    <strong>{{ tendered_error }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Change due</th>
                        <td class="b">Kshs. {{ getBalance || 0 }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <a href="#" @click.prevent="cancelTransaction" class="btn btn-default pull-left" v-if="sale.items.length">
                    <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
                    Cancel
                </a>

                <form @submit.prevent="postSale" v-if="sale.items.length">
                    <button type="submit" class="btn btn-primary pull-right">
                        <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M17 16a3 3 0 1 1-2.83 2H9.83a3 3 0 1 1-5.62-.1A3 3 0 0 1 5 12V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v1h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H5a1 1 0 0 0 0 2h12zM7 12h9.38l3-6H7v6zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                        Complete Sale
                    </button>
                </form>
            </table>
        </div>
    </div>
</template>

<script>
    import eventHub from '../../events.js'

    export default {
        data () {
            return {
                sale: {
                    items: [],
                    customer: {
                        id: null
                    },
                    payment_mode: 'cash',
                    mpesa_ref: null,
                },
                errors: [],
                tendered: null,
                tendered_error: null,
                searchCustomer: null,
                response: {
                    customers: [],
                    columns: [],
                    customColumns: [],
                    createColumns: [],
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

            selectCustomer (customer) {
                this.sale.customer = customer
                this.searchCustomer = null
            },

            removeCustomer () {
                this.sale.customer = {}
            },

            updateFormPayment () {
                if (this.sale.payment_mode === 'mpesa') {
                    this.tendered = this.getTotals
                } else if (this.sale.payment_mode === 'cash') {
                    this.sale.mpesa_ref = null
                }
            },

            cancelTransaction () {
                eventHub.$emit('sale-completed')
            },

            postSale () {
                if (!this.tendered) {
                    this.tendered_error = 'Enter the tendered amount';
                    return;
                }
                this.tendered_error = null

                axios.post('/ajax/sales', this.sale).then((response) => {
                    if (response.status === 200) {
                        this.removeCustomer()
                        this.tendered = null
                        this.errors = []

                        eventHub.$emit('sale-completed')
                        eventHub.$emit('success-alert', 'Sale completed successfully.')
                    }

                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors

                        eventHub.$emit('errors-in-cart', error)
                    }
                })
            }
        },

        computed: {
            filteredCustomers () {
                if (this.searchCustomer) {
                    let data = this.response.customers

                    data = data.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row.name).toLowerCase().indexOf(this.searchCustomer.toLowerCase()) > -1
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
                return []
            },

            getSubtotals () {
                if (this.sale.items.length) {
                    let total = this.getTotals
                    let vat = this.getVatTax
                    let subTotals = total - vat

                    return parseFloat(subTotals).toFixed(2)
                }
            },

            getTotals () {
                if (this.sale.items.length) {
                    let data = this.sale.items
                    let total = 0

                    for (let i = 0; i < data.length; i++) {
                        total += data[i].selling_price * data[i].qtty_sold
                    }

                    return parseFloat(total).toFixed(2)
                }
            },

            getVatTax () {
                if (this.sale.items.length) {
                    let total = this.getTotals
                    var vat = total * 0.16

                    return parseFloat(vat).toFixed(2)
                }
            },

            getBalance () {
                if (this.sale.items.length && this.tendered) {
                    return this.tendered - this.getTotals
                }
            }
        },

        mounted() {
            this.getCustomers()

            eventHub.$on('compute-item-total', ((item) => {
                var index = this.sale.items.indexOf(item)

                if (index == -1) {
                    this.sale.items.push(item)
                } else {
                    this.sale.items.slice(index, 1, item)
                }
            }))

            eventHub.$on('item-removed-from-cart', ((item) => {
                var index = this.sale.items.indexOf(item)

                this.sale.items.splice(index, 1)
            }))

            eventHub.$on('customer-created', this.getCustomers)
        }
    }
</script>


<style scoped>
    .b {
        font-weight: bold;
    }

    .dropdown-content {
        margin-top: 10px;
        display: float;
        position: absolute;
        background-color: #f9f9f9;
        width: 80%;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 5px;
    }

    .mpesa-green {
        background-color: rgba(167, 250, 167, 0.801);
    }
</style>