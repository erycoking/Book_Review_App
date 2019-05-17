<template>
  <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
    <a class="navbar-brand" href="/">Book App</a>
    <button
      class="navbar-toggler" type="button" data-toggle="collapse"
      data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <template v-if="!currentUser">
            <li class="nav-item">
                <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/register">Register</router-link>
            </li>
        </template>
        <template v-else>
            <li class="nav-item">
                <router-link class="nav-link" to="/books">Books</router-link>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                   welcome {{ currentUser.name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a href="#!" @click.prevent="logout" class="dropdown-item">Logout</a>
                </div>
            </li>
        </template>
      </ul>
    </div>
  </nav>
</template>

<script>
    export default {
        name: 'navbar',
        methods: {
            logout() {
                this.$store.commit('logout');
                this.$router.push('/login')
            }
        },
        computed: {
            currentUser(){
                return this.$store.getters.currentUser
            }
        }
    }
</script>


