import Home from './components/Home.vue';
import Register from './components/auth/Register';
import Login from './components/auth/Login';
import Book from './components/Book.vue';

/**
 * defining all tha routes
 */
export const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/books',
        component: Book
    },
    {
        path: '/register',
        component: Register
    },
    {
        path: '/login',
        component: Login
    }
];
