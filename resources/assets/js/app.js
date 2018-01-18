
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('items-component', require('./components/ItemsComponent.vue'));
Vue.component('add-item-component', require('./components/AddItemComponent.vue'));
Vue.component('alert-component', require('./components/AlertComponent.vue'));
Vue.component('adjust-qtty-component', require('./components/AdjustItemQuantityComponent.vue'));
Vue.component('inventory-items-component', require('./components/InventoryItemsComponent.vue'));
Vue.component('inventory-history-component', require('./components/InventoryHistoryComponent.vue'));
Vue.component('customers-component', require('./components/CustomersComponent.vue'));
Vue.component('add-customer-component', require('./components/AddCustomerComponent.vue'));
/**
 * Sales Components
 */
Vue.component('sales-component', require('./components/Sales/SalesComponent.vue'));
Vue.component('cart-component', require('./components/Sales/CartComponent.vue'));
Vue.component('totals-component', require('./components/Sales/TotalsComponent.vue'));

/**
 * Purchases Components
 */
Vue.component('purchases-component', require('./components/Purchases/PurchasesComponent.vue'));
Vue.component('purchases-cart-component', require('./components/Purchases/CartComponent.vue'));
Vue.component('purchases-totals-component', require('./components/Purchases/TotalsComponent.vue'));

/**
 * Suppliers Components
 */
// Vue.component('suppliers-component', require('./components/Supplier/SuppliersComponent.vue'));

/**
 * Helpers
 */
Vue.component('paginate-component', require('./components/Helpers/PaginateComponent.vue'));

const app = new Vue({
    el: '#app'
});
