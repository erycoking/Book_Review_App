import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        books: []
    },
    getters: {
        isLoading(state){
            return state.loading;
        },
        isLoggedIn(state){
            return state.isLoggedIn;
        },
        currentUser(state){
            return state.currentUser;
        },
        authError(state){
            return state.auth_error;
        },
        books(state){
            return state.books;
        }
    },
    mutations: {
        login(state){
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload){
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem('user', JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload){
            state.loading = false;
            state.isLoggedIn = false,
            state.auth_error = payload.error;
        },
        logout(state){
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        updateBooks(state, payload){
            state.books = payload;
        }
    },
    actions: {
        login(context){
            context.commit('login');
        },
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
