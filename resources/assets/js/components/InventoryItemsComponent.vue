<template>
    <div class="panel panel-default">
        <div class="panel-heading clear-fix">
            <AppInput placeholder="Search Item name" v-model="searchText" />
        </div>

        <div class="panel-body table-view">
            <div class="panel-default panel" v-if="loading">
                <div class="panel-body text-center" style="min-height: 300px">
                    <div style="line-height: 300px">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span><b>Loading...</b></span>
                    </div>
                </div>
            </div>

            <table class="table table-responsive table-condensed table-bordered" v-if="response.items && !loading">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in filteredItems" :key="item.id" :class="{'active': item.id === selected.id}">
                        <td>
                            <a :id="'item-' + item.id" href="#" @click.prevent="showItemInventory(item)">{{ item.name }}</a>
                        </td>
                        <td>
                            <span class="badge">
                                {{ item.qtty || 0 }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="well well-sm">
                No items created yet.
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
import eventHub from '../events.js';
import Search from './Global/Search.vue';
import AppInput from './Global/AppInput';

    export default {
        components: {
            Search,
            AppInput
        },

        data () {
            return {
                loading: true,
                response: {
                    items: []
                },
                searchText: '',
                sort: {
                    key: 'updated_at',
                    order: 'desc'
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

                // location.hash = '#item-' + item.id
            },

            updateResults (text) {
                this.searchText = text;
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


<style scoped lang="scss">
    .table-view {
        max-height: 70vh;
        overflow: scroll;
    }
    tr:hover {
        background-color: #F5F8FC;
    }

    .table > thead > tr > th {
        font-size: 14px;
        font-weight: semibold;
        color: #4A4A4A;
        text-transform: uppercase;
        background-color: #F5F8FC;
    }

    .table > tbody > tr.active > td, .table > tbody > tr.active > th, .table > tfoot > tr > td.active, .table > tfoot > tr > th.active, .table > tfoot > tr.active > td, .table > tfoot > tr.active > th {
        background-color: #f5f5f5;
        font-weight: bold;
    }
</style>