<template>
<div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon primary">
                        <i class="fa fa-search"></i>
                    </span>

                    <input type="text" class="form-control" v-model="searchText">

                    <span class="input-group-addon primary">
                        <i class="fa fa-search"></i>
                    </span>
                </div>

            </div>

            <excel-upload-component :url="'/ajax/items/import'"></excel-upload-component>

            <add-item-component v-if="response.createColumns"
                 :customColumns="response.customColumns"
                 :createColumns="response.createColumns"
                 :categories="response.categories"
            >
            </add-item-component>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panel-default panel" v-if="loading">
                <div class="panel-body text-center" style="min-height: 300px">
                    <div style="line-height: 300px">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span><b>Loading...</b></span>
                    </div>
                </div>
            </div>

            <table class="table table-responsive" v-if="response.items.length && !loading">
                <thead>
                    <tr>
                        <th>##</th>
                        <th v-for="column in response.displayColumns" :key="column">
                            {{ response.customColumns[column] || column }}
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredItems" :key="item.id">
                        <td>{{ index + 1 }}</td>
                        <td v-for="column in response.displayColumns" :key="column">
                            <span v-if="column == 'name'">
                                {{ trimLength(item[column]) }}
                            </span>
                            <span v-else-if="column == 'qtty'" class="badge">
                                {{ item[column] || 0 }}
                            </span>
                            <span class="b" v-else-if="column == 'buying_price' || column == 'selling_price'">
                                {{ parseInt(item[column]).toLocaleString('en-US') }}
                            </span>
                            <span v-else>
                                {{ item[column] || '-' }}
                            </span>
                        </td>
                        <td width="12%">
                            <div class="to-hide">
                                <a class="mr-4" href="#" @click.prevent="edit(item)">
                                    <b>Edit</b>
                                </a>
                                |
                                <a class="mr-4" :href="'inventory#item-' + item.id" >
                                    <b>Stocks</b>
                                </a>
                                |
                                <a href="#" @click.prevent="destroy(item.id)">
                                    <i @click="removeFromCart(item)" class="fa fa-trash-o dark-grey"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else>
                No records here
            </p>
        </div>
    </div>
</div>


</template>

<script>
    import eventHub from '../events.js';

    export default {
        data () {
            return {
                loading: true,
                response: {
                    items: [],
                    columns: [],
                    createColumns: [],
                    customColumns: [],
                    categories: []
                },
                searchText: '',
                sort: {
                    key: 'id',
                    order: 'asc'
                }
            };
        },

        methods: {
            getItems () {
                axios.get('/ajax/items').then((response) => {
                    this.loading = false
                    this.response = response.data;
                })
            },

            edit (item) {
                eventHub.$emit('editing-item', item);
            },

            destroy (id) {
                if (!window.confirm('Are you sure you want to delete this record?')) {
                    return;
                }

                axios.delete('/ajax/items/' + id).then(() => {
                    this.getItems()

                    eventHub.$emit('success-alert', 'Item deleted.')
                })
            },

            trimLength (str, length = 40) {
                return  str.length > length ? str.substring(0, length - 3) + "..." : str.substring(0, length)
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
            this.getItems();

            eventHub.$on('item-created', (() => {
                this.getItems()
            }));
        }
    }
</script>

<style scoped lang="scss">
    tr:hover {
        background-color: #F5F8FC;
    }

    tr:hover > td > div.to-hide {
        display: inline;
    }

    .table > thead > tr > th {
        font-size: 14px;
        font-weight: semibold;
        color: #4A4A4A;
        text-transform: uppercase;
        background-color: #F5F8FC;
    }

    .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
        padding: 15px;
        line-height: 1.6;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    .to-hide {
        display: none;
        font-size: 14px;
    }
</style>