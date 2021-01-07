<template>
    <div id="container">
        <h1>Booj Book Details</h1>
        <br/><br/>
        <div v-if="retrievingBook">
            <div class="text-center">
                <b-spinner label="Spinning"></b-spinner>
            </div>
        </div>
        <div v-else-if="!errorRetrievingBook">
            <b-table stacked :items="books"></b-table>
        </div>
        <div v-else>
            Error Getting Book Details
            <b-button type="button" @click="getBookDetails">Try Again</b-button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            books: [],
            errorRetrievingBook: false,
            retrievingBook: false
        }
    },
    mounted() {
        this.getBookDetails();
    },
    methods: {
        getBookDetails() {
            this.retrievingBook = true;
            axios.get('/api/book/' + this.$route.params.book_id)
                .then((data) => {
                    this.books = [data.data.book]
                })
                .catch((err) => {
                    console.error(err);
                    this.errorRetrievingBook = true;
                })
                .then(() => {
                    this.retrievingBook = false;
                });
        }
    }
}
</script>
