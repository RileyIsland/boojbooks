<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookList;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookListController extends Controller
{
    public function index(Request $request, $bookListId)
    {
        $bookList = BookList::with(
            [
                'books' => function ($query) use ($request) {
                    $query->orderBy(
                        $request->get('sortBy', 'pivot_id'),
                        $request->get('sortAsc', 1) ? 'asc' : 'desc'
                    );
                }
            ]
        )
            ->find($bookListId);
        return response()->json(
            [
                'bookList' => $bookList
            ]
        );
    }

    public function postBooks(Request $request, $bookListId)
    {
        $bookList = BookList::find($bookListId);
        $bookIds = $request->get('bookIds', []);
        $books = Book::whereIn('id', $bookIds)->get();
        $bookList->books()->sync([]);
        $bookList->books()->sync(array_intersect($bookIds, $books->pluck('id')->toArray()));
    }

    /**
     * @param Request $request
     * @param $bookListId
     * @return JsonResponse|Response
     * @throws Exception
     */
    public function putBook(Request $request, $bookListId)
    {
        $bookList = BookList::with('books')->find($bookListId);
        $bookData = $request->get('bookData');
        if (!$bookData['author'] || !$bookData['title']) {
            throw new Exception('Book Data Incomplete');
        }
        $book = Book::firstOrCreate([
            'author' => $bookData['author'],
            'title' => $bookData['title'],
        ]);
        $books = $bookList->books;
        $books->push($book);
        $bookList->books()->sync($books->pluck('id'));
        return response([], Response::HTTP_CREATED);
    }

    public function deleteBook($bookListId, $bookId)
    {
        $bookList = BookList::with('books')->find($bookListId);
        $booksToKeep = $bookList->books->filter(function ($book) use ($bookId) {
            return $book->id != $bookId;
        });
        $bookList->books()->sync($booksToKeep->pluck('id'));
        return response([], Response::HTTP_NO_CONTENT);
    }
}
