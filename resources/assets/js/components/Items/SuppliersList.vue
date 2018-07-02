<template>
    <ul class="list-group" v-if="item_suppliers.length">
        <li class="list-group-item" v-for="supplier in item_suppliers" :key="supplier.id">
            {{ supplier.name }}

            <span class="pull-right hand">
                <i class="fa fa-star-o" :class="{ favorite : 'yellow' }" @click.prevent="makeFavorite"></i>
            </span>
        </li>
    </ul>
</template>

<script>
    import EventHub from '../../events';

    export default {
      props: {
        suppliers: {
          type: Array,
          required: true
        }
      },

      data () {
        return {
          item_suppliers: [],
        }
      },

      methods: {
        makeFavorite () {
            this.favorite = true;
        }
      },

      mounted () {
        this.item_suppliers = this.suppliers

        EventHub.$on('supplier:attached', (( supplier ) => {
          this.item_suppliers.push( supplier );
        }))
      }
    }
</script>

<style>
    .hand:hover {
        cursor: pointer;
    }

    .yellow {
        color: yellow;
    }
</style>