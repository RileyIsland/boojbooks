<template>
    <div v-if="gettingBooks">
        Retrieving Book List...
        <div class="text-center">
            <b-spinner label="Spinning"></b-spinner>
        </div>
    </div>
    <div v-else-if="!errorGettingBooks">
        <b-button v-b-modal.add-book-modal>Add a Book</b-button>
        <ul id="book_list">
            <Book v-for="book in books" :key="book.id" :author="book.author" :title="book.title"
                  v-on:delete-book="deleteBook(book.id)"/>
        </ul>
        <b-modal
            id="add-book-modal"
            busy
        >
            <template #modal-title>
                Add a Book
            </template>
            <b-form @submit="addBook">
                <b-form-group
                    id="book-title-input-group"
                    label="Title"
                    label-for="book-name-input"
                >
                    <b-form-input
                        id="book-title-input"
                        v-model="bookToAdd.title"
                        placeholder="Enter title"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="book-author-input-group"
                    label="Author"
                    label-for="book-author-input"
                >
                    <b-form-input
                        id="book-author-input"
                        v-model="bookToAdd.author"
                        placeholder="Enter author"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-button type="submit" variant="primary" @click="addBook">Add Book</b-button>
            </b-form>
        </b-modal>
    </div>
    <div v-else>
        Error Getting Books
        <b-button type="button" @click="getBooks">Try Again</b-button>
    </div>
</template>

<script>
import axios from "axios";
import Book from "./Book";

export default {
    components: {Book},
    data() {
        return {
            bookToAdd: {
                author: "",
                title: ""
            },
            books: [],
            errorGettingBooks: false,
            gettingBooks: false
        }
    },
    props: ['bookListId'],
    mounted() {
        this.getBooks();
    },
    methods: {
        addBook() {
            console.log(this.bookToAdd);
            axios.put(
                '/api/booklist/' + this.bookListId + '/book',
                {
                    bookListId: this.bookListId,
                    book: this.bookToAdd
                }
            ).then(() => {
                bookToAdd.author = "";
                bookToAdd.title = "";
                this.getBooks();

            })
        },
        deleteBook(bookId) {
            console.log(bookId);
            axios
                .delete('api/booklist/' + this.prop.bookListId + '/book/' + bookId)
                .then(this.getBooks);
        },
        getBooks() {
            this.gettingBooks = true;
            this.errorGettingBooks = false;
            axios
                .get('/api/booklist/' + this.bookListId)
                .then(data => {
                    console.log(data);
                    return JSON.parse(data.data).bookList.books;
                })
                .then(books => {
                    this.books = books;
                })
                .catch(() => {
                    this.errorGettingBooks = true;
                })
                .then(() => {
                    this.gettingBooks = false;
                });
        }
    }
}
</script>
