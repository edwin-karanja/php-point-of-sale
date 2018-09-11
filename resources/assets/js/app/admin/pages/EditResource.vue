<template>
    <div class="">
        <h3>Edit {{ resource }}</h3>
        <hr>

        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-body">

                    <router-link class="btn btn-default pull-right" :to="{ name: 'collection' }">
                        <i class="glyphicon glyphicon-chevron-left"></i> Back
                    </router-link>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['resource', 'id'],

        data () {
            return {
                record: {}
            };
        },

        methods: {
            getRecord () {
                axios.get('admin/'+this.resource+'/'+this.id).then((response) => {
                    this.record = response.data.data;
                })
            }
        },


    }
</script>