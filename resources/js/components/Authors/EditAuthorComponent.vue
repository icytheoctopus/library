<template>
    <div>
        <h1>Edit Author</h1>
        <form @submit.prevent="updateAuthor">
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
                <button class="btn btn-primary">Update Author</button>
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
        created() {
            let uri = `http://library.dev.local/api/author/edit/${this.$route.params.id}`;
            this.axios.get(uri).then((response) => {
                this.author = response.data;
            });
        },
        methods: {
            updateAuthor() {
                let uri = `http://library.dev.local/api/author/update/${this.$route.params.id}`;
                this.axios.post(uri, this.author).then((response) => {
                    this.$router.push({name: 'authors'});
                });
            }
        }
    }
</script>
