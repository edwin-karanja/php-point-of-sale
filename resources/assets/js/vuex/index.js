import Vue from 'vue';
import Vuex from 'vuex';
import admin from '../app/admin/vuex';
import products from '../app/products/vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        admin: admin,
        products: products
    }
})