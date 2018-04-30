import { Login, Register } from "../components";

export default [
    {
        path:'/login',
        component: Login,
        name: 'login',
        meta: {
            guest: true,
            needsAuth: false
        }
    },
    {
        path:'/register',
        component: Register,
        name: 'register',
        meta: {
            guest: true,
            needsAuth: false
        }
    }
]
