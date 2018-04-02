<template>
    <div class="ui search" :class="[floated === 'right' ? 'pull-right' : 'pull-left']">
        <div class="ui tiny icon input">
            <input class="prompt" type="text" :size="size" :placeholder="'Search ' + title | capitalize" v-model="searchText" @keyup="searchModule">
            <i class="search icon"></i>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: {
            title: {
                type: String,
                default: 'Component'
            },

            size: {
                type: String,
                default: "25"
            },

            floated: {
                type: String,
                default: 'right'
            },

            search: {
                type: String,
                default: 'front'
            },

            endpoint: {
                type: String,
                default: ''
            }
        },

        data () {
            return {
                searchText: null,
            }
        },

        methods: {
            searchModule () {

                // Determine the type of search
                if (this.search === 'front') {
                    this.$emit('search:front', this.searchText);
                } else if (this.search === 'backend') {
                    this.$emit('search:backend', this.searchText);
                }
            }
        },

        filters: {
            capitalize: function (value) {
                if (!value) return '';

                value = value.toString();
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        },
    }
</script>