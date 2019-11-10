<template>
    <div>
        <h1>Create Book</h1>
        <form @submit.prevent="addBook">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="book.name">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Release Date</label>
                        <input type="date" class="form-control" v-model="book.release_date">
                    </div>
                </div>
            </div>
            <br />
            <div class="form-group">
                <button class="btn btn-primary">Create Book</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                book:{}
            }
        },
        methods: {
            addBook(){
                let uri = 'http://library.dev.local/api/book/create';
                this.axios.post(uri, this.book).then((response) => {
                    this.$router.push({name: 'books'});
                });
            }
        }
    }
</script>
