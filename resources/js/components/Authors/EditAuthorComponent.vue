<template>
    <div v-if="author">
        <h1>{{ author.firstname }} {{ author.lastname }}</h1>
        <h3>Personal data</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Firstname</label>
                    <input type="text" class="form-control" v-model="author.firstname">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Lastname</label>
                    <input type="text" class="form-control" v-model="author.lastname">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" class="form-control" v-model="author.age">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" v-model="author.address">
                </div>
            </div>
        </div>
        <br>

        <h3>Author's books</h3>
        <div class="text-right">
            <button class="btn btn-primary" v-if="creatingBook" @click="toogleBookForm">Close</button>
            <button class="btn btn-outline-primary" v-else @click="toogleBookForm">Attach new Book</button>
            <div class="form-group">
            </div>
        </div>

        <!-- Attach book -->
        <div v-if="creatingBook">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" @keyup="bookInputChange" @focusin="focusIn" @focusout="focusOut" v-model="selectedBook.name" >
                        <div>
                            <ul style="width:100%" v-show="suggestionsOpen">
                                <li v-for="(suggestion, index) in books" :key="suggestion.id" @click="suggestionClick(index)" v-show="suggestion.show">
                                    {{ suggestion.name }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Release Date</label>
                        <input type="date" @keyup="bookInputChange" class="form-control" v-model="selectedBook.release_date">
                    </div>
                </div>
            </div>
            <br />
            <div class="form-group text-center">
                <button class="btn btn-outline-success" @click="attachBook" v-if="selectedBook.preselected !== ''">Attach Selected Book</button>
                <button class="btn btn-success" @click="createAttachBook" v-else>Create And Attach Book</button>
            </div>
            <br>
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Release Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(book, index) in authorBooks" :key="book.id">
                <td>{{ book.id }}</td>
                <td>{{ book.name }}</td>
                <td>{{ book.release_date }}</td>
                <td>
                    <router-link :to="{name: 'edit-book', params: { id: book.id }}" class="btn btn-primary">Edit</router-link>
                    <button class="btn btn-outline-danger" @click.prevent="detachBook(book.id, index)">Detach</button>
                    <button class="btn btn-danger" @click.prevent="deleteBook(book.id, index)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <br />
        <div class="form-group">
            <button @click="deleteAuthor" class="btn btn-danger">Delete Author</button>
            <button @click="updateAuthor" class="btn btn-success">Update Author</button>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

    </div>
    <div v-else >Author not found</div>
</template>

<script>
    export default {
        data(){
            return {
                author:{},
                authorBooks:{},
                books:{},

                creatingBook: false,
                suggestionsOpen: false,
                selectedBook: {
                    name: '',
                    id: '',
                    release_date: '',
                    preselected: ''
                },
            }
        },
        created() {
            let uri = `http://library.dev.local/api/author/edit/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.author = response.data.author;
                this.authorBooks = response.data.authorBooks;
                this.books = response.data.books;
            });
        },
        methods: {
            updateAuthor() {
                let uri = `http://library.dev.local/api/author/update/${this.$route.params.id}`;
                this.axios.post(uri, this.author).then((response) => {
                    this.$router.push({name: 'authors'});
                });
            },
            deleteAuthor() {
                let uri = `http://library.dev.local/api/author/delete/${this.author.id}`;
                this.axios.delete(uri).then(response => {
                    this.$router.push({ name: 'authors' });
                });
            },
            createAttachBook() {
                let uri = 'http://library.dev.local/api/book/create/attach';
                let data = {
                    'author': this.author,
                    'book': this.selectedBook,
                };
                this.axios.post(uri, data).then((response) => {
                    this.$router.go();
                });
            },
            attachBook() {
                let uri = `http://library.dev.local/api/attach/${this.author.id}/${this.selectedBook.id}`;
                this.axios.post(uri).then(response => {
                    this.$router.go();
                });
            },
            detachBook(book_id, index) {
                let uri = `http://library.dev.local/api/detach/${this.author.id}/${book_id}`;
                this.axios.post(uri).then(response => {
                    this.authorBooks.splice(index, 1);
                });
            },
            deleteBook(id, index) {
                let uri = `http://library.dev.local/api/book/delete/${id}`;
                this.axios.delete(uri).then(response => {
                    this.authorBooks.splice(index, 1);
                });
            },
            toogleBookForm(){
                this.creatingBook = !this.creatingBook;
            },
            bookInputChange(){
                let inputValue = this.selectedBook.name.toLowerCase();
                this.selectedBook.preselected = '';

                for (let i = 0, len = this.books.length; i < len; i++) {
                    if (inputValue.length === 0){
                        //if inputValue empty show all
                        this.books[i].show = true;
                    } else{
                        this.books[i].show = this.books[i].name.toLowerCase().indexOf(inputValue) !== -1;
                    }
                }
            },
            suggestionClick(index){
                this.selectedBook.preselected = index;
                this.selectedBook.id = this.books[index].id;
                this.selectedBook.name = this.books[index].name;
                this.selectedBook.release_date = this.books[index].release_date;
                this.closeSuggestions();
            },
            closeSuggestions(){
                this.suggestionsOpen = false;
                this.books.forEach((book) => {
                    book.show = false;
                });
            },
            focusIn(){
                this.suggestionsOpen = true;
                this.bookInputChange();
            },
            focusOut(){
                setTimeout(() => this.closeSuggestions(), 200);
            }
        }
    }
</script>
