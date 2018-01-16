<template>
    <div class="panel panel-default">

        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <th>##</th>
                    <th>Name</th>
                    <th>Current stock</th>
                    <th>B.Price</th>
                    <th>S.Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in cartItems" :key="item.id">
                        <td>
                            <svg @click="removeFromCart(item)" class="icon-sm green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                        </td>
                        <td>{{ cartItems[index].name }}</td>
                        <td>{{ cartItems[index].qtty}}</td>
                        <td>
                            <div class="col-xs-10 form-group" :class="{'has-error': errors['items.' + index + '.buying_price']}">
                                <input type="text" :id="'item-' + item.id + '-bp'" class="form-control" v-model="cartItems[index].buying_price">

                                <span class="help-block" v-if="errors['items.' + index + '.buying_price']">
                                    <strong>{{ errors['items.' + index + '.buying_price'][0] }}</strong>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="col-xs-10 form-group" :class="{'has-error': errors['items.' + index + '.selling_price']}">
                                <input type="text" :id="'item-' + item.id + '-sp'" class="form-control" v-model="cartItems[index].selling_price">

                                <span class="help-block" v-if="errors['items.' + index + '.selling_price']">
                                    <strong>{{ errors['items.' + index + '.selling_price'][0] }}</strong>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="col-xs-10 form-group" :class="{'has-error': errors['items.' + index + '.qtty_purchased']}">
                                <input type="text" :id="'item-' + item.id + '-sp'" class="form-control" v-model="cartItems[index].qtty_purchased">

                                <span class="help-block" v-if="errors['items.' + index + '.qtty_purchased']">
                                    <strong>{{ errors['items.' + index + '.qtty_purchased'][0] }}</strong>
                                </span>
                            </div>
                        </td>
                        <td class="total" v-html="itemTotal(item)"></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>

<script>
    import eventHub from '../../events.js'

    export default {
        data () {
            return {
                cartItems: [],
                errors: []
            };
        },

        methods: {
            columns () {
                return ['name', 'id', 'selling_price', 'buying_price', 'qtty']
            },

            addToCart (item) {
                let data = _.pick(item, this.columns())
                data['qtty_purchased'] = 1
                var index = _.findIndex(this.cartItems, {'id': data.id})

                if (index == -1) {
                    this.cartItems.push(data)
                }
            },

            removeFromCart (item) {
                var index = this.cartItems.indexOf(item)
                this.cartItems.splice(index, 1)
                this.errors['item.' + index + 'selling_price'] = null
                this.errors['item.' + index + 'qtty_sold'] = null

                eventHub.$emit('purchases.item-removed-from-cart', item)
            },

            itemTotal (item) {
                let total = parseFloat(item.buying_price * item.qtty_purchased).toFixed(2)

                eventHub.$emit('purchases.compute-item-total', item)

                return total
            }

        },

        computed: {
            //
        },

        mounted () {
            eventHub.$on('purchases.add-to-cart', ((item) => {
                this.addToCart(item)
            }))

            eventHub.$on('purchase-completed', (() => {
                this.errors = []

                for (let i=0; i <= this.cartItems.length; i++) {
                    this.removeFromCart(this.cartItems[i])
                }
            }))

            eventHub.$on('errors-in-cart', ((error) => {
                this.errors = error.response.data.errors
            }))
        }
    }
</script>


<style scoped>
.green {
    fill: rgb(16, 148, 104);
    cursor: pointer;
}

.total {
    font-weight: bold;
    font-size: 14px;
}

</style>