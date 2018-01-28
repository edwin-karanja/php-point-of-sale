<template>
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="input-group">
                <span class="input-group-addon primary">
                    <i class="fa fa-search"></i>
                    Search Item
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
                <span class="input-group-addon primary" id="basic-addon2">
                    <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M4.06 13a8 8 0 0 0 5.18 6.51A18.5 18.5 0 0 1 8.02 13H4.06zm0-2h3.96a18.5 18.5 0 0 1 1.22-6.51A8 8 0 0 0 4.06 11zm15.88 0a8 8 0 0 0-5.18-6.51A18.5 18.5 0 0 1 15.98 11h3.96zm0 2h-3.96a18.5 18.5 0 0 1-1.22 6.51A8 8 0 0 0 19.94 13zm-9.92 0c.16 3.95 1.23 7 1.98 7s1.82-3.05 1.98-7h-3.96zm0-2h3.96c-.16-3.95-1.23-7-1.98-7s-1.82 3.05-1.98 7zM12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"/></svg>
                    Purchases
                </span>
            </div>

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
                selectedIndex: 0,
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
                eventHub.$emit('purchases.add-to-cart', item)
                this.searchText = ''
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

        mounted() {
            this.getItems()
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