<?php

namespace App\Models;

/**
 * Class Shop
 * @property string $id
 * @property string $name
 * @property string $image
 * @property float $lat
 * @property float $lng
 * @package App\Models
 */
class Shop extends Model
{
    use HasUUID;

    const TABLE = 'shops';

    public $incrementing = false;

    protected $table = self::TABLE;

    protected $guarded = ['id'];
}
