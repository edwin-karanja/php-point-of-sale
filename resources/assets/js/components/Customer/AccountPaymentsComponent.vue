<template>
    <div class="panel panel-default">
        <div class="panel-heading">Payments</div>

        <div class="panel-body">
            <table class="table table-striped table-responsive" v-if="response.payments.length">
                <thead>
                    <tr>
                        <th>Receipt</th>
                        <th>Date</th>
                        <th>Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="payment in response.payments" :key="payment.id">
                        <td><a href="#">rcpt#{{ payment.id }}</a></td>
                        <td>{{ payment.created_at }}</td>
                        <td class="b">{{ payment.amount_paid }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="well well-sm" v-else>
                <b>No payments for this customer yet.</b>
            </div>
        </div>
    </div>
</template>

<script>
    import EventHub from '../../events.js';

    export default {
        props: ['customer'],

        data () {
            return {
                getUrl: null,
                postUrl: null,
                response: {
                    payments: []
                }
            };
        },

        methods: {
            getCustomerPayments () {
                axios.get(this.getUrl).then((response) => {
                    this.response = response.data
                })
            }
        },

        mounted() {
            this.getUrl = '/customers/ajax/' + this.customer.id + '/payments'

            this.getCustomerPayments()
        }
    }
</script>
