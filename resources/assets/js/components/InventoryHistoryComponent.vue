<template>
    <div>
        <div class="panel-default panel" v-if="loading">
            <div class="panel-body text-center" style="min-height: 300px">
                <div style="line-height: 300px">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div class="panel panel-default" v-if="item.name">
            <div class="panel-heading clearfix">
                <adjust-qtty-component :item="item"></adjust-qtty-component>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Item Name</th>
                            <td>{{ item.name }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>
                                <span class="label label-primary">
                                    {{ item.category ? item.category.name : 'null' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Current Quantity</th>
                            <td>
                                <span class="badge">
                                    {{ item.qtty || 0 }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="response.inventories.data.length">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>##</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>In/Out quantity</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="(inv, index) in response.inventories.data" :key="inv.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ inv.trans_date }}</td>
                                    <td>{{ inv.user.name }}</td>
                                    <td>
                                        {{ inv.trans_inventory }}

                                        <span v-if="inv.trans_inventory > 0" class="pull-right">
                                            <svg class="icon-sm green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M13 5.41V21a1 1 0 0 1-2 0V5.41l-5.3 5.3a1 1 0 1 1-1.4-1.42l7-7a1 1 0 0 1 1.4 0l7 7a1 1 0 1 1-1.4 1.42L13 5.4z"/></svg>
                                        </span>

                                        <span v-if="inv.trans_inventory < 0" class="pull-right">
                                            <svg class="icon-sm red" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M11 18.59V3a1 1 0 0 1 2 0v15.59l5.3-5.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-7-7a1 1 0 0 1 1.4-1.42l5.3 5.3z"/></svg>
                                        </span>
                                    </td>
                                    <td>{{ inv.comments }}</td>
                                </tr>
                        </tbody>
                    </table>

                    <paginate-component for="inventory" :pagination="response.inventories"></paginate-component>
                </div>

                <div class="well well-sm" v-if="!loading && response.inventories.data.length == 0 && item.name">
                    <b>That item has no stock movement, add item quantity to view its history.</b>
                </div>


            </div>
        </div>

        <div class="well well-sm" v-if="!loading && item.name === null">
            <b>Click on any item on the left to view its stock movement.</b>
        </div>
    </div>
</template>

<script type="text/babel">
import eventHub from '../events.js'

    export default {
        data () {
            return {
                loading: false,
                item: {
                    name: null,
                    qtty: null,
                    category: {}
                },
                response: {
                    inventories: {
                        data: []
                    }
                }
            };
        },

        methods: {
            getItemInventory (item, page = null) {
                this.loading = true

                if (page) {
                    return axios.get('/ajax/inventory/' + item.id + '?page=' + page).then((response) => {
                        this.response = response.data
                        this.loading = false
                    })
                }

                return axios.get('/ajax/inventory/' + item.id).then((response) => {
                    this.response = response.data
                    this.loading = false
                })
            }
        },

        mounted() {
            eventHub.$on('show-item-inventory', ((item) => {
                this.item = item
                this.getItemInventory(item)
            }))

            eventHub.$on('inventory.switched-page', ((page) => {
                this.getItemInventory(this.item, page)
            }))
        }
    }
</script>

<style scoped>
    .green {
        fill: rgba(13, 226, 77, 0.87);
    }

    .red {
        fill: red;
    }
</style>