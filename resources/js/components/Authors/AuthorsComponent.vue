<template>
    <div>
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <h1>Authors</h1>
            </div>
            <div class="col-md-3 col-sm-12 text-right">
                <router-link :to="{ name: 'create-author' }" class="btn btn-primary btn-block">Create Author</router-link>
            </div>
        </div>
        <br>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Address</th>
                <th colspan="2" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(author, index) in authors" :key="author.id">
                <td>{{ author.id }}</td>
                <td>{{ author.firstname }}</td>
                <td>{{ author.lastname }}</td>
                <td>{{ author.age }}</td>
                <td>{{ author.address }}</td>
                <td><router-link :to="{name: 'edit-author', params: { id: author.id }}" class="btn btn-primary btn-block">Manage</router-link></td>
                <td><button class="btn btn-danger btn-block" @click.prevent="deleteAuthor(author.id, index)">Delete</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                authors: []
            }
        },
        created() {
            let uri = 'http://library.dev.local/api/authors';
            this.axios.get(uri).then(response => {
                this.authors = response.data.data;
            });
        },
        methods: {
            deleteAuthor(id,index) {
                let uri = `http://library.dev.local/api/author/delete/${id}`;
                this.axios.delete(uri).then(response => {
                    this.authors.splice(index, 1);
                });
            }
        }
    }
</script>
