<template>
    <div>
        <button class="ui button secondary pull-right mr-4" @click.prevent="createSupplier" :class="{'disabled': disabled}">
            <i class="fa fa-plus"></i>
            Create Supplier
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createSupplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" v-html="title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" @submit.prevent="store" @keyup.esc="closeModal">
                        <div class="row">
                                <div class="form-group" v-for="column in createColumns" :class="{'has-error' : creating.errors[column]}" :key="column">
                                    <label :for="column" class="col-md-4 control-label">{{ customColumns[column] || column }}</label>

                                    <div class="col-md-6">
                                        <textarea v-if="column == 'description'" :id="column" cols="30" rows="5" class="form-control" v-model="creating.form[column]"></textarea>

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
                    <button type="button" class="ui button" @click.prevent="closeModal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventHub from '../../events.js';

    export default {
        props: ['customColumns', 'createColumns', 'disabled'],

        data () {
            return {
                supplierModal: null,
                title: '<b>Create a suplier</b>',
                creating: {
                    active: false,
                    form: {},
                    errors: []
                },
                buttonText: 'Create Supplier'
            };
        },

        methods: {
            createSupplier () {
                this.supplierModal.modal('show');
            },

            closeModal () {
                this.supplierModal.modal('hide')

                this.resetForm()
            },

            resetForm () {
                this.creating.form = {}
                this.creating.errors = []
            },

            store () {
                this.creating.active = true

                axios.post('/suppliers/ajax', this.creating.form).then(() => {
                    this.closeModal()

                    this.creating.active = false;

                    EventHub.$emit('supplier-created')
                    eventHub.$emit('success-alert', "Supplier added successfully.")

                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false
                        this.creating.errors = error.response.data.errors
                    }
                })
            }
        },

        mounted() {
            this.supplierModal = $('#createSupplierModal')

            EventHub.$on('create-supplier', this.createSupplier)
        }
    }
</script>
