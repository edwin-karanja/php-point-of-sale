<template>
    <div class="">
        <AppTable
                endpoint="/admin/items"
                resource="items"
                :records="products"
                :links="links"
                :meta="meta"
                :fields="fields"
                v-on:pagination:switched="getProducts"
                header="Products Listing"
                v-on:delete:record="destroy"
                v-on:search:records="filter"
                v-on:sort:records="sort"
                v-on:fetch:deleted="fetchDeleted"
                v-on:restore:record="restore"
                :shownFields="shownFields"
        ></AppTable>
    </div>
</template>

<script>
    import AppTable from '../../../components/Global/AppTable';

    import { mapGetters, mapActions } from 'vuex';

    export default {
        components: {
            AppTable
        },

        data () {
            return {
                shownFields: {
                    id: true,
                    name: true,
                    description: true
                }
            }
        },

        methods: {
            ...mapActions({
                getProducts: 'products/getProducts',
                searchProducts: 'products/searchProducts',
                sortProducts: 'products/sortProducts',
                deleteProduct: 'products/deleteProduct',
                fetchDeleted: 'products/showDeleted',
                restore: 'products/restoreProduct'
            }),

            destroy (product) {
                console.log('deleting..')
                this.deleteProduct(product.id);
            },

            filter (str) {
                this.searchProducts( str );
            },

            sort (sort) {
                this.sortProducts( sort );
            }
        },

        computed: {
            ...mapGetters({
                products: 'products/products',
                links: 'products/links',
                meta: 'products/meta',
                fields: 'products/fields',
                deleted: 'products/deleted'
            })
        },

        mounted () {
            if ( !this.products.length) {
                let query = this.$route.query
                let page = query.page || 1
                if (page === 1) {
                    this.$router.push('?page='+page)
                }

                this.getProducts(page)
            }
        }
    }
</script>