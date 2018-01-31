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

            <table class="table table-condensed table-striped table-responsive" v-if="response.items.length && !loading">
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
                            <span>
                                {{ item[column] || '-' }}
                            </span>
                        </td>
                        <td>
                            <a class="mr-4" href="#" @click.prevent="edit(item)">
                                <b>Edit</b>
                            </a>
                            <a class="mr-4" :href="'inventory#item-' + item.id" >
                                <b>Inventory</b>
                            </a>
                            <a href="#" @click.prevent="destroy(item.id)">
                                <svg @click="removeFromCart(item)" class="icon-sm green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                            </a>
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


<style scoped>
.green {
    fill: rgb(148, 18, 13);
    cursor: pointer;
}
</style>
