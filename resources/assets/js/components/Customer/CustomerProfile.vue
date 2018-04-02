<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped">
                            <thead>
                            <tr>
                                <th>Column</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ customer.name }}</td>
                            </tr>
                            <tr>
                                <th>Telephone</th>
                                <td>{{ customer.telephone }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ customer.email }}</td>
                            </tr>
                            <tr>
                                <th>Comments</th>
                                <td>{{ customer.comments }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <customer-contacts
                            :customer="this.customer"
                    >
                    </customer-contacts>
                </div>

                <div class="col-md-2">
                    <div class="thumbnail">
                        <img :src="imageLink" class="img-rounded" alt="customer image" width="150" height="150">
                        <div class="caption">
                            <p>Customer image.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import CustomerContacts from '../Customer/CustomerContacts.vue';

    export default {
        props: ['customer'],

        components: {
            CustomerContacts
        },

        data () {
            return {
                imageLink: null
            }
        },

        mounted () {
            this.imageLink = this.customer.picture
        }
    }
</script>
