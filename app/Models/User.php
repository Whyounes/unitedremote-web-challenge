<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @property string $id
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Collection|\App\Models\Shop[] $preferredShops
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable, HasUUID;

    const TABLE = 'users';

    public $incrementing = false;

    protected $table = self::TABLE;

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function preferredShops()
    {
        return $this->hasManyThrough(Shop::class, 'liked_user_shops');
    }

    public function dislikedShops()
    {
        return $this->hasManyThrough(Shop::class, 'disliked_user_shops');
    }
}
