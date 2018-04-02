<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <span class="pull-left">
                <span class="ui large teal tag label">
                    Recent Payment:
                </span>
                <span class="ui large black label">
                    {{ response.recentPayment.amount_paid ? parseInt(response.recentPayment.amount_paid).toLocaleString('en-US', { style: 'currency', currency: 'ksh'}) : '-' }}
                </span>
            </span>

            <span class="pull-right">
                <span class="ui large red tag label">
                    Balance Due:
                </span>

                <span class="ui large black label">{{ response.balanceDue ? parseInt(response.balanceDue).toLocaleString('en-US', { style: 'currency', currency: 'Ksh'}) : '0.00'}}
                </span>
            </span>

        </div>
    </div>
</template>

<script type="text/babel">
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
