<template>
    <div>
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <h1>Books</h1>
            </div>
            <div class="col-md-3 col-sm-12 text-right">
                <router-link :to="{ name: 'create-book' }" class="btn btn-primary btn-block">Create Book</router-link>
            </div>
        </div>
        <br>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Release Date</th>
                <th colspan="2" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="book in books" :key="book.id">
                <td>{{ book.id }}</td>
                <td>{{ book.name }}</td>
                <td>{{ book.release_date }}</td>
                <td><router-link :to="{name: 'edit-book', params: { id: book.id }}" class="btn btn-primary btn-block">Edit</router-link></td>
                <td><button class="btn btn-danger btn-block" @click.prevent="deleteBook(book.id)">Delete</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                books: []
            }
        },
        created() {
            let uri = 'http://library.dev.local/api/books';
            this.axios.get(uri).then(response => {
                this.books = response.data.data;
            });
        },
        methods: {
            deleteBook(id) {
                let uri = `http://library.dev.local/api/book/delete/${id}`;
                this.axios.delete(uri).then(response => {
                    this.books.splice(this.books.indexOf(id), 1);
                });
            }
        }
    }
</script>
