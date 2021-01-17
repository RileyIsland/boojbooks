<?php

namespace App\Repositories\Eloquent;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @mixin Builder
 * @package App\Repositories\Eloquent
 */
abstract class EloquentRepository implements EloquentRepositoryInterface
{
    /** @var BaseModel */
    protected $model;

    /**
     * @param BaseModel $model
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return BaseModel|EloquentRepository|Model
     */
    public function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * @param mixed $id
     * @param array|string[] $columns
     * @return BaseModel|BaseModel[]|EloquentRepository|EloquentRepository[]|Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns = ['*']);
    }

    /**
     * @param mixed $id
     * @param array|string[] $columns
     * @return BaseModel|BaseModel[]|EloquentRepository|EloquentRepository[]|Collection|Model|null
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return BaseModel|EloquentRepository|Model
     */
    public function firstOrCreate(array $attributes = [], array $values = [])
    {
        return $this->model->firstOrCreate($attributes, $values);
    }
}
