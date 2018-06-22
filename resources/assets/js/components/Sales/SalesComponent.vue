<template>
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="input-group">
                <!-- <span class="input-group-addon primary">
                    <i class="fa fa-search"></i>
                    <b>Search Product</b>
                </span> -->
                <span class="input-group-addon success" id="basic-addon2">
                    <i class="fa fa-shopping-cart"></i>
                    <b>Sales</b>
                </span>
                <input type="text" id="search" class="form-control"
                            @keyup.up="moveUp"
                            @keyup.down="moveDown"
                            @keyup.esc="clearSearch"
                            @keyup.enter="addToCart(filteredItems[selectedIndex])"
                            v-model="searchText"
                            autocomplete="off"
                            placeholder="Enter item name or scan bar code"
                >
                <span class="input-group-addon success" id="basic-addon2">
                    <i class="fa fa-shopping-cart"></i>
                    <b>Sales</b>
                </span>
            </div>


            <!-- <ellipsis-nav class="pull-right"></ellipsis-nav> -->


            <table class="table dropdown-content" v-if="filteredItems.length">
                <tbody>
                    <tr v-for="(item, index) in filteredItems" :key="item.id">
                        <td :class="{'active2': selectedItem(item)}">
                            <span>{{ index + 1 }}: {{ item.name }}</span>
                            <button class="btn btn-success pull-right btn-sm" @click="addToCart(item)"><i class="fa fa-share"></i></button>
                            <span class="center-block">
                                <b>Qtty:</b>
                                <span class="badge">{{ item.qtty || 0 }}</span>
                            </span>
                        </td>
                    </tr>
                </tbody>

            </table>
            <div class="well well-sm dropdown-content" v-if="this.searchText && filteredItems.length == 0">
                No products found
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
                selectedIndex: 0,
                sort: {
                    key: 'updated_at',
                    order: 'desc'
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
                this.searchText = null
                document.getElementById('search').focus()
            },

            clearSearch () {
                this.searchText = null
            },

            selectedItem (item) {
                return this.filteredItems.indexOf(item) == this.selectedIndex
            },

            moveDown () {
                if (this.selectedIndex == (this.filteredItems.length - 1)) {
                    return
                }

                this.selectedIndex += 1
            },

            moveUp () {
                if (this.selectedIndex == 0) {
                    return
                }

                this.selectedIndex -= 1
            }
        },

        computed: {
            filteredItems () {
                this.selectedIndex = 0

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
        background-color: #cec5c5;
    }
</style>
