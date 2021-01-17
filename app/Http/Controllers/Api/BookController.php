<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package App\Http\Controllers\Api
 */
class BookController extends Controller
{
    /** @var BookRepositoryInterface */
    private $bookRepository;

    /**
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param int $bookId
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function getBook(int $bookId): JsonResponse
    {
        return response()->json([
            'book' => $this->bookRepository->findOrFail($bookId)
        ]);
    }
}
