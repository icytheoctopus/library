<template>
    <div>
        <h1>Create Author</h1>
        <form @submit.prevent="addAuthor">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Firstname:</label>
                        <input type="text" class="form-control" v-model="author.firstname">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lastname:</label>
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
                        <label>Address:</label>
                        <input type="text" class="form-control" v-model="author.address">
                    </div>
                </div>
            </div>
            <br />
            <div class="form-group">
                <button class="btn btn-primary">Create Author</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                author:{}
            }
        },
        methods: {
            addAuthor(){
                console.log(this.author);
                let uri = 'http://library.dev.local/api/author/create';
                this.axios.post(uri, this.author).then((response) => {
                    this.$router.push({name: 'authors'});
                });
            }
        }
    }
</script>
