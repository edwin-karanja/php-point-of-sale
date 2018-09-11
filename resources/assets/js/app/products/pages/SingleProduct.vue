<template>
    <div class="">
        <h3>{{ activeProduct.name || '' | capitalize }}</h3>
        <hr>

        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span>data</span>

                    <AppButton class="pull-right" @click="$router.go(-1)">
                        <i class="glyphicon glyphicon-chevron-left"></i> Back
                    </AppButton>

                    <router-link class="btn btn-success pull-right" :to="{ name: 'products' }" style="margin-right: 10px;">
                        <i class="glyphicon glyphicon-tasks"></i> Products
                    </router-link>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Products

                    <AppButton class="btn btn-primary pull-right" size="small">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </AppButton>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr v-for="key in Object.keys(NonObjects)"><th>{{ key }}</th><td>{{ activeProduct[key] }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default" v-for="key in Object.keys(typeObjects)" v-if="activeProduct.category">
                <div class="panel-heading">
                    Category
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr v-for="k in Object.keys(activeProduct[key])"><th>{{ k }}</th><td>{{ activeProduct[key][k] }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default" v-if="productInventory.data && productInventory.data.length > 0">
                <div class="panel-heading">
                    Inventory
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>
                                <th>Comments</th>
                                <th>Change Value</th>
                                <th>Transaction Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in productInventory.data">
                                <td>{{ row.id }}</td>
                                <td>{{ row.user.name }}</td>
                                <td>{{ row.comments }}</td>
                                <td>
                                    {{ row.trans_inventory }}

                                    <span v-if="row.trans_inventory > 0" class="pull-right">
                                        <i class="glyphicon glyphicon-arrow-up green"></i>
                                    </span>

                                    <span v-if="row.trans_inventory < 0" class="pull-right">
                                        <i class="glyphicon glyphicon-arrow-down red"></i>
                                    </span>
                                </td>
                                <td>{{ row.trans_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <Paginator v-if="productInventory.meta.last_page > 1"
                               :meta="productInventory.meta"
                               v-on:pagination:switched="switchPage"
                               position="right"
                    ></Paginator>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AppButton from '../../../components/Global/AppButton';
    import Paginator from '../../../components/Global/Paginator';
    import { mapActions, mapGetters } from 'vuex';

    export default {
        props: ['id'],

        components: {
            AppButton,
            Paginator
        },

        methods: {
            ...mapActions({
                getProduct: 'products/getProductData',
                fetchInventory: 'products/fetchProductInventory'
            }),

            switchPage (page) {
                this.fetchInventory(page);
            }
        },

        computed: {
            ...mapGetters({
                activeProduct: 'products/activeProduct',
                productInventory: 'products/productInventory'
            }),

            NonObjects () {
                let data = this.activeProduct, dt = {};

                Object.keys(data).some((key) => {
                    if (!_.isObject(data[key])) {
                        dt[key] = data[key]
                    }
                });

                return dt
            },

            typeObjects () {
                let data = this.activeProduct, dt = {};

                Object.keys(data).some((key) => {
                    if (_.isObject(data[key]) && !_.isArray(data[key])) {
                        dt[key] = data[key]
                    }
                });

                return dt;
            }
        },

        mounted () {
            this.getProduct(this.id)
        },

        filters: {
            isObject: function (value) {
                if (!_.isObject(value)) {
                    console.log('not object')
                    return value
                }
            },

            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            },
        }
    }
</script>

<style>
    .green {
        color: green;
    }

    .red {
        color: red;
    }
</style>