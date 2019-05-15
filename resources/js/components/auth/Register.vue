<template>
    <div class="register row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header">Sign Up</div>
                <div class="card-body mr-5 ml-5">
                    <form @submit.prevent="register">
                        <p class="bg-danger pt-2 pb-2 pl-2 pr-2" v-if="errors.length">
                          <b>Please correct the following error(s):</b>
                          <ul>
                            <li v-for="error in errors">{{ error }}</li>
                          </ul>
                        </p>
                        <div class="form-group row">
                          <label for="email">Email: </label>
                          <input type="text" v-model="form.name" id="name" class="form-control" placeholder="Enter name" aria-describedby="nameId">
                          <small id="nameId" class="text-muted">Enter your name</small>
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
                          <label for="cpassword">Confirm Password: </label>
                          <input type="password" v-model="form.cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" aria-describedby="cpasswordId">
                          <small id="cpasswordId" class="text-muted">Confirm your password</small>
                        </div>
                        <div class="form-group row">
                          <input type="submit" value="Sign Up" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { register } from '../../helpers/auth';

export default {
    name: 'register',
    data(){
        return {
            form: {
                name: '',
                email: '',
                password: '',
                cpassword: ''
            },
            errors: []
        }
    },
    methods: {
        checkForm(e) {
            if(this.$data.form.name && this.$data.form.email && this.$data.form.password && this.$data.form.cpassword)
                return true;

            this.$data.errors = [];

            if(!this.$data.form.name)
                this.$data.errors.push("Name required.");

            if(!this.$data.form.email)
                this.$data.errors.push("Email required.");

            if(!this.$data.form.password)
                this.$data.errors.push("password required.");

            if(this.$data.form.password !== this.$data.form.cpassword)
                this.$data.errors.push("passwords do not match.");

        },
        register() {
            if (this.checkForm()) {
                this.$store.commit('login');

                register(this.$data.form)
                    .then((res) => {
                        this.$store.commit('loginSuccess', res);
                        this.$router.push('/')
                    }).
                    catch((error) => {
                        this.$store.commit('loginFailed', error);
                    });
            }
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
