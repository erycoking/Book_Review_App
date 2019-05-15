<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <div class="card mt-5">
                <div class="card-header">Login</div>
                <div class="card-body mr-5 ml-5">
                    <form @submit.prevent="authenticate">
                        <div class="form-group row" v-if="authError">
                          <p class="error">
                              {{ authError }}
                          </p>
                        </div>
                        <div class="form-group row">
                          <label for="email">Email: </label>
                          <input type="text" v-model="form.email" id="email" class="form-control" placeholder="Enter email" aria-describedby="emailId">
                          <small id="emailId" class="text-muted">Enter your email address</small>
                        </div>
                        <div class="form-group row">
                          <label for="password">Password: </label>
                          <input type="password" v-model="form.password" id="password" class="form-control" placeholder="Enter Password" aria-describedby="passwordId">
                          <small id="passwordId" class="text-muted">Enter your password</small>
                        </div>
                        <div class="form-group row">
                          <input type="submit" value="Login" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { login } from '../../helpers/auth';
import store from '../../store';

export default {
    name: 'login',
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            error: null
        };
    },
    methods: {
        authenticate(){
            this.$store.dispatch('login');

            login(this.$data.form)
                .then((res) => {
                    this.$store.commit('loginSuccess', res);
                    this.$router.push({path: '/'});
                })
                .catch((error) => {
                    this.$store.commit('loginFailed', {error});
                });
        }
    },
    computed: {
        authError(){
            return this.$store.getters.authError;
        }
    }
}
</script>


<style scoped>
.error {
    text-align: center;
    color: red;
}
</style>

