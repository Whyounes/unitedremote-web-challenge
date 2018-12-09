<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

/**
 * Trait HasUUID
 * @mixin \App\Models\Model
 * @package App\Models
 */
trait HasUUID
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            /** @var \App\Models\Model $model */
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}