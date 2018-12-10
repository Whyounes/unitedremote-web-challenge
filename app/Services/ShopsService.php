<?php

namespace App\Services;

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

        return $user->preferredShops()->get(['id'])->pluck('id')->toArray();
    }

    /**
     * @return \App\Models\Shop[]|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function homeShops()
    {
        $excludedShops = $this->userExcludedShops();

        return $this->shopRepository->homeShops($excludedShops);
    }
}
