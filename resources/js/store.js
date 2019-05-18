import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

/**
 * defining application state
 */
export default {
    /**
     * application attibutes
     */
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        books: []
    },
    /**
     * defining getters
     */
    getters: {
        /**
         * getting the loading state
         * @param {state} state
         * @returns loading state
         */
        isLoading(state){
            return state.loading;
        },
        /**
         * getting the isLogged state
         * @param {state} state
         * @returns isLogged state
         */
        isLoggedIn(state){
            return state.isLoggedIn;
        },
        /**
         * getting the currentUser state
         * @param {state} state
         * @returns currentUser state
         */
        currentUser(state){
            return state.currentUser;
        },
        /**
         * getting the authError state
         * @param {state} state
         * @returns authError state
         */
        authError(state){
            return state.auth_error;
        },
        /**
         * getting the books state
         * @param {state} state
         * @returns books state
         */
        books(state){
            return state.books;
        }
    },
    mutations: {
        /**
         * redefining states for login
         * @param {state} state
         */
        login(state){
            state.loading = true;
            state.auth_error = null;
        },
        /**
         * redefining states for successfull login
         * @param {state} state
         * @param {server response} payload
         */
        loginSuccess(state, payload){
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem('user', JSON.stringify(state.currentUser));
        },
        /**
         * redefining states for unsuccessfull login
         * @param {state} state
         * @param {server response} payload
         */
        loginFailed(state, payload){
            state.loading = false;
            state.isLoggedIn = false,
            state.auth_error = payload.error;
        },
        /**
         * redefining states for unsuccessfull logout
         * @param {state} state
         */
        logout(state){
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        /**
         * redefining states for unsuccessfull login
         * @param {state} state
         * @param {server response} payload
         */
        updateBooks(state, payload){
            state.books = payload;
        }
    },
    actions: {
        /**
         * commiting login mutation
         * @param {context} context
         */
        login(context){
            context.commit('login');
        },
        /**
         * getting all the books from the db
         * @param {context} context
         */
        getBooks(context){
            axios.get('/api/books', {
                headers: {
                    "Authorization": `Bearer ${context.state.currentUser.token}`
                }
            })
            .then((res) => {
                context.commit('updateBooks', res.data.data);
            }).
            catch((err) => {
                console.log(err);
            });
        }
    }
}
