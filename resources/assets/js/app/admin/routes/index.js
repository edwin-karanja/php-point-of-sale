import { Dashboard, SingleResource, EditResource } from "../pages";

export default [
    {
        path: '/',
        name: 'collection',
        component: Dashboard
    },
    {
        path: '/:resource/:id',
        name: 'single-resource',
        component: SingleResource,
        props: true
    },
    {
        path: '/:resource/:id/edit',
        name: 'edit-resource',
        component: EditResource,
        props: true
    }
];