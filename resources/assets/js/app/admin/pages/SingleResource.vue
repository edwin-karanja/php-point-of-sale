<template>
    <div class="">
        <h3>Single Resource Page</h3>
        <hr>

        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span>data</span>

                    <router-link class="btn btn-default pull-right" :to="{ name: 'collection' }">
                        <i class="glyphicon glyphicon-chevron-left"></i> Back
                    </router-link>

                    <router-link class="btn btn-primary pull-right" :to="{ name: 'edit-resource', params: { resource: resource, id: id } }" style="margin-right: 10px;">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </router-link>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ this.resource.toString().toUpperCase() }}
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr v-for="key in Object.keys(NonObjects)"><th>{{ key }}</th><td>{{ record[key] }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default" v-for="key in Object.keys(typeObjects)">
                <div class="panel-heading">
                    {{ key.toString().toUpperCase() }}
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr v-for="k in Object.keys(record[key])"><th>{{ k }}</th><td>{{ record[key][k] }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default" v-for="key in Object.keys(typeArrays)">
                <div class="panel-heading">
                    {{ key.toString().toUpperCase() }}
                </div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <!--<th v-for="col in Object.keys(typeArrays[key][0][0])">{{ col }}</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in typeArrays[key][0]">
                            <td v-for="col in Object.keys(row)">{{ row[col] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AppButton from '../../../components/Global/AppButton';

    export default {
        props: ['id', 'resource'],

        components: {
            AppButton
        },

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

        computed: {
            NonObjects () {
                let data = this.record, dt = {};

                Object.keys(data).some((key) => {
                    if (!_.isObject(data[key])) {
                        dt[key] = data[key]
                    }
                });

                return dt
            },

            typeObjects () {
                let data = this.record, dt = {};

                Object.keys(data).some((key) => {
                    if (_.isObject(data[key]) && !_.isArray(data[key])) {
                        dt[key] = data[key]
                    }
                });

                return dt;
            },

            typeArrays () {
                let data = this.record, dt = {}

                Object.keys(data).some((key) => {
                    if (_.isArray(data[key])) {
                        dt[key] = []
                        dt[key].push(data[key])
                    }
                });

                return dt;
            }
        },

        mounted () {
            this.getRecord();
        },

        filters: {
            isObject: function (value) {
                if (!_.isObject(value)) {
                    console.log('not object')
                    return value
                }
            },
        }
    }
</script>