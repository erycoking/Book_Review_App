<template>
    <div class="book-new">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form @submit.prevent="save">
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
                        <label for="title">Title: </label>
                        <input type="text" v-model="book.title" id="title" class="form-control" placeholder="Enter title" aria-describedby="titleId">
                        <small id="titleId" class="text-muted">Enter book title</small>
                    </div>
                    <div class="form-group row">
                        <label for="description">Description: </label>
                        <textarea type="text" rows="7" cols="10" v-model="book.description" id="description" class="form-control" placeholder="Enter description" aria-describedby="descriptionId"></textarea>
                        <small id="titleId" class="text-muted">Enter book description</small>
                    </div>
                    <div class="form-group row">
                        <input type="submit" value="Save" class="btn btn-primary">
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
    name: 'update',
    created() {
        axios.get(`/api/books/${this.$route.params.id}`, {
            headers: {
                "Authorization" : `Bearer ${this.currentUser.token}`
            }
        })
        .then((res) => {
            var retrieved_book = res.data.data
            this.$data.book = {
                title: retrieved_book.title,
                description: retrieved_book.description
            };
        })
        .catch((err) => {
            alert('error loading book');
            this.$router.push(`${this.route.params.id}`);
        });
    },
    data(){
        return {
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
        save() {
            this.errors = null;
            const constraints = this.getConstraints();

            const errors = validate(this.$data.book, constraints);

            if (errors){
                this.errors = errors;
                return;
            }
            console.log(this.$data.book);

            //send the book data to the backend api
            axios.put(`/api/books/${this.$route.params.id}`, this.$data.book, {
                headers: {
                    "Authorization": `Bearer ${this.currentUser.token}`
                }
            })
            .then((res) => {
                this.msg = 'Book saved added';
            }).catch((err) => {
                console.log(err.response.data);
                this.$data.backend_error = err.response.data;
            });
        },
        getConstraints() {
            return {
                title: {
                    presence: true,
                    length: {
                        minimum: 3,
                        message: 'Must be atleast 3 characters long'
                    }
                },
                description: {
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

