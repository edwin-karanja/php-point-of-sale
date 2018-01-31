<template>
    <div class="panel panel-default">
        <div class="panel-heading clear-fix">
            <div class="input-group">
                <span class="input-group-addon primary">
                    <i class="fa fa-search"></i>
                </span>

                <input type="text" class="form-control" placeholder="Search by name or quantity." @keyup.esc="clearSearch" v-model="searchText">

                <span class="input-group-addon primary">
                    <i class="fa fa-search"></i>
                </span>
            </div>

        </div>

        <div class="panel-body">
            <div class="panel-default panel" v-if="loading">
                <div class="panel-body text-center" style="min-height: 300px">
                    <div style="line-height: 300px">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span><b>Loading...</b></span>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-responsive table-condensed" v-if="response.items && !loading">
                <thead>
                    <tr>
                        <th>##</th>
                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredItems" :key="item.id" :class="{'active': item.id === selected.id}">
                        <td>{{ index + 1 }}</td>
                        <td>
                            <a :id="'item-' + item.id" href="#" @click.prevent="showItemInventory(item)">{{ item.name }}</a>
                        </td>
                        <td>{{ item.qtty || '-' }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="well well-sm">
                No items created yet.
            </div>
        </div>
    </div>

</template>

<script>
import eventHub from '../events.js'

    export default {
        data () {
            return {
                loading: true,
                response: {
                    items: []
                },
                searchText: '',
                sort: {
                    key: 'id',
                    order: 'asc'
                },
                selected: {
                    id: null
                }
            };
        },

        methods: {
            getItems () {
                return axios.get('/ajax/inventory').then((response) => {
                    this.loading = false
                    this.response = response.data;
                })
            },

            showItemInventory (item) {
                this.selected = item
                eventHub.$emit('show-item-inventory', item)
            },

            clearSearch () {
                this.searchText = ''
            }
        },

        computed: {
            filteredItems () {
                let data = this.response.items

                data = data.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.searchText.toLowerCase()) > -1
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
        },

        mounted() {
            this.getItems().then(() => {
                let hash = location.hash;

                if (hash) {
                    // Remove the # symbol infront of the variable and get the element by id
                    var element = document.getElementById(hash.slice(1))
                    element.click()
                }
            })

            eventHub.$on('quantity-adjustment', ((id) => {
                this.getItems().then(() => {
                    let selectedItem = _.find(this.response.items, { 'id': id });

                    this.showItemInventory(selectedItem)
                })

            }))
        }
    }
</script>
