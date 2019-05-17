import Home from './components/Home.vue';
import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import BooksMain from './components/Books/Main.vue';
import BooksList from './components/Books/List.vue';
import NewBook from './components/Books/New.vue';
import Book from './components/Books/View.vue';
import EditBook from './components/Books/Update.vue';
import BookReview from './components/Books/Review.vue';

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
            },
            {
                path: ':id/edit',
                component: EditBook
            },
            {
                path: ':id/review',
                component: BookReview
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
