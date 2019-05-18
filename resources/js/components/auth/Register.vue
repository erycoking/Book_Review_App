<template>
    <div class="register row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header">Sign Up</div>
                <div class="card-body mr-5 ml-5">
                    <form @submit.prevent="register">
                        <div class="bg-danger pt-2 pb-2 pl-2 pr-2" v-if="errors">
                          <ul>
                              <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                                  <strong>{{ fieldName }} : </strong> {{ fieldsError.join('\n') }}
                              </li>
                          </ul>
                        </div>
                        <div class="form-group row">
                          <label for="name">Name: </label>
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
                          <label for="passport">Photo: </label>
                          <input type="file" accept="image/*"  id="passport" @change="onFileChange" class="form-control" aria-describedby="passportId">
                          <small id="passportId" class="text-muted">Upload passport photo</small>
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
import validate from 'validate.js';

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
            passport_img: null,
            errors: null
        }
    },
    methods: {
        onFileChange(){
            this.$data.passport_img = event.target.files[0];
        },
        register() {
            this.errors = null;
            const constraints = this.getConstraints();

            const errors = validate(this.$data.form, constraints);

            if(errors){
                this.errors = errors;
                return;
            }

            const formData = new FormData();
            Object.keys(this.$data.form).forEach((key, index) =>{
                formData.append(key, this.$data.form[key]);
            });

            if(this.$data.passport_img){
                formData.append('passport_img', this.$data.passport_img, this.$data.passport_img.name);
            }

            this.$store.commit('login');

            register(formData)
                .then((res) => {
                    this.$store.commit('loginSuccess', res);
                    this.$router.push('/')
                }).
                catch((error) => {
                    this.$store.commit('loginFailed', error);
                });
        },
        getConstraints(){
            return {
                name: {
                    presence: true,
                    length: {
                        minimum: 3,
                        message: 'Must be atleast 3 characters long'
                    }
                },
                email: {
                    presence: true,
                    email: true
                },
                password: {
                    presence: true,
                    length: {
                        minimum: 8,
                        message: 'Must be atleast 8 characters long'
                    }
                },
                cpassword: {
                    presence: true,
                    equality: 'password'
                }
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

</style>
