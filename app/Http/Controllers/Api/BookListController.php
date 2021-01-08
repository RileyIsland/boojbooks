<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookListController extends Controller
{
    /**
     * Create BookList
     * @return JsonResponse BookList
     */
    public function putBookList(): JsonResponse
    {
        return response()->json(
            [
                'bookList' => BookList::create()->toArray()
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Get BookList
     * @param Request $request
     * @param int $bookListId
     * @return JsonResponse BookList
     * @throws NotFoundHttpException
     */
    public function getBookList(Request $request, int $bookListId): JsonResponse
    {
        return response()->json([
            'bookList' => BookList
                ::with([
                    'books' => function ($query) use ($request) {
                        $query->orderBy(
                            $request->get('sortBy', 'pivot_id'),
                            $request->get('sortAsc', 1) ? 'asc' : 'desc'
                        );
                    }
                ])
                ->findOrFail($bookListId)
        ]);
    }

    /**
     * Create Book and add to BookList Books
     * @param Request $request
     * @param int $bookListId
     * @return JsonResponse no content
     */
    public function putBook(Request $request, int $bookListId): JsonResponse
    {
        /** @var BookList $bookList */
        $bookList = BookList::with('books')->find($bookListId);
        $bookData = $request->get('bookData');
        $book = Book::firstOrCreate([
            'author' => $bookData['author'],
            'title' => $bookData['title'],
        ]);
        $books = $bookList->books;
        $books->push($book);
        $bookList->books()->sync($books->pluck('id'));
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Clear and reassign BookList Books by given bookIds that belong to existing Books
     * @param Request $request
     * @param int $bookListId
     * @return JsonResponse no content
     */
    public function postBooks(Request $request, int $bookListId): JsonResponse
    {
        $bookList = BookList::find($bookListId);
        $bookIds = $request->get('bookIds', []);
        $books = Book::whereIn('id', $bookIds)->get();
        // Need to empty old Books or BookBookList order will not properly reflect request order after actual sync
        $bookList->books()->sync([]);
        $bookList->books()->sync(array_intersect($bookIds, $books->pluck('id')->toArray()));
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete Book from BookList
     * @param int $bookListId
     * @param int $bookId
     * @return JsonResponse no content
     */
    public function deleteBook(int $bookListId, int $bookId): JsonResponse
    {
        $bookList = BookList::with('books')->find($bookListId);
        $booksToKeep = $bookList->books->filter(function ($book) use ($bookId) {
            return $book->id != $bookId;
        });
        $bookList->books()->sync($booksToKeep->pluck('id'));
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
