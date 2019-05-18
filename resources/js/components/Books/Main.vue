<template>
    <div class="main container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Books</div>
                    <div class="card-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
/**
 * defining main componeny
 */
export default {
    name: 'books-main'
}
</script>
