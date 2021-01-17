<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BookListRepositoryInterface;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @package App\Http\Controllers\Api
 */
class BookListController extends Controller
{
    /** @var BookListRepositoryInterface */
    private $bookListRepository;

    /** @var BookRepositoryInterface */
    private $bookRepository;

    /**
     * @param BookListRepositoryInterface $bookListRepository
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(BookListRepositoryInterface $bookListRepository, BookRepositoryInterface $bookRepository)
    {
        $this->bookListRepository = $bookListRepository;
        $this->bookRepository = $bookRepository;
    }

    /**
     * @return JsonResponse
     */
    public function putBookList(): JsonResponse
    {
        return response()->json(
            [
                'bookList' => $this->bookListRepository->create()
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @param Request $request
     * @param int $bookListId
     * @return JsonResponse
     */
    public function getBookList(Request $request, int $bookListId): JsonResponse
    {
        return response()->json([
            'bookList' => $this->bookListRepository->findOrFailWithBooks(
                $bookListId,
                $request->get('sortBy', 'pivot_id'),
                $request->get('sortAsc', 1) ? 'asc' : 'desc'
            )
        ]);
    }

    /**
     * @param Request $request
     * @param int $bookListId
     * @return JsonResponse
     */
    public function putBook(Request $request, int $bookListId): JsonResponse
    {
        $book = $this->bookRepository->firstOrCreate($request->get('bookData'));
        $this->bookListRepository->addBook($bookListId, $book->id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request int[] bookIds
     * @param int $bookListId
     * @return JsonResponse
     */
    public function postBooks(Request $request, int $bookListId): JsonResponse
    {
        $bookIds = $request->get('bookIds', []);
        $this->bookListRepository->setBooksById(
            $bookListId,
            array_merge($bookIds, $this->bookRepository->find($bookIds)->pluck('id')->toArray())
        );
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $bookListId
     * @param int $bookId
     * @return JsonResponse
     */
    public function deleteBook(int $bookListId, int $bookId): JsonResponse
    {
        $this->bookListRepository->removeBookById($bookListId, $bookId);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
