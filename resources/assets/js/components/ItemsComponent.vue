<template>
<div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="searchText">
            </div>

            <button class="btn btn-primary pull-right">
                Excel Import
            </button>

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
            <table class="table table-condensed" v-if="response.items.length">
                <thead>
                    <tr>
                        <th></th>
                        <th v-for="column in response.displayColumns" :key="column">
                            {{ response.customColumns[column] || column }}
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredItems" :key="item.id">
                        <td>{{ index + 1 }}</td>
                        <td v-for="column in response.displayColumns" :key="column">
                            <span v-if="column === 'category_id' && item.category">
                                {{ item.category.name || '-'}}
                            </span>
                            <span v-else>
                                {{ item[column] || '-' }}
                            </span>
                        </td>
                        <td>
                            <a class="mr-4" href="#" @click.prevent="edit(item)">Edit</a>
                            <a class="mr-4" :href="'inventory#item-' + item.id" >Inventory</a>
                            <a href="#" @click.prevent="destroy(item.id)">Delete</a>
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
                    this.response = response.data;
                    console.log(this.response);
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
