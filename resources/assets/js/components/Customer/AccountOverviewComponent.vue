<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <span class="pull-left">Recent Payment: <span class="badge">{{ parseInt(response.recentPayment.amount_paid).toLocaleString('en-US', { style: 'currency', currency: 'ksh'}) }}</span></span>
            <span class="pull-right">Balance Due: <span class="badge">{{ parseInt(response.balanceDue).toLocaleString('en-US', { style: 'currency', currency: 'Ksh'}) }}</span></span>
        </div>
    </div>
</template>

<script>
    import EventHub from '../../events.js';

    export default {
        props: ['customer'],

        data() {
            return {
                url: '/customers/ajax/' + this.customer.id + '/overview',
                response: {
                    recentPayment: {
                        amount_paid: null,
                    },
                    balanceDue: null
                }
            };
        },

        methods: {
            getAccountOverviewDetails () {
                axios.get(this.url).then((response) => {
                    this.response = response.data
                })
            }
        },

        mounted() {
            this.getAccountOverviewDetails()

            EventHub.$on(this.customer.name + '.payment-made', this.getAccountOverviewDetails)
        }
    }
</script>
