<template>
    <div v-if="author">
        <h1>{{ author.firstname }} {{ author.lastname }}</h1>
        <h3>Personal data</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" :class="{'form-group--error' : $v.author.firstname.$error || this.laravelValidationErrors.author.firstname }">
                    <label>Firstname</label>
                    <input type="text"
                           class="form-control"
                           v-model="author.firstname"
                           @change="$v.author.$touch()"
                    >
                    <span class="error-message"
                          v-if="($v.author.$dirty && $v.author.firstname.$invalid) || this.laravelValidationErrors.author.firstname"
                          v-html="firstnameErrorMessage"
                    ></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" :class="{'form-group--error' : $v.author.lastname.$error || this.laravelValidationErrors.author.lastname }">
                    <label>Lastname</label>
                    <input type="text"
                           class="form-control"
                           v-model="author.lastname"
                           @change="$v.author.$touch()"
                    >
                    <span class="error-message"
                          v-if="($v.author.$dirty && $v.author.lastname.$invalid) || this.laravelValidationErrors.author.lastname"
                          v-html="lastnameErrorMessage"
                    ></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" :class="{'form-group--error' : $v.author.age.$error || this.laravelValidationErrors.author.age }">
                    <label>Age</label>
                    <input type="number"
                           class="form-control"
                           v-model="author.age"
                           @change="$v.author.$touch()"
                    >
                    <span class="error-message"
                          v-if="($v.author.$dirty && $v.author.age.$invalid) || this.laravelValidationErrors.author.age"
                          v-html="ageErrorMessage"
                    ></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" :class="{'form-group--error' : $v.author.address.$error || this.laravelValidationErrors.author.address }">
                    <label>Address</label>
                    <input type="text"
                           class="form-control"
                           v-model="author.address"
                           @change="$v.author.$touch()"
                    >
                    <span class="error-message"
                          v-if="($v.author.$dirty && $v.author.address.$invalid) || this.laravelValidationErrors.author.address"
                          v-html="addressErrorMessage"
                    ></span>
                </div>
            </div>
        </div>
        <br>

        <!-- Attach book -->
        <h3>Author's books</h3>
        <div class="text-right">
            <button class="btn btn-primary" v-if="creatingBook" @click="toogleBookForm">Close</button>
            <button class="btn btn-outline-primary" v-else @click="toogleBookForm">Attach new Book</button>
        </div>
        <div v-if="creatingBook">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" :class="{'form-group--error' : $v.selectedBook.name.$error || this.laravelValidationErrors.book.name}">
                            <label>Book Name</label>
                            <input type="text"
                                   class="form-control"
                                   v-model="selectedBook.name"
                                   @keyup="bookInputChange"
                                   @focusin="focusIn"
                                   @focusout="focusOut"
                                   @change="$v.selectedBook.$touch()"
                            >
                            <span class="error-message"
                                  v-if="($v.selectedBook.$dirty && $v.selectedBook.name.$invalid) || this.laravelValidationErrors.book.name"
                                  v-html="booknameErrorMessage"
                            ></span>
                            <div>
                                <ul class="suggestion" v-show="suggestionsOpen">
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
                        <div class="form-group" :class="{'form-group--error' : $v.selectedBook.release_date.$error || this.laravelValidationErrors.book.release_date}">
                            <label>Release Date</label>
                            <input type="date"
                                   class="form-control"
                                   v-model="selectedBook.release_date"
                                   :disabled="selectedBook.preselected !==''"
                                   @keyup="bookInputChange"
                                   @change="$v.selectedBook.$touch()"
                            >
                            <span class="error-message"
                                  v-if="($v.selectedBook.$dirty && $v.selectedBook.release_date.$invalid) || this.laravelValidationErrors.book.release_date"
                                  v-html="bookdateErrorMessage"
                            ></span>
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
    </div>
    <div v-else><h2>Author not found</h2></div>
</template>

<script>
    import { required, between, minLength, maxLength } from 'vuelidate/lib/validators'

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
                laravelValidationErrors: {
                    author:{},
                    book:{},
                }
            }
        },
        created() {
            let uri = `http://library.dev.local/api/author/edit/${this.$route.params.id}`;
            this.axios.get(uri).then(response => {
                this.author = response.data.author;
                this.authorBooks = response.data.authorBooks;
                this.books = response.data.books;
            });
        },
        validations: {
            selectedBook: {
                name: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(100)
                },
                release_date: { required },
            },
            author:{
                firstname: {
                    required,
                    // minLength: minLength(3),
                    // maxLength: maxLength(50)
                },
                lastname: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(50)
                },
                age: {
                    required,
                    between: between(15, 100)
                },
                address: {
                    required,
                    maxLength: maxLength(200)
                },
            },
        },
        computed: {
            firstnameErrorMessage () {
                if (this.laravelValidationErrors.author.firstname){
                    return this.laravelValidationErrors.author.firstname.join("<br>");
                }
                else if (!this.$v.author.firstname.required) {
                    return 'Firstname is required';
                }
                else if (!this.$v.author.firstname.minLength) {
                    return 'Firstname should be at least 3 characters long';
                }
                else if (!this.$v.author.firstname.maxLength) {
                    return 'Firstname should not be longer then 50 characters';
                }
            },
            lastnameErrorMessage () {
                if (this.laravelValidationErrors.author.lastname){
                    return this.laravelValidationErrors.author.lastname.join("<br>");
                }
                else if (!this.$v.author.lastname.required) {
                    return 'Lastname is required';
                }
                else if (!this.$v.author.lastname.minLength) {
                    return 'Lastname should be at least 3 characters long';
                }
                else if (!this.$v.author.lastname.maxLength) {
                    return 'Lastname should not be longer then 50 characters';
                }
            },
            ageErrorMessage () {
                if (this.laravelValidationErrors.author.age){
                    return this.laravelValidationErrors.author.age.join("<br>");
                }
                else if (!this.$v.author.age.required) {
                    return 'Age is required';
                }
                else if (!this.$v.author.age.between) {
                    return 'Age range is 15-95';
                }
            },
            addressErrorMessage () {
                if (this.laravelValidationErrors.author.address){
                    return this.laravelValidationErrors.author.address.join("<br>");
                }
                else if (!this.$v.author.address.required) {
                    return 'Address is required';
                }
                else if (!this.$v.author.address.maxLength) {
                    return 'Address should not be longer then 200 characters';
                }
            },
            //Book validation
            booknameErrorMessage () {
                if (this.laravelValidationErrors.book.name){
                    return this.laravelValidationErrors.book.name.join("<br>");
                }
                else if (!this.$v.selectedBook.name.required) {
                    return 'Book name is required';
                }
                else if (!this.$v.selectedBook.name.minLength) {
                    return 'Book name should be at least 3 characters long';
                }
                else if (!this.$v.selectedBook.name.maxLength) {
                    return 'Book name should not be longer then 100 characters';
                }
            },
            bookdateErrorMessage () {
                if (this.laravelValidationErrors.book.release_date){
                    return this.laravelValidationErrors.book.release_date.join("<br>");
                }
                else if (!this.$v.selectedBook.release_date.required) {
                    return 'Book release date is required';
                }
            },
        },
        methods: {
            //CRUD and relationships
            updateAuthor() {
                this.$v.author.$touch();
                if(!this.$v.author.$invalid){
                    let uri = `http://library.dev.local/api/author/update/${this.$route.params.id}`;
                    this.axios.post(uri, this.author).then(response => {
                        this.$router.push({name: 'authors'});
                    }).catch(error => {
                        console.log(error);
                        this.laravelValidationErrors.author = error.response.data.errors;
                    });
                }
            },
            deleteAuthor() {
                let uri = `http://library.dev.local/api/author/delete/${this.author.id}`;
                this.axios.delete(uri).then(response => {
                    this.$router.push({ name: 'authors' });
                }).catch(error => {
                    this.laravelValidationErrors.author = error.response.data.errors;
                });
            },
            createAttachBook() {
                this.$v.selectedBook.$touch();
                if(!this.$v.$invalid) {
                    let uri = 'http://library.dev.local/api/book/create/attach';
                    let data = {
                        'author': this.author,
                        'book': this.selectedBook,
                    };
                    this.axios.post(uri, data).then(response => {
                        this.$router.go();
                    }).catch(error => {
                        this.laravelValidationErrors.book = error.response.data.errors;
                    });
                }
            },
            attachBook() {
                this.$v.selectedBook.$touch();
                if(!this.$v.selectedBook.$invalid) {
                    let uri = `http://library.dev.local/api/attach/${this.author.id}/${this.selectedBook.id}`;
                    this.axios.post(uri).then(response => {
                        this.$router.go();
                    }).catch(error => {
                        this.laravelValidationErrors.book = error.response.data.errors;
                    });
                }
            },
            detachBook(book_id, index) {
                let uri = `http://library.dev.local/api/detach/${this.author.id}/${book_id}`;
                this.axios.post(uri).then(response => {
                    this.authorBooks.splice(index, 1);
                }).catch(error => {
                    this.laravelValidationErrors.book = error.response.data.errors;
                });
            },
            deleteBook(id, index) {
                let uri = `http://library.dev.local/api/book/delete/${id}`;
                this.axios.delete(uri).then(response => {
                    this.authorBooks.splice(index, 1);
                }).catch(error => {
                    this.laravelValidationErrors.author = error.response.data.errors;
                });
            },
            //UI and autosuggestion
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
                    }
                    else{
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
                // setTimeout(() => this.closeSuggestions(), 200);
            }
        }
    }
</script>

<style>
    .error-message{
        color: red;
        font-size: 12px;
    }
    .form-group--error input{
        border-color: red !important;
    }
    .form-group--error label{
        color: red;
    }
    ul.suggestion{
        background-color: white;
        border: 1px solid #ced4da;
        border-radius: 4px;
        list-style: none;

        padding: 0;
        width: 100%;
        max-height: 200px;
        overflow: auto;
    }
    ul.suggestion li{
        padding: 5px;
        font-size: 15px;
        width: 100%;
    }
    ul.suggestion li:hover{
        background-color: #3490dc;
        color: white;
    }
</style>
