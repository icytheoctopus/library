<template>
    <div class="container">
        <h1>Create Author</h1>
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
        <div class="form-group">
            <button @click="addAuthor" class="btn btn-success">Add Author</button>
        </div>
    </div>
</template>

<script>
    import { required, between, minLength, maxLength } from 'vuelidate/lib/validators'

    export default {
        data(){
            return {
                author:{},
                laravelValidationErrors: {
                    author:{},
                    book:{},
                }
            }
        },
        validations: {
            author:{
                firstname: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(50)
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
        },
        methods: {
            addAuthor(){
                this.$v.$touch();
                if(!this.$v.$invalid){
                    let uri = 'http://library.dev.local/api/author/create';
                    this.axios.post(uri, this.author).then((response) => {
                        this.$router.push({name: 'authors'});
                    }).catch(error => {
                        this.laravelValidationErrors.author = error.response.data.errors;
                    });
                }
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
</style>

