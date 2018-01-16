<template>
    <div class="alert alert-flash"
        v-if="this.alert"
        :class="alertClass"
    >
        <!-- <a href="#" class="close" @click.prevent="close" aria-label="close">&times;</a> -->
        <strong v-html="messageNotice"></strong> <span>{{ message }}</span>
  </div>
</template>

<script>
    import eventHub from '../events.js'

    export default {
        data () {
            return {
                alert: false,
                type: 'success',
                message: '',
            }
        },

        computed: {
            alertClass () {
                if (this.type == 'success') {
                    return 'alert-success'
                }  else if (this.type == 'error') {
                    return 'alert-danger'
                }
            },

            messageNotice () {
                if (this.type == 'success') {
                    return '<i class="fa fa-check" aria-hidden="true"></i>' + ' Success!'
                }  else if (this.type == 'error') {
                    return '<i class="fa fa-times" aria-hidden="true"></i>' + ' Error!'
                }
            }
        },

        methods: {
            close () {
                this.alert = false
            },

            show () {
                this.alert = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.alert = false;
                }, 6000);
            },

            showError(message) {
                this.message = message
                this.type = 'error'
                this.show()
            },

            showSuccess(message) {
                this.message = message
                this.type = 'success'
                this.show()
            }
        },

        mounted () {
            eventHub.$on('success-alert', this.showSuccess)
            eventHub.$on('error-alert', this.showError)
        }
    }
</script>

<style scoped>
    .alert-flash {
        position: absolute;
        left: 25px;
        bottom: 25px;
        width: 400px;
        z-index: 99;
    }
</style>