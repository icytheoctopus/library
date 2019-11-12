<template>
    <div>
        <h1>Create Book</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group" :class="{'form-group--error' : $v.book.name.$error || this.laravelValidationErrors.book.name}">
                    <label>Book Name</label>
                    <input type="text"
                           class="form-control"
                           v-model="book.name"
                           @change="$v.book.$touch()"
                    >
                    <span class="error-message"
                          v-if="($v.book.$dirty && $v.book.name.$invalid) || this.laravelValidationErrors.book.name"
                          v-html="booknameErrorMessage"
                    ></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group" :class="{'form-group--error' : $v.book.release_date.$error || this.laravelValidationErrors.book.release_date}">
                    <label>Release Date</label>
                    <input type="date"
                           class="form-control"
                           v-model="book.release_date"
                           @change="$v.book.$touch()"
                    >
                    <span class="error-message"
                          v-if="($v.book.$dirty && $v.book.release_date.$invalid) || this.laravelValidationErrors.book.release_date"
                          v-html="bookdateErrorMessage"
                    ></span>
                </div>
            </div>
        </div>
        <br />
        <div class="form-group">
            <button class="btn btn-success" @click="addBook">Add Book</button>
        </div>
    </div>
</template>

<script>
    import { required, minLength, maxLength } from 'vuelidate/lib/validators'

    export default {
        data(){
            return {
                book:{},
                laravelValidationErrors: {
                    author:{},
                    book:{},
                }
            }
        },
        validations: {
            book: {
                name: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(100)
                },
                release_date: { required },
            },
        },
        computed: {
            booknameErrorMessage () {
                if (this.laravelValidationErrors.book.name){
                    return this.laravelValidationErrors.book.name.join("<br>");
                }
                else if (!this.$v.book.name.required) {
                    return 'Book name is required';
                }
                else if (!this.$v.book.name.minLength) {
                    return 'Book name should be at least 3 characters long';
                }
                else if (!this.$v.book.name.maxLength) {
                    return 'Book name should not be longer then 100 characters';
                }
            },
            bookdateErrorMessage () {
                if (this.laravelValidationErrors.book.release_date){
                    return this.laravelValidationErrors.book.release_date.join("<br>");
                }
                else if (!this.$v.book.release_date.required) {
                    return 'Book release date is required';
                }
            },
        },
        methods: {
            addBook(){
                this.$v.$touch();
                if(!this.$v.$invalid){
                    let uri = 'http://library.dev.local/api/book/create';
                    this.axios.post(uri, this.book).then((response) => {
                        this.$router.push({name: 'books'});
                    }).catch(error => {
                        this.laravelValidationErrors.book = error.response.data.errors;
                    });
                }
            }
        }
    }
</script>
