<?php

namespace App\Repositories;

use App\Models\Shop;
use App\Models\User;

class EloquentUserRepository implements UserRepository
{

    /**
     * Return `false` if shop is already liked, otherwise `true`
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function userLikeShop(User $user, Shop $shop)
    {
        if ($user->preferredShops()->where('shop_id', $shop->id)->exists()) {
            return false;
        }

        $user->preferredShops()->sync([$shop->id]);

        return true;
    }

    /**
     * Return `false` if shop is already disliked, otherwise `true`
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function userDislikeShop(User $user, Shop $shop)
    {
        if ($user->dislikedShops()->where('shop_id', $shop->id)->exists()) {
            return false;
        }

        $user->dislikedShops()->sync([$shop->id]);

        return true;
    }

    /**
     * Return `false` if shop is not in the preferred shops list, otherwise `true`.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function deleteUserLikeShop(User $user, Shop $shop)
    {
        /** @var \App\Models\Model $like */
        $like = $user->preferredShops()->where('shop_id', $shop->id)->first();

        if (is_null($like)) {
            return false;
        }

        return $like->delete();
    }
}
