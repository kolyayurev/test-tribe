<?php

namespace App\Api\Base\Dto;

use Illuminate\Database\Eloquent\Model;

abstract class BaseDtoAbstract
{
    final public function __construct()
    {
    }

    /**
     * @param mixed $model
     * @return static
     */
    public static function fillFromModel(mixed $model): static
    {
        $self = new static;

        $properties = get_class_vars(static::class);
        foreach ($properties as $varName => $value) {

            if (is_null($model->$varName)) continue;

            $self->$varName = $model->$varName;
        }

        return $self;
    }

    /**
     * @param array<string,mixed> $data
     * @return static
     */
    public static function fillFromArray(array $data): static
    {
        $self = new static;

        $properties = get_class_vars(static::class);

        foreach ($properties as $varName => $value) {

            $newVal = $data[$varName] ?? null;

            if (is_null($newVal)) continue;

            $self->$varName = $newVal;
        }

        return $self;
    }


    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $properties = get_class_vars(static::class);
        $result = [];
        foreach ($properties as $property => $value) {
            $result[$property] = $this->$property;
        }

        return $result;
    }
}
