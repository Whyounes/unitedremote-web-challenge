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
 * @property \Illuminate\Support\Collection|\App\Models\Shop[] $dislikedShops
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function preferredShops()
    {
        return $this->belongsToMany(Shop::class, 'liked_user_shops');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dislikedShops()
    {
        return $this->belongsToMany(Shop::class, 'disliked_user_shops');
    }
}
