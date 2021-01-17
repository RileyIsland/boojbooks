<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;

/**
 * @package App\Repositories\Eloquent
 */
class BookRepository extends EloquentRepository implements BookRepositoryInterface
{
    /** @var Book */
    protected $model;

    /**
     * @param Book $model
     */
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }
}
