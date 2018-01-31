<template>
    <div>
        <a href="#" class="pull-right hand" @click.prevent="makeAdjustment">
            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M19 6.41L8.7 16.71a1 1 0 1 1-1.4-1.42L17.58 5H14a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V6.41zM17 14a1 1 0 0 1 2 0v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7c0-1.1.9-2 2-2h5a1 1 0 0 1 0 2H5v12h12v-5z"/></svg>
            <b>Make adjustment</b>
        </a>

        <!-- Modal -->
        <div class="modal fade" id="inventoryAdjustModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="closeModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" v-html="title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" @submit.prevent="store">

                        <div class="form-group" >
                            <label for="" class="col-md-4 control-label">Item Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" :value="item.name" disabled>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label for="" class="col-md-4 control-label">Category</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" :value="item.category.name" disabled>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label for="" class="col-md-4 control-label">Current quantity</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" :value="item.qtty" disabled>
                            </div>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.adjustment}">
                            <label for="" class="col-md-4 control-label">+ve/-ve Adjustment</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" v-model="form.adjustment">

                                <span class="help-block" v-if="errors.adjustment">
                                    <strong>{{ errors.adjustment[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.comments}">
                            <label for="" class="col-md-4 control-label">Comments</label>

                            <div class="col-md-6">
                                <textarea name="comments" id="comments" class="form-control" rows="5" v-model="form.comments"></textarea>

                                <span class="help-block" v-if="errors.comments">
                                    <strong>{{ errors.comments[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-cog"></i>
                                    Adjust Inventory
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
        props: ['item'],

        data () {
            return {
                title: 'Make adjustment',
                form: {
                    adjustment: null,
                    comments: null,
                },
                errors: []
            };
        },

        methods: {
            store () {
                axios.post('/ajax/inventory/' + this.item.id + '/adjust', this.form).then(() => {
                    this.closeModal()

                    eventHub.$emit('quantity-adjustment', this.item.id);

                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                })
            },

            makeAdjustment () {
                $('#inventoryAdjustModal').modal('show')
                this.form = {}
            },

            closeModal () {
                $('#inventoryAdjustModal').modal('hide')
            }
        },

        mounted() {

        }
    }
</script>


<style scoped>
    .hand {
        cursor: pointer
    }
</style>