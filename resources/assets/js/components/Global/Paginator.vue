<template>
    <nav aria-label="Page navigation" :class="{'pull-right': position === 'right'}">
        <ul class="pagination">
            <li :class="{'disabled': meta.current_page === 1 }">
                <a href="#" @click.prevent="switchPage(meta.current_page - 1)">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li :class="{'active': meta.current_page === x}" v-for="x in meta.last_page" v-if="x - meta.current_page <= 4 && x - meta.current_page > -4 || x === 1 || x === 2 || x === meta.last_page || x === (meta.last_page-1)">
                <a href="#" @click.prevent="switchPage(x)">{{ x }}</a>
            </li>
            <li :class="{'disabled': meta.current_page === meta.last_page }">
                <a href="#" aria-label="Next" @click.prevent="switchPage(meta.current_page + 1)">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script type="text/babel">
    export default {
        props: {
            meta: {},

            // Set the position of the nav links
            position: {
                default: 'left'
            }
        },

        data () {
            return {
                pagesShown: 5
            };
        },

        methods: {
            switchPage (page) {
                if (this.pageIsOutOfBounds(page)) {
                    return;
                }
                this.$emit('pagination:switched', page);
            },

            pageIsOutOfBounds (page) {
                return page <= 0 || page > this.meta.last_page;
            }
        }
    }
</script>
