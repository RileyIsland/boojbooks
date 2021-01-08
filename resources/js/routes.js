import Book from "./components/Book";
import BookList from "./components/BookList";

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            component: BookList
        },
        {
            name: 'book',
            path: '/book/:book_id',
            component: Book
        }
    ]
}
