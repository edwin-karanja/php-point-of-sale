import { Dashboard } from '../components';

export default [
    {
        path:'/dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: {
            guest: false,
            needsAuth: true
        }
    }
]