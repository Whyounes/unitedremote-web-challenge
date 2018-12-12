<?php

namespace App\Repositories;

use App\Models\Shop;
use App\Models\User;

interface UserRepository extends BaseRepository
{
    /**
     * Return `false` if shop is already liked, otherwise `true`.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function userLikeShop(User $user, Shop $shop);

    /**
     * Return `false` if shop is not in the preferred shops list, otherwise `true`.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function deleteUserLikeShop(User $user, Shop $shop);

    /**
     * Return `false` if shop is not in the preferred shops list, otherwise `true`
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function userDislikeShop(User $user, Shop $shop);
}
