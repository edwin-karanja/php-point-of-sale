<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <div v-if="purchase.supplier.id">
                <p class="b">Name: <span class="pull-right">{{ purchase.supplier.name.toUpperCase() }}</span></p>
                <p class="b">Last purchase: <span class="pull-right">{{ purchase.supplier.last_supply_date || '-'}}</span></p>
                <hr>
                <a href="#" class="pull-right" @click.prevent="removeSupplier">Remove</a>
            </div>

            <div v-else class="form-group" :class="{'has-error': errors['supplier.id']}">
                <div class="form-group mr-6 ml-6">
                    <input type="text" class="form-control" v-model="searchSupplier" placeholder="Type supplier name" :disabled="purchase.items.length == 0">
                </div>

                <span class="help-block" v-if="errors['supplier.id']">
                    <strong>{{ errors['supplier.id'][0] }}</strong>
                </span>

                <create-supplier-component
                 :disabled="purchase.items.length == 0"
                 :customColumns="response.customColumns"
                 :createColumns="response.createColumns"
                >
                </create-supplier-component>

                <table class="table dropdown-content" v-if="filteredSuppliers.length">
                    <tbody>
                        <tr v-for="(supp, index) in filteredSuppliers" :key="supp.id">
                            <td :class="{'active': filteredSuppliers[index] == 0}">
                                <span>{{ index + 1 }}: {{ supp.name }}</span>
                                <button class="btn btn-default pull-right" @click="selectSupplier(supp)"><i class="fa fa-share"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="well well-sm dropdown-content" v-if="this.searchSupplier && filteredSuppliers.length == 0">
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

        <div class="panel-footer">

            <table class="table">
                <a href="#" @click.prevent="cancelTransaction" class="btn btn-default pull-left" v-if="purchase.items.length">
                    <i class="fa fa-times"></i>
                    Cancel
                </a>

                <button @click.prevent="postPurchase" class="btn btn-primary pull-right" v-if="purchase.items.length">

                    <span v-if="!purchase.active">
                        <i class="fa fa-shopping-cart"></i>
                    </span>
                    <span v-if="purchase.active">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </span>
                    Record Purchase
                </button>
            </table>
        </div>
    </div>
</template>

<script>
    import eventHub from '../../events.js'
    import moment from 'moment'

    export default {
        data () {
            return {
                purchase: {
                    active: false,
                    items: [],
                    transDate: null,
                    supplier: {
                        id: null
                    },
                },
                errors: [],
                searchSupplier: null,
                response: {
                    suppliers: [],
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
            getSuppliers () {
                return axios.get('/suppliers/ajax').then((response) => {
                    this.response = response.data
                })
            },

            selectSupplier (supplier) {
                this.purchase.supplier = supplier
                this.searchSupplier = null
            },

            removeSupplier () {
                this.purchase.supplier = {}
            },

            cancelTransaction () {
                eventHub.$emit('purchase-completed')
            },

            postPurchase () {
                this.purchase.active = true

                axios.post('/ajax/purchases', this.purchase).then((response) => {
                    if (response.status === 200) {
                        this.removeSupplier()
                        this.errors = []

                        eventHub.$emit('purchase-completed')
                        eventHub.$emit('success-alert', 'Purchase completed successfully.')
                        this.purchase.active = false
                    }

                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.purchase.active = false

                        this.errors = error.response.data.errors
                        eventHub.$emit('errors-in-cart', error)
                    }
                })
            }
        },

        computed: {
            filteredSuppliers () {
                if (this.searchSupplier) {
                    let data = this.response.suppliers

                    data = data.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row.name).toLowerCase().indexOf(this.searchSupplier.toLowerCase()) > -1
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
                if (this.purchase.items.length) {
                    let total = this.getTotals
                    let vat = this.getVatTax
                    let subTotals = total - vat

                    return parseFloat(subTotals).toFixed(2)
                }
            },

            getTotals () {
                if (this.purchase.items.length) {
                    let data = this.purchase.items
                    let total = 0

                    for (let i = 0; i < data.length; i++) {
                        total += data[i].buying_price * data[i].qtty_purchased
                    }

                    return parseFloat(total).toFixed(2)
                }
            },

            getVatTax () {
                if (this.purchase.items.length) {
                    let total = this.getTotals
                    var vat = total * 0.16

                    return parseFloat(vat).toFixed(2)
                }
            }
        },

        mounted() {
            this.getSuppliers()

            eventHub.$on('purchases.compute-item-total', ((item) => {
                var index = this.purchase.items.indexOf(item)

                if (index == -1) {
                    this.purchase.items.push(item)
                } else {
                    this.purchase.items.slice(index, 1, item)
                }
            }))

            eventHub.$on('purchases.item-removed-from-cart', ((item) => {
                var index = this.purchase.items.indexOf(item)

                this.purchase.items.splice(index, 1)
            }))

            eventHub.$on('supplier-created', this.getSuppliers)

            eventHub.$on('purchases.apply', ((startDate, endDate) => {
                this.purchase.transDate = moment(startDate).format('LL')
            }))
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