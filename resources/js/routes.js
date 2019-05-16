import Home from './components/Home.vue';
import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import BooksMain from './components/Books/Main.vue';
import BooksList from './components/Books/List.vue';
import NewBook from './components/Books/New.vue';
import Book from './components/Books/View.vue';

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
        component: BooksMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: BooksList
            },
            {
                path: 'new',
                component: NewBook
            },
            {
                path: ':id',
                component: Book
            }
        ]
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
