<template>
    <div class="">
        <h3>Edit {{ resource }}</h3>
        <hr>

        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-body">

                    <AppButton class="pull-right" @click="$router.go(-1)">
                        <i class="glyphicon glyphicon-chevron-left"></i> Back
                    </AppButton>

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
    import AppButton from '../../../components/Global/AppButton';

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