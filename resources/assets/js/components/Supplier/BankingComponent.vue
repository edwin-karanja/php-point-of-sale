<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Banking - Info</b>

            <a href="#" class="pull-right" @click.prevent="openCreateBankings">
                <i class="fa fa-plus"></i>
                <b>Add</b>
            </a>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>##</th>
                        <th v-for="column in response.columns" :key="column">{{ response.customColumns[column] }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(meta, index) in response.bankings" :key="meta.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ meta.bank_name }}</td>
                        <td>{{ meta.bank_account_number }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="bankingsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
    export default {
        props: ['supplier'],

        data () {
            return {
                title: 'Create banking details.',
                buttonText: 'Save',
                bankingsModal: null,
                creating: {
                    active: false,
                    form: {},
                    errors: []
                },
                response: {
                    bankings: [],
                    columns: [],
                    customColumns: []
                }
            };
        },

        methods: {
            getSupplierBankings () {
                return axios.get('/suppliers/ajax/' + this.supplier.id + '/bankings').then((response) => {
                    this.response = response.data
                })
            },

            resetForm () {
                this.creating.active = false
                this.creating.form = {}
                this.creating.errors = []
            },

            store () {
                this.creating.active = true

                axios.post('/suppliers/ajax/' + this.supplier.id + '/bankings', this.creating.form).then(() => {
                    this.getSupplierBankings()

                    this.closeModal()
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.active = false
                        this.creating.errors = error.response.data.errors
                    }
                })

            },

            openCreateBankings () {
                this.bankingsModal.modal('show')
            },

            closeModal () {
                this.bankingsModal.modal('hide')

                this.resetForm()
            }
        },

        mounted() {
            this.getSupplierBankings()

            this.bankingsModal = $('#bankingsModal')
        }
    }
</script>
