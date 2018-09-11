<template>
    <!-- Modal -->
    <div class="modal fade" :id="name" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" :ref="'vueModal'+name">
        <div class="modal-dialog" :class="[sizes[size]]" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click.prevent="closeModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ title || 'Modal Title'}}</h4>
                </div>
                <div class="modal-body">
                    <slot name="main"></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click.prevent="closeModal">Close</button>
                    <button type="button" v-if="deleting" class="btn btn-danger" @click="deleteRecord">
                        <i class="glyphicon glyphicon-trash"></i>
                        Delete
                    </button>
                    <button type="button" v-if="restoring" class="btn btn-success" @click="restoreRecord">
                        <i class="glyphicon glyphicon-refresh"></i>
                        Restore
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            size: {
                default: "normal",
                type: String,
                required: false
            },

            name: {
                type: String,
                required: true
            }
        },

        data () {
            return {
                sizes: {
                    small: 'modal-sm',
                    large: 'modal-lg',
                    normal: ''
                },
                modal: this.name,
                title: null,
                deleting: false,
                restoring: false,
                data: {}
            }
        },

        methods: {
            openModal () {
                $("#"+this.name).modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                });
            },

            closeModal () {
                this.deleting = false;
                this.restoring = false;
                this.title = null;
                $("#"+this.name).modal('hide');
            },

            deleteRecord () {
                this.$emit('delete:confirmed', this.data)

                this.closeModal()
            },

            restoreRecord () {
                this.$emit('restore:confirmed', this.data)

                this.closeModal()
            }
        },

        mounted () {
            this.$parent.$on(this.name+':open', ((row) => {
                this.data = row
                this.deleting = true
                this.title = 'Delete Product'
                this.openModal()
            }));

            this.$parent.$on(this.name+':restore', ((record) => {
                this.data = record
                this.restoring = true
                this.title = 'Restore Product'
                this.openModal();
            }));
        }
    }
</script>