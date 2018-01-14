<template>
    <nav aria-label="Page navigation" v-if="pagination.total > pagination.data.length">
        <ul class="pagination">
            <li>
                <a href="#" @click.prevent="changePage(pagination.current_page - 1)" aria-label="Previous" v-if="pagination.current_page > 1">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li v-for="page in pageNumbers" :key="page" :class="{'active': page == pagination.current_page}">
                <a href="#" @click.prevent="changePage(page)">{{ page }}</a>
            </li>

            <li>
                <a href="#" @click.prevent="changePage(pagination.current_page + 1)" aria-label="Next" v-if="pagination.current_page < pagination.last_page">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    import eventHub from '../../events.js'

    export default {
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            },
            for: {
                type: String,
                default: 'default'
            }
        },

        methods: {
            changePage (page) {
                this.pagination.current_page = page
                eventHub.$emit(this.for + '.switched-page', page)
            }
        },

        computed: {
            pageNumbers() {
                if (!this.pagination.to) {
                    return [];
                }

                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                let pagesArray = [];
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }

                return pagesArray;
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
