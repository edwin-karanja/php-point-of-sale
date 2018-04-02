<template>
    <div class="mt-10">
        <div v-if="response.purchases.data.length">
            <table class="table table-striped table-bordered" id="tableAccordion">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Payment mode</th>
                        <th>Total</th>
                        <th>Balance</th>
                        <th>Action</th>
                        <th>Receipt & Payments</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="receipt in response.purchases.data" :key="receipt.id">
                        <td>
                            {{ getDate(receipt.created_at) }}
                        </td>

                        <td>
                            <span v-if="receipt.payment_status == 'FULLY PAID'" class="ui label green">
                                {{ receipt.payment_status }}
                            </span>

                            <span v-else-if="receipt.payment_status == 'PARTIALLY PAID'" class="ui label blue">
                                {{ receipt.payment_status }}
                            </span>

                            <span v-else class="ui label red">
                                {{ receipt.payment_status }}
                            </span>
                        </td>

                        <td>
                            <span class="ui label grey upper">
                                {{ receipt.payment_mode }}
                            </span>
                        </td>

                        <td class="b">
                            {{ parseInt(receipt.sale_total).toLocaleString('en-US') || '-' }}
                        </td>

                        <td class="b">
                            {{ receipt.balance_due ?
                                    parseInt(receipt.balance_due).toLocaleString('en-US') :
                                    receipt.balance_due || '-' }}
                        </td>

                        <td>
                            <a href="#" @click.prevent="openModal(receipt)" v-if="receipt.payment_status != 'FULLY PAID'" class="compact ui button primary">
                                <b>Pay</b>
                            </a>

                            <span v-else>
                                <i class="fa fa-check"></i>
                            </span>
                        </td>

                        <td width="20%">
                            <div class="to-hide">
                                <b><a @click.prevent=loadReceipt(receipt) href="#">rcpt#{{ receipt.id }}</a></b> ||
                                <b><a @click.prevent=viewPayments(receipt) href="">Payments</a></b> ||
                                <b><a @click.prevent=returnGoods(receipt) href="#" class="btn disabled">Return</a></b>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <paginate-component for="purchases" :pagination="response.purchases"></paginate-component>
        </div>

        <div class="well well-sm" v-else>
            <b>No purchases for this customer yet.</b>
        </div>

        <!-- Receipt Modal -->
        <receipt>
        </receipt>

        <!-- Make Payment Modal -->
        <div class="modal fade" id="makePayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Make Payment</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" @submit.prevent="store" @keyup.esc="closeModal">
                        <div class="row">
                            <div class="form-group" :class="{'has-error' : creating.errors['pay']}">
                                <label for="pay" class="col-md-4 control-label">Pay</label>

                                <div class="col-md-6">
                                    <input id="pay" type="text" class="form-control" v-model="creating.form['pay']" autofocus>

                                    <span class="help-block" v-if="creating.errors['pay']">
                                        <strong>{{ creating.errors['pay'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="ui button primary">
                                    <span v-if="!creating.active">
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                    </span>
                                    <span v-if="creating.active">
                                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                    </span>
                                    Make Payment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="ui button" @click.prevent="closeModal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- View Payments Modal -->
        <div class="modal fade" id="viewPayments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click.prevent="closePaymentsModal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">View Payment</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-responseive table-condensed">
                            <thead>
                                <tr>
                                    <th>##</th>
                                    <th>Date</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(payment, index) in receipt.payments">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ getDate(payment.created_at) }}</td>
                                    <td>{{ payment.amount_paid }}</td>
                                    <td>
                                        <span class="ui label grey">{{ getBalance(payment.balance_due) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="ui button" @click.prevent="closePaymentsModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import eventHub from '../../events.js';
    import Receipt from '../Helpers/Receipt.vue';

    export default {
        components: {
            Receipt
        },

        props: ['customer'],

        data () {
            return {
                makePaymentModal: null,
                viewPaymentsModal: null,
                getUrl: null,
                postUrl: null,
                receipt: {
                    payments: [],
                },
                response: {
                    purchases: {
                        data: []
                    }
                },
                activePurchase: {
                    id: null
                },
                creating: {
                    active: false,
                    form: {},
                    errors: []
                }
            };
        },

        methods: {
            getCustomerPurchases (page = null) {
                if (page) {
                    return axios.get(this.getUrl + '?page=' + page).then((response) => {
                        this.response = response.data
                    })
                }

                return axios.get(this.getUrl).then((response) => {
                    this.response = response.data
                })
            },

            openModal (purchase) {
                this.makePaymentModal.modal('show');

                this.activePurchase = purchase;
                this.postUrl = '/customers/ajax/' + this.customer.id + '/purchases/' + this.activePurchase.id;
            },

            closeModal () {
                this.makePaymentModal.modal('hide');
                this.resetForm();
            },

            resetForm () {
                this.creating.form = {};
                this.creating.errors = [];
            },

            store () {
                axios.post(this.postUrl, this.creating.form).then((response) => {
                    if (response.status == 200) {
                        this.closeModal();

                        eventHub.$emit(this.customer.name + '.payment-made');

                        this.getCustomerPurchases();
                    }
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false;
                        this.creating.errors = error.response.data.errors;
                    }
                })
            },

            getDate (timestamp) {
                let ts = new Date(timestamp);

                return ts.toString().split(' ').slice(1,4).join('-');
            },

            loadReceipt (receipt) {
                eventHub.$emit('open:receipt', receipt);
            },

            viewPayments (receipt) {
                this.receipt = {};
                this.viewPaymentsModal.modal('show');

                this.receipt = receipt;
            },

            getBalance (balance) {
                return balance == 0.00
                    ? 'Nill' :
                    parseInt(balance).toLocaleString('en-US');
            },

            closePaymentsModal () {
                this.viewPaymentsModal.modal('hide');
            },

            returnGoods (receipt) {

            }
        },

        mounted() {
            this.makePaymentModal = $('#makePayment');
            this.viewPaymentsModal = $('#viewPayments');
            this.getUrl = '/customers/ajax/' + this.customer.id + '/purchases';


            this.getCustomerPurchases();

            eventHub.$on('purchases.switched-page', ((page) => {
                this.getCustomerPurchases(page);
            }))
        }
    }
</script>

<style scoped>
    .block1 {
        display:inline-block;
        width:300px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .upper {
        text-transform: uppercase;
    }

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