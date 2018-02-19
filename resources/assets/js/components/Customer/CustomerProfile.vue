<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-5">
                    <table class="table">
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
                <div class="col-md-5">
                    <customer-contacts :customer="this.customer"></customer-contacts>
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

<script>
    export default {
        props: ['customer'],

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
