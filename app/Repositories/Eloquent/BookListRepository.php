<?php

namespace App\Repositories\Eloquent;

use App\Models\BookList;
use App\Repositories\Interfaces\BookListRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Repositories\Eloquent
 */
class BookListRepository extends EloquentRepository implements BookListRepositoryInterface
{
    /** @var BookList */
    protected $model;

    public function __construct(BookList $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $bookListId
     * @param int $bookId
     */
    public function addBook(int $bookListId, int $bookId): void
    {
        /** @var BookList $bookList */
        $bookList = $this->model->findOrFail($bookListId);
        $bookList->books()->attach($bookId);
    }

    /**
     * @param int $bookListId
     * @param string $sortBooksBy
     * @param string $sortBooksDir
     * @return BookList|Model|Collection|static|static[]
     */
    public function findOrFailWithBooks(int $bookListId, string $sortBooksBy = 'pivot_id', string $sortBooksDir = 'asc')
    {
        return $this->model
            ->with([
                'books' => function ($query) use ($sortBooksBy, $sortBooksDir) {
                    $query->orderBy($sortBooksBy, $sortBooksDir);
                }
            ])
            ->findOrFail($bookListId);
    }

    /**
     * @param int $bookListId
     * @param int $bookId
     */
    public function removeBookById(int $bookListId, int $bookId): void
    {
        /** @var BookList $bookList */
        $bookList = $this->model->findOrFail($bookListId);
        $bookList->books()->detach($bookId);
    }

    /**
     * @param int $bookListId
     * @param array $bookIds
     */
    public function setBooksById(int $bookListId, array $bookIds): void
    {
        /** @var BookList $bookList */
        $bookList = $this->model->findOrFail($bookListId);
        // need to empty old Books and refill so that new order is reflected exactly
        $bookListBooks = $bookList->books();
        $bookListBooks->sync([]);
        $bookListBooks->sync($bookIds);
    }
}
