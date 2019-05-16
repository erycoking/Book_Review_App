<template>
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="jumbotron col-md-10">
                    <h1 class="display-3">Book Review Site</h1>
                    <p class="lead">Welcome to our book review site</p>
                    <hr class="my-2">
                    <p>
                        Would you like to review a book or add a book for review then you have come to the right place.
                        <br>
                        click the link below to view the books available for review
                    </p>
                    <p class="lead">
                        <router-link class="btn btn-primary btn-lg" to='/books'>Go to Books page</router-link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'home'
    }
</script>



