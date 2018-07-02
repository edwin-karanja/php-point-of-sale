
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate, {
    errorBagName: 'vErrors'
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('items-component', require('./components/ItemsComponent.vue'));
Vue.component('alert-component', require('./components/AlertComponent.vue'));
Vue.component('adjust-qtty-component', require('./components/AdjustItemQuantityComponent.vue'));
Vue.component('inventory-items-component', require('./components/InventoryItemsComponent.vue'));
Vue.component('inventory-history-component', require('./components/InventoryHistoryComponent.vue'));
Vue.component('item-suppliers-list', require('./components/Items/SuppliersList.vue'));
Vue.component('typeahead-suppliers', require('./components/Items/SuppliersTypeahead.vue'));

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
Vue.component('suppliers-component', require('./components/Supplier/SuppliersComponent.vue'));
Vue.component('create-supplier-component', require('./components/Supplier/CreateSupplierComponent.vue'));
Vue.component('supplier-contacts', require('./components/Supplier/SupplierContacts.vue'));
Vue.component('item-suppliers', require('./components/Supplier/AddSupplierToItem.vue'));

/**
 * Helpers
 */
Vue.component('paginate-component', require('./components/Helpers/PaginateComponent.vue'));
// Vue.component('excel-upload-component', require('./components/Helpers/UploadExcelComponent.vue'));
Vue.component('page-refresh-component', require('./components/Helpers/PageRefreshComponent.vue'));
Vue.component('ellipsis-nav', require('./components/Helpers/EllipsisNavComponent.vue'));
Vue.component('date-range-picker', require('./components/Helpers/DateRangePicker.vue'));
Vue.component('datatables', require('./components/Helpers/DataTableComponent.vue'));


/**
 * Customer components
 */
Vue.component('customers-component', require('./components/Customer/CustomersComponent.vue'));
Vue.component('customer-account-receipts-component', require('./components/Customer/AccountReceiptsComponent.vue'));
Vue.component('customer-account-overview-component', require('./components/Customer/AccountOverviewComponent.vue'));
// Vue.component('customer-monthly-sales', require('./components/Customer/CustomerMonthlySales.vue'));
Vue.component('customer-profile', require('./components/Customer/CustomerProfile.vue'));


const app = new Vue({

    el: '#app',
    data: {},
    created: function () {
        var eventHub = require('./events.js')

        window.addEventListener('keyup', function(event) {
            eventHub.$emit('key-pressed', event)

            // If down arrow was pressed....
            if (event.keyCode == 40) {

            }
        });
    }
});
