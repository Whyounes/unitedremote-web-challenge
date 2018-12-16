<?php

namespace App\Services;

use App\Models\Shop;
use App\Models\User;
use App\Repositories\ShopRepository;
use Illuminate\Auth\AuthManager;

class ShopsService extends BaseService
{
    /** @var \App\Repositories\ShopRepository */
    protected $shopRepository;

    /** @var \Illuminate\Auth\AuthManager */
    protected $authManager;

    public function __construct(ShopRepository $shopRepository, AuthManager $authManager)
    {
        $this->shopRepository = $shopRepository;
        $this->authManager = $authManager;
    }

    /**
     * @param string|null $currentLat
     * @param string|null $currentLng
     *
     * @return \App\Models\Shop[]|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function homeShopsSortedByDistance(string $currentLat, string $currentLng)
    {
        $excludedShops = $this->userExcludedShops();

        return $this->shopRepository->shopsSortedByDistance($currentLat, $currentLng, $excludedShops);
    }

    /**
     * If the user is logged we return the list of preferred shops to exclude.
     *
     * @return array
     */
    protected function userExcludedShops()
    {
        if (!$this->authManager->guard()->check()) {
            return [];
        }

        /** @var \App\Models\User $user */
        $user = $this->authManager->guard()->user();

        $preferredShops = $user->preferredShops()
            ->get(['id'])
            ->pluck('id')
            ->toArray();

        $mutedForTzoHoursShops = $user->dislikedShops()
            ->whereRaw('`disliked_user_shops`.`created_at` > SUBDATE( CURRENT_DATE, INTERVAL 2 HOUR)');

        $mutedForTzoHoursShops = $mutedForTzoHoursShops->get(['id'])
            ->pluck('id')
            ->toArray();

        return $preferredShops + $mutedForTzoHoursShops;
    }

    /**
     * @return \App\Models\Shop[]|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function homeShops()
    {
        // TODO: remove shops disliked more than 2 hours ago
        $excludedShops = $this->userExcludedShops();

        return $this->shopRepository->homeShops($excludedShops);
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function doesUserLikeShop(User $user, Shop $shop)
    {
        // If already eager-loaded
        if ($user->relationLoaded('preferredShops')) {
            return $user->preferredShops->contains('id', '=', $shop->id);
        }

        return $user->preferredShops()->where('shop_id', $shop->id)->exists();
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function doesUserDislikeShop(User $user, Shop $shop)
    {
        // If already eager-loaded
        if ($user->relationLoaded('dislikedShops')) {
            return $user->dislikedShops->contains('id', '=', $shop->id);
        }

        return $user->dislikedShops()->where('shop_id', $shop->id)->exists();
    }
}
