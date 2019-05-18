<template>
    <div class="main">
        <div class="btn-wrapper">
            <router-link to="/books/new" class="btn btn-primary btn-sm mb-3">New</router-link>
        </div>
        <table class="table">
            <thead>
                <th>Title</th>
                <th>Description</th>
                <th>Rating</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <template v-if="!books.length">
                    <tr>
                        <td colspan="4" class="text-center">No Books Available</td>
                    </tr>
                </template>
                <template v-else>
                    <tr v-for="book in books" :key="book.id">
                        <td> {{ book.title }} </td>
                        <td> {{ book.description | truncate(30, '...')}} </td>
                        <td> {{ book.average_rating }} </td>
                        <td>
                            <router-link :to="`/books/${book.id}`" class="nav-link">View</router-link>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>


<script>
/**
 * defining list component for displaying books
 */
export default {
    name: 'list',
    mounted() {
        this.$store.dispatch('getBooks');
    },
    filters: {
        truncate(text, length, suffix) {
            return text.substring(0, length) + suffix;
        }
    },
    computed: {
        /**
         * get all books in the database
         */
        books(){
            return this.$store.getters.books;
        }
    }
}
</script>

<style lang="scss" scoped>
.btn-wrapper{
    text-align: right;
}
</style>

