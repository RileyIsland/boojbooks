<template>
    <div>
        <h1 style="text-align:center;">Booj Book List</h1>
        <br/><br/>
        <div v-if="editingList">
            <div class="text-center">
                <b-spinner label="Spinning"></b-spinner>
            </div>
        </div>
        <div v-else-if="errorGettingBookList">
            Error Creating Book List
            <b-button type="button" @click="createBookList">Try Again</b-button>
        </div>
        <div v-else-if="errorGettingBooks">
            Error Getting Books
            <b-button type="button" @click="getBooks">Try Again</b-button>
        </div>
        <div v-else>
            <div style="text-align: center">
                <b-button variant="primary" v-b-modal.add-book-modal>Add a Book</b-button>
            </div>
            <br/><br/>
            <div v-if="books.length">
                <b-table striped hover :items="books" :fields="bookFields">
                    <template #cell(actions)="data">
                        <router-link :to="{name: 'book', params: {book_id: data.item.id}}">
                            <b-button
                                type="button"
                                style="margin-right: 15px;"
                            >
                                <b-icon-eye></b-icon-eye>
                            </b-button>
                        </router-link>
                        <b-button
                            variant="outline-primary"
                            type="button"
                            @click="moveUp(data.item)"
                            v-if="data.item.order > 1"
                        >
                            <b-icon-chevron-up></b-icon-chevron-up>
                        </b-button>
                        <b-button
                            variant="outline-primary"
                            type="button"
                            @click="moveDown(data.item)"
                            v-if="data.item.order < books.length"
                        >
                            <b-icon-chevron-down></b-icon-chevron-down>
                        </b-button>
                        <b-button
                            variant="outline-danger"
                            type="button"
                            style="margin-left:15px;"
                            @click="deleteBook(data.item.id)"
                        >
                            X
                        </b-button>
                    </template>
                </b-table>
                <br/><br/>
                <div style="text-align: center">
                    <b-button variant="primary" v-b-modal.add-book-modal>Add a Book</b-button>
                </div>
            </div>
            <div v-else>
                No Books Yet
            </div>
            <b-modal
                id="add-book-modal"
                ref="add-book-modal"
                hide-footer
            >
                <template #modal-title>
                    Add a Book
                </template>
                <b-form id="add-book-form" @submit="false">
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
                    <b-button type="button" variant="primary" @click="addBook">Add Book</b-button>
                </b-form>
            </b-modal>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            bookListId: null,
            bookToAdd: {
                author: '',
                title: ''
            },
            bookFields: [
                {
                    key: 'order',
                    sortable: true
                },
                {
                    key: 'title',
                    sortable: true
                },
                {
                    key: 'author',
                    sortable: true
                },
                {
                    key: 'actions',
                    label: 'Actions',
                    sortable: false,
                }
            ],
            books: [],
            editingList: false,
            errorGettingBookList: false,
            errorGettingBooks: false
        }
    },
    mounted() {
        if (this.$cookies.isKey('book_list_id')) {
            this.bookListId = parseInt(this.$cookies.get('book_list_id'));
            this.getBooks();
        } else {
            this.createBookList();
        }
    },
    methods: {
        createBookList() {
            this.editingList = true;
            axios.put('/api/book-list')
                .then(data => {
                    this.bookListId = data.data.bookList.id;
                    this.$cookies.set('book_list_id', this.bookListId, '60m');
                    this.getBooks()
                })
                .catch((err) => {
                    console.error(err);
                    this.errorGettingBookList = true;
                });
        },
        getBooks() {
            this.editingList = true;
            this.errorGettingBooks = false;
            axios
                .get('/api/book-list/' + this.bookListId)
                .then(data => {
                    let books = data.data.bookList.books || [];
                    books.forEach((book, index) => {
                        book.order = index + 1;
                    });
                    this.books = books;
                })
                .catch((err) => {
                    console.error(err);
                    this.errorGettingBooks = true;
                })
                .then(() => {
                    this.editingList = false;
                });
        },
        addBook() {
            this.editingList = true;
            axios.put(
                '/api/book-list/' + this.bookListId + '/book',
                {
                    bookListId: this.bookListId,
                    bookData: this.bookToAdd
                }
            ).then(() => {
                this.bookToAdd.author = "";
                this.bookToAdd.title = "";
                this.getBooks();
            }).catch((err) => {
                console.error(err);
                this.editingList = false;
                alert('Failed to add book');
            });
        },
        deleteBook(bookId) {
            this.editingList = true;
            axios
                .delete('api/book-list/' + this.bookListId + '/book/' + bookId)
                .then(this.getBooks)
                .catch((err) => {
                    console.error(err);
                    alert('Failed to remove book');
                });
        },
        moveUp(book) {
            this.editingList = true;
            let bookIds = [];
            let beforeBooks = this.books.slice(0, Math.max(0, book.order - 2));
            let afterBooks = this.books.slice(Math.max(0, book.order - 2));
            beforeBooks.forEach(beforeBook => {
                if (beforeBook.id === book.id) {
                    return;
                }
                bookIds.push(beforeBook.id);
            });
            bookIds.push(book.id);
            afterBooks.forEach(afterBook => {
                if (afterBook.id === book.id) {
                    return;
                }
                bookIds.push(afterBook.id);
            });
            this.postBooks(bookIds);
        },
        moveDown(book) {
            this.editingList = true;
            let bookIds = [];
            let beforeBooks = this.books.slice(0, Math.min(book.order + 1, this.books.length));
            let afterBooks = this.books.slice(Math.max(0, book.order + 1));
            beforeBooks.forEach(beforeBook => {
                if (beforeBook.id === book.id) {
                    return;
                }
                bookIds.push(beforeBook.id);
            });
            bookIds.push(book.id);
            afterBooks.forEach(afterBook => {
                if (afterBook.id === book.id) {
                    return;
                }
                bookIds.push(afterBook.id);
            });
            this.postBooks(bookIds);
        },
        postBooks(bookIds) {
            axios.post(
                '/api/book-list/' + this.bookListId + '/book',
                {
                    bookIds: bookIds
                }
            ).then(() => {
                this.getBooks();
            }).catch((err) => {
                console.error(err);
                this.editingList = false;
                alert('Failed to reorder books');
            });
        }
    }
}
</script>
