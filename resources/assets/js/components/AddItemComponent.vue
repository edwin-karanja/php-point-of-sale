<template>
    <div>
        <button class="btn btn-success pull-right mr-4" @click.prevent="addItem">
            <i class="fa fa-plus"></i>
            Add Item
        </button>

        <!-- Modal -->
        <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" v-html="title"></h4>
                </div>
                <div class="modal-body">
                    <form id="add-item"  @submit.prevent="store">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" v-for="column in columnOneFields" :class="{'has-error' : creating.errors[column]}" :key="column">
                                    <span v-if="column === 'name'">
                                        <label :for="column" id="lbl" class="control-label">{{ customColumns[column] || column }}</label>

                                        <input :id="column" type="text" class="form-control" v-model="creating.form[column]" autofocus>
                                    </span>

                                    <span v-if="column === 'description'">
                                        <label :for="column" id="lbl" class="control-label">{{ customColumns[column] || column }}</label>

                                        <textarea class="form-control" :id="column" cols="10" rows="7" v-model="creating.form[column]"></textarea>
                                    </span>

                                    <span class="help-block" v-if="creating.errors[column]">
                                        <strong>{{ creating.errors[column][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" v-for="column in columnTwoFields" :class="{'has-error' : creating.errors[column]}" :key="column">
                                    <span v-if="column === 'buying_price'">
                                        <label :for="column" id="lbl" class="control-label">{{ customColumns[column] || column }}</label>

                                        <input :id="column" type="text" class="form-control" v-model="creating.form[column]" autofocus>
                                    </span>

                                    <span v-if="column === 'selling_price'">
                                        <label :for="column" id="lbl" class="control-label">{{ customColumns[column] || column }}</label>

                                        <input :id="column" type="text" class="form-control" v-model="creating.form[column]" autofocus>
                                    </span>

                                    <span v-if="column === 'qtty'">
                                        <label :for="column" id="lbl" class="control-label">{{ customColumns[column] || column }}</label>

                                        <input :id="column" type="text" class="form-control" v-model="creating.form[column]" autofocus>
                                    </span>

                                    <span v-if="column === 'category_id'">
                                        <label :for="column" id="lbl" class="control-label">{{ customColumns[column] || column }}</label>
                                        <div class="input-group">
                                            <select :id="column" class="form-control" v-model="creating.form[column]">
                                                <option v-for="(category, index) in categories" :value="category.id" :key="category.id">{{ index+1 }}. {{ category.name }}</option>
                                            </select>
                                            <span class="input-group-addon">
                                                <i class="fa fa-plus hand"></i>
                                            </span>
                                        </div>
                                    </span>

                                    <span class="help-block" v-if="creating.errors[column]">
                                        <strong>{{ creating.errors[column][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="ui button primary">
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
                    <button type="button" class="ui button" @click.prevent="closeModal">Close</button>
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

                axios.post('/ajax/items', this.creating.form).then((response) => {
                    this.closeModal()

                    eventHub.$emit('item-created');

                    eventHub.$emit('success-alert', "New item added.");
                    this.creating.active = false

                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false;
                        this.creating.errors = error.response.data.errors;
                    }
                })
            },

            update () {
                let id = this.editing.id;
                axios.post('/ajax/items/' + id, this.creating.form).then((response) => {
                    this.creating.active = false;
                    this.editing.id = null;
                    this.closeModal();

                    eventHub.$emit('item-created');

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

        computed: {
            columnOneFields () {
              return _.slice(this.createColumns, 0, 2);
            },

            columnTwoFields () {
                return _.slice(this.createColumns, 2);
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