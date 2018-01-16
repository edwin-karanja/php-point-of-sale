<template>
    <div>
        <button class="btn btn-primary pull-right mr-4" @click.prevent="addItem">
            Add Item
        </button>

        <!-- Modal -->
        <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" v-html="title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" @submit.prevent="store">
                        <div class="row">
                                <div class="form-group" v-for="column in createColumns" :class="{'has-error' : creating.errors[column]}" :key="column">
                                    <label :for="column" class="col-md-4 control-label">{{ customColumns[column] || column }}</label>

                                    <div class="col-md-6">
                                        <div v-if="column == 'category_id'" class="input-group">
                                            <select :id="column" class="form-control col-md-8" v-model="creating.form[column]">
                                                <option v-for="(category, index) in categories" :value="category.id" :key="category.id">{{ index+1 }}. {{ category.name }}</option>
                                            </select>
                                            <span class="input-group-addon">
                                                <i class="fa fa-plus hand"></i>
                                            </span>
                                        </div>

                                        <input v-else :id="column" type="text" class="form-control" v-model="creating.form[column]" autofocus>

                                        <span class="help-block" v-if="creating.errors[column]">
                                            <strong>{{ creating.errors[column][0] }}</strong>
                                        </span>
                                    </div>
                                </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <span v-if="!creating.active">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </span>
                                    <span v-if="creating.active">
                                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                    </span>
                                    {{ buttonText }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click.prevent="closeModal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import eventHub from '../events.js'

    export default {
        props: ['customColumns', 'createColumns', 'categories'],

        data () {
            return {
                title: '',
                buttonText: '',
                creating: {
                    active: false,
                    form: {},
                    errors: []
                },
                editing: {
                    id: null
                }
            };
        },

        methods: {
            addItem () {
                this.editing.id = null;
                this.title = 'Add new Item';
                this.buttonText = 'Add Item';
                this.creating.form = {};
                this.creating.errors = [];
                $('#itemModal').modal('show');
            },

            closeModal () {
                this.creating.form = {}
                $('#itemModal').modal('hide')
            },

            store () {
                this.creating.active = true

                if (this.editing.id) {
                    this.update();
                    return;
                }

                axios.post('/ajax/items', this.creating.form).then(() => {
                    this.closeModal()

                    eventHub.$emit('item-created')

                    eventHub.$emit('success-alert', "New item added.")
                    this.creating.active = false

                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false
                        this.creating.errors = error.response.data.errors
                    }
                })
            },

            update () {
                let id = this.editing.id;
                axios.post('/ajax/items/' + id, this.creating.form).then(() => {
                    this.creating.active = false
                    this.editing.id = null
                    this.closeModal()

                    eventHub.$emit('item-created')

                    eventHub.$emit('success-alert', "Item updated.")

                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false
                        this.creating.errors = error.response.data.errors
                    }
                })
            },

            editItem (item) {
                this.title = 'Editing: <strong> ' + item.name + ' </strong>';
                this.buttonText = 'Update Item';
                this.creating.form = {};
                this.creating.errors = [];
                this.editing.id = item.id;

                this.creating.form = _.pick(item, this.createColumns);
                $('#itemModal').modal('show');
            }
        },

        mounted() {
            eventHub.$on('editing-item', this.editItem);
        }
    }
</script>


<style scoped>
    .hand {
        cursor: pointer
    }
</style>