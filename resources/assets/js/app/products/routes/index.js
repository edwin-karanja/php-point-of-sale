import { Products, SingleProduct, EditProduct } from "../pages";

export default [
    {
        path: '/products',
        name: 'products',
        component: Products
    },
    {
        path: '/products/:id',
        name: 'view-product',
        component: SingleProduct,
        props: true
    },
    {
        path: '/products/:id/edit',
        name: 'edit-product',
        component: EditProduct,
        props: true
    }
];