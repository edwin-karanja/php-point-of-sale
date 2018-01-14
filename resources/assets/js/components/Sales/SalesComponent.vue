<template>
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="input-group">
                <span class="input-group-addon">
                    Search Item
                </span>
                <input type="text" id="search" class="form-control" v-model="searchText" autocomplete="off" placeholder="Enter item name or scan bar code">
                <span class="input-group-addon" id="basic-addon2">
                    <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M17 16a3 3 0 1 1-2.83 2H9.83a3 3 0 1 1-5.62-.1A3 3 0 0 1 5 12V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v1h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H5a1 1 0 0 0 0 2h12zM7 12h9.38l3-6H7v6zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                    Sales
                </span>
            </div>

            <table class="table dropdown-content" v-if="filteredItems.length">
                <tbody>
                    <tr v-for="(item, index) in filteredItems" :key="item.id">
                        <td :class="{'active': filteredItems.indexOf(item) == 0}">
                            <span>{{ index + 1 }}: {{ item.name }}</span>
                            <button class="btn btn-default pull-right" @click="addToCart(item)"><i class="fa fa-share"></i></button>
                            <span>Quantity: {{ item.qtty }}</span>
                        </td>
                    </tr>
                </tbody>

            </table>
            <div class="well well-sm dropdown-content" v-if="this.searchText && filteredItems.length == 0">
                No results
            </div>
        </div>
    </div>
</template>

<script>
import eventHub from '../../events.js'

    export default {
        data () {
            return {
                searchText: null,
                items: [],
                item: {},
                sort: {
                    key: 'id',
                    order: 'asc'
                }
            };
        },

        methods: {
            getItems () {
                return axios.get('/ajax/items').then((response) => {
                    this.items = response.data.items
                })
            },

            addToCart (item) {
                eventHub.$emit('add-to-cart', item)
                this.searchText = ''
                document.getElementById('search').focus()

            }
        },

        computed: {
            filteredItems () {
                if (this.searchText) {
                    let data = this.items

                    data = data.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row.name).toLowerCase().indexOf(this.searchText.toLowerCase()) > -1
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

            }
        },

        mounted () {
            this.getItems()

            document.getElementById('search').focus()

            eventHub.$on('sale-completed', this.getItems)
        }
    }
</script>

<style scoped>
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

    .active2 {
        background-color: chocolate
    }
</style>
