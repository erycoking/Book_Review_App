<template>
  <div class="view">
    <div class="row justify-content-center">
      <div class="card col-md-10">
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
          <div>
            <template v-if="currentUser.id == book.user.id">
              <p>
                <router-link :to="`${book.id}/edit`" class="btn btn-primary btn-sm mr-1">Edit</router-link>
                <button @click="deleteBook" class="btn btn-danger btn-sm">Delete</button>
              </p>
            </template>
            <template v-else>
              <p>
                <router-link :to="`${book.id}/review`" class="btn btn-primary mr-1">Review App</router-link>
                <router-link to='/books' class='btn btn-secondary ml-auto'>Cancel</router-link>
              </p>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "view",
  /**
   * page attributes 
   */
  data() {
    return {
      book: null
    };
  },
  created() {
    /**
     * fetch book
     */
    axios
      .get(`/api/books/${this.$route.params.id}`, {
        headers: {
          Authorization: `Bearer ${this.currentUser.token}`
        }
      })
      .then(res => {
        this.$data.book = res.data.data;
      });
  },
  methods: {

    /**
     * deleting book
     */
    deleteBook() {
      if (
        confirm(
          `Are you sure you want to delete book : ${this.$data.book.title}`
        )
      ) {
        axios
          .delete(`/api/books/${this.$data.book.id}`, {
            headers: {
              Authorization: `Bearer ${this.currentUser.token}`
            }
          })
          .then(res => {
              alert('book successfully delete');
              this.$router.push({path: '/books'});
          })
          .catch((err) => {
              alert('something went wrong while trying to delete the book. \nTry again later')
          });
      }
    }
  },
  computed: {
    /**
     * getting current user
     */
    currentUser() {
      return this.$store.getters.currentUser;
    }
  }
};
</script>
