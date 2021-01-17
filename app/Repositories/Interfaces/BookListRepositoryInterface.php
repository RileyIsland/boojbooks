<?php

namespace App\Repositories\Interfaces;

use App\Models\BaseModel;
use App\Models\BookList;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @package App\Repositories\Interfaces
 */
interface BookListRepositoryInterface
{
    /**
     * @param int $bookListId
     * @param int $bookId
     */
    public function addBook(int $bookListId, int $bookId): void;

    /**
     * @param array $attributes
     * @return BookList|BaseModel|EloquentRepository|Model
     */
    public function create(array $attributes = []);

    /**
     * @param int $bookListId
     * @param string $sortBooksBy
     * @param string $sortBooksDir
     * @return BookList|Model|Collection|static|static[]
     * @throws ModelNotFoundException
     */
    public function findOrFailWithBooks(int $bookListId, string $sortBooksBy = 'pivot_id', string $sortBooksDir = 'asc');

    /**
     * @param int $bookListId
     * @param int $bookId
     */
    public function removeBookById(int $bookListId, int $bookId): void;

    /**
     * @param int $bookListId
     * @param int[] $bookIds
     */
    public function setBooksById(int $bookListId, array $bookIds): void;
}
