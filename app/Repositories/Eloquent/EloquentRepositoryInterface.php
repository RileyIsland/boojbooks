<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @mixin Builder
 * @package App\Repositories\Eloquent
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model|$this
     */
    public function create(array $attributes = []);

    /**
     * @param mixed $id
     * @param array $columns
     * @return Model|Collection|static[]|static|null
     */
    public function find($id, $columns = ['*']);

    /**
     * @param mixed $id
     * @param array $columns
     * @return Model|Collection|static|static[]
     * @throws ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * @param array $attributes
     * @param array $values
     * @return Model|static
     */
    public function firstOrCreate(array $attributes = [], array $values = []);
}
