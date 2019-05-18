<template>
    <div id="main">
        <navbar />
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import navbar from './Navbar';

    /**
     * defining default landing page
     */
    export default {
        name: 'main-app',
        components: {navbar}
    }
</script>
