<template>
    <div class="container">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link to="/" class="nav-link">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/authors" class="nav-link">Authors</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/books" class="nav-link">Books</router-link>
                </li>
            </ul>
        </nav>
        <br />
        <router-view></router-view>
    </div>
</template>

<script>
    export default{}
</script>
