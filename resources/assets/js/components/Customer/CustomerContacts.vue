<template>
    <div class="panel panel-default">

        <div class="panel-heading">
            <b>Customer - Contacts</b>

            <a href="#" class="pull-right" @click.prevent="openModal">
                <i class="fa fa-plus"></i>
                <b>Add</b>
            </a>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>##</th>
                            <th v-for="column in response.columns" :key="column">{{ response.customColumns[column] }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(contact, index) in response.contacts" :key="contact.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ contact.contact_name }}</td>
                            <td>{{ contact.contact_email }}</td>
                            <td>{{ contact.contact_phone }}</td>
                            <td>
                                <a href="#" @click.prevent="edit(contact)">
                                    <b>Edit</b>
                                </a>
                                |
                                <a href="#" @click.prevent="destroy(contact.id)">
                                    <b>Delete</b>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="contactsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" v-html="title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" @submit.prevent="store">
                        <div class="row">
                                <div class="form-group" v-for="column in response.columns" :class="{'has-error' : creating.errors[column]}" :key="column">
                                    <label :for="column" class="col-md-4 control-label">{{ response.customColumns[column] || column }}</label>

                                    <div class="col-md-6">

                                        <input :id="column" type="text" class="form-control" v-model="creating.form[column]" value="">

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
                                        <i class="fa fa-save" aria-hidden="true"></i>
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
    export default {
        props: ['customer'],

        data () {
            return {
                title: 'Create customer contact.',
                buttonText: 'Save',
                contactsModal: null,
                creating: {
                    active: false,
                    form: {},
                    errors: []
                },
                response: {
                    contacts: [],
                    columns: [],
                    customColumns: []
                },
                editing: {
                    id: null
                }
            };
        },

        methods: {
            getCustomerContacts () {
                return axios.get('/customers/ajax/' + this.customer.id + '/contacts').then((response) => {
                    this.response = response.data
                })
            },

            resetForm () {
                this.creating.active = false;
                this.creating.form = {};
                this.creating.errors = [];
                this.editing.id = null;
            },

            store () {
                this.creating.active = true;

                if (this.editing.id) {
                    this.update();
                    return;
                }

                axios.post('/customers/ajax/' + this.customer.id + '/contacts', this.creating.form).then(() => {
                    this.getCustomerContacts();

                    this.closeModal();
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false;
                        this.creating.errors = error.response.data.errors;
                    }
                })

            },

            update () {
                axios.patch('/customers/ajax/' + this.customer.id + '/contacts/' + this.editing.id, this.creating.form).then(() => {
                    this.getCustomerContacts();

                    this.closeModal();
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false;
                        this.creating.errors = error.response.data.errors;
                    }
                })
            },

            edit (contact) {
                this.resetForm();

                this.title = 'Editing:- ' + contact.contact_name;
                this.buttonText = 'Update';
                this.editing.id = contact.id;
                this.creating.form = contact;

                this.openModal();
            },

            destroy (contactId) {
                if (!window.confirm('Are you sure you want to delete this contact?')) {
                    return;
                }

                axios.delete('/customers/ajax/' + this.customer.id + '/contacts/' + contactId).then(() => {
                    this.getCustomerContacts();
                })
            },

            openModal () {
                this.contactsModal.modal('show');
            },

            closeModal () {
                this.contactsModal.modal('hide');

                this.resetForm();
            }
        },

        filters: {
            capitalize: function (value) {
                if (!value) return '';

                value = value.toString();
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        },

        mounted() {
            this.getCustomerContacts()

            this.contactsModal = $('#contactsModal')
        }
    }
</script>
