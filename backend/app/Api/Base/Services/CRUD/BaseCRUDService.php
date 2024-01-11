<?php

namespace App\Api\Base\Services\CRUD;

use App\Api\Base\Dto\BaseDtoAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModelClass of Model
 */
abstract class BaseCRUDService
{
    /**
     * @var Builder<TModelClass>
     */
    protected Builder $query;

    protected string $model;

    public function __construct()
    {
        $this->query = app($this->model)->query();
    }

    public function store(BaseDtoAbstract $dto): Model
    {
        return $this->query->create($dto->toArray());
    }

    public function update(int $id, BaseDtoAbstract $dto): int
    {
        return $this->query->where('id', $id)->update($dto->toArray());
    }

    public function destroy(int $id): mixed
    {
        return $this->query->where('id', $id)->delete();
    }
}
