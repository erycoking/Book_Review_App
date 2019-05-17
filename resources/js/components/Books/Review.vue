<template>
    <div class="book-new">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Title : {{ book.title }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <h5 class="card-title">
                            <b>Description :</b>
                            </h5>
                            <p class="ml-2">{{ book.description }}</p>
                        </div>
                    </div>
                </div>
                <form @submit.prevent="add">
                    <div class="bg-danger pt-2 pb-2 pl-2 pr-2" v-if="errors">
                        <ul>
                            <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                                <strong>{{ fieldName }} : </strong> {{ fieldsError.join('\n') }}
                            </li>
                        </ul>
                    </div>
                    <div class="bg-danger pt-2 pb-2 pl-2 pr-2" v-if="backend_error">
                        <p>{{ backend_error.error }}</p>
                    </div>
                    <div class="bg-success pt-2 pb-2 pl-2 pr-2" v-if="msg">
                        <p>{{ msg }}</p>
                    </div>
                    <div class="form-group row">
                        <label for="rating">Rate the book on a scale of one to ten: </label>
                        <input type="number" min="1" max="10" required  v-model="form.rating" id="title" class="form-control" placeholder="Rate this book" aria-describedby="titleId">
                        <small id="titleId" class="text-muted">Rate the book</small>
                    </div>
                    <div class="form-group row">
                        <label for="description">Review: </label>
                        <textarea type="text" cols="30" required rows="7" v-model="form.review" id="description" class="form-control" placeholder="Enter description" aria-describedby="descriptionId"></textarea>
                        <small id="titleId" class="text-muted">Give your comments about the book</small>
                    </div>
                    <div class="form-group row">
                        <input type="submit" value="Save Review" class="btn btn-primary">
                        <router-link to='/books' class='btn btn-secondary ml-auto'>Cancel</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<script>
import validate from 'validate.js';

export default {
    name: 'new',
    created() {
        axios.get(`/api/books/${this.$route.params.id}`, {
            headers: {
                "Authorization" : `Bearer ${this.currentUser.token}`
            }
        })
        .then((res) => {
            this.$data.book = res.data.data;
        })
        .catch((err) => {
            alert('error loading book');
            this.$router.push(`${this.route.params.id}`);
        });
    },
    data(){
        return {
            form: {
                rating : '',
                review: ''
            },
            book: {
                title: '',
                description: ''
            },
            errors: null,
            backend_error: null,
            msg: null
        };
    },
    computed: {
        currentUser(){
            return this.$store.getters.currentUser;
        }
    },
    methods: {
        add() {
            this.errors = null;
            const constraints = this.getConstraints();

            const errors = validate(this.$data.form, constraints);
            console.log(errors);

            if (errors){
                this.errors = errors;
                return;
            }

            //send the book data to the backend api
            axios.post(`/api/books/${this.$route.params.id}/ratings`, this.$data.form, {
                headers: {
                    "Authorization": `Bearer ${this.currentUser.token}`,
                }
            })
            .then((res) => {
                this.msg = 'Review successfully saved';
            }).catch((err) => {
                console.log(err.response.data);
                this.$data.backend_error = err.response.data;
            });
        },
        getConstraints() {
            return {
                rating: {
                    presence: true,
                    numericality: {
                        onlyInteger: true,
                        greaterThan: 0,
                        lessThanOrEqualTo: 10
                    }
                },
                review: {
                    presence: true,
                    length: {
                        minimum: 10,
                        message: 'Must be atleast 10 characters long'
                    }
                }
            }
        }
    }
}
</script>

<style scoped>

</style>

