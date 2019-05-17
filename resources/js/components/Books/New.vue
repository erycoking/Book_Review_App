<template>
    <div class="book-new">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form @submit.prevent="add">
                    <div class="bg-danger pt-2 pb-2 pl-2 pr-2" v-if="errors">
                        <ul>
                            <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                                <strong>{{ fieldName }} : </strong> {{ fieldsError.join('\n') }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group row bg-success" v-if="msg">
                        <p>{{ msg }}</p>
                    </div>
                    <div class="form-group row">
                        <label for="title">Title: </label>
                        <input type="text" v-model="book.title" id="title" class="form-control" placeholder="Enter title" aria-describedby="titleId">
                        <small id="titleId" class="text-muted">Enter book title</small>
                    </div>
                    <div class="form-group row">
                        <label for="description">Description: </label>
                        <textarea type="text" cols="30" rows="7" v-model="book.description" id="description" class="form-control" placeholder="Enter description" aria-describedby="descriptionId"></textarea>
                        <small id="titleId" class="text-muted">Enter book description</small>
                    </div>
                    <div class="form-group row">
                        <label for="cover_img">Cover image: </label>
                        <input type="file" accept="image/*"  id="cover_img" @change="onImageChange" class="form-control" aria-describedby="cover_imgId">
                        <small id="cover_imgId" class="text-muted">Upload book cover image</small>
                    </div>
                    <div class="form-group row">
                        <input type="submit" value="Add Book" class="btn btn-primary">
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
    data(){
        return {
            book: {
                title: '',
                description: ''
            },
            cover_img: null,
            errors: null,
            msg: null
        };
    },
    computed: {
        currentUser(){
            return this.$store.getters.currentUser;
        }
    },
    methods: {
        onImageChange(){
            this.$data.cover_img = event.target.files[0];
        },
        add() {
            this.errors = null;
            const constraints = this.getConstraints();

            const errors = validate(this.$data.book, constraints);

            if (errors){
                this.errors = errors;
                return;
            }

            const formData = new FormData();
            Object.keys(this.$data.book).forEach((key, index) =>{
                formData.append(key, this.$data.book[key]);
            });

            if(this.$data.cover_img){
                formData.append('cover_img', this.$data.cover_img, this.$data.cover_img.name);
            }

            //send the book data to the backend api
            axios.post("/api/books", formData, {
                headers: {
                    "Authorization": `Bearer ${this.currentUser.token}`,
                    'Content-Type' : 'multipart/form-data'
                }
            })
            .then((res) => {
                this.msg = 'Book successfully added';
                this.$data.book.title = ''
                this.$data.book.description = ''
            }).catch((err) => {
                this.errors = err;
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

