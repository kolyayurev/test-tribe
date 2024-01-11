<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModelClass of Model
 */
abstract class BaseRepository
{

    protected string $model;

    /**
     * @return Builder<TModelClass>
     */
    public function query(): Builder
    {
        return  app($this->model)->query();
    }

    /**
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->query->find($id);
    }
}
