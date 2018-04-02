<template>
    <div>
        <button class="ui button secondary right floated" @click.prevent="addCustomer" :class="{'disabled': disabled}">
            <i class="fa fa-plus"></i>
            Add Customer
        </button>

        <!-- Modal -->
        <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                        <textarea v-if="column == 'comments'" v-model="creating.form[column]"  :id="column" class="form-control" rows="5"></textarea>

                                        <input v-else :autofocus="column == 'name'" :id="column" type="text" class="form-control" v-model="creating.form[column]" value="">

                                        <span class="help-block" v-if="creating.errors[column]">
                                            <strong>{{ creating.errors[column][0] }}</strong>
                                        </span>
                                    </div>
                                </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
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

<script type="text/babel">
    import eventHub from '../../events.js'

    export default {
        props: ['customColumns', 'createColumns', 'disabled'],

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
            addCustomer () {
                this.editing.id = null;
                this.title = 'Add new Customer';
                this.buttonText = 'Add Customer';
                this.creating.form = {};
                this.creating.errors = [];
                $('#customerModal').modal('show');
                document.getElementById('name').focus()
            },

            closeModal () {
                $('#customerModal').modal('hide')
            },

            store () {
                this.creating.active = true

                if (this.editing.id) {
                    this.update();
                    return;
                }

                axios.post('/ajax/customers', this.creating.form).then((response) => {
                    if (response.status == 200) {
                        this.creating.active = false
                        this.closeModal()

                        eventHub.$emit('customer-created')
                        eventHub.$emit('success-alert', "New customer added.")
                    }


                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false
                        this.creating.errors = error.response.data.errors
                    }
                })
            },

            update () {
                let id = this.editing.id;
                axios.patch('/ajax/customers/' + id, this.creating.form).then((response) => {
                    if (response.status == 200) {
                        this.creating.active = false
                        this.editing.id = null
                        this.closeModal()

                        eventHub.$emit('customer-created')
                        eventHub.$emit('success-alert', "Customer updated.")
                    }


                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false
                        this.creating.errors = error.response.data.errors
                    }
                })
            },

            editCustomer (customer) {
                this.title = 'Editing: <strong> ' + customer.name + ' </strong>';
                this.buttonText = 'Update Customer';
                this.creating.form = {};
                this.creating.errors = [];
                this.editing.id = customer.id;

                this.creating.form = _.pick(customer, this.createColumns);
                $('#customerModal').modal('show');
            }
        },

        mounted() {
            eventHub.$on('editing-customer', this.editCustomer);
        }
    }
</script>


<style scoped>
    .hand {
        cursor: pointer
    }
</style>