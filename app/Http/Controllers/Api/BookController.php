<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController extends Controller
{
    /**
     * Get Book
     * @param int $bookId
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function getBook(int $bookId): JsonResponse
    {
        return response()->json([
            'book' => Book::findOrFail($bookId)
        ]);
    }
}
