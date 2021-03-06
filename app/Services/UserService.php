<?php

namespace App\Services;

use App\Models\Shop;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use Illuminate\Auth\AuthManager;

class UserService extends BaseService
{
    /** @var \Illuminate\Auth\AuthManager */
    protected $authManager;

    /** @var \App\Repositories\UserRepository */
    protected $userRepository;
    /** @var \App\Repositories\ShopRepository */
    private $shopRepository;

    public function __construct(AuthManager $authManager, UserRepository $userRepository, ShopRepository $shopRepository)
    {
        $this->authManager = $authManager;
        $this->userRepository = $userRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * Return `false` if shop is already liked, otherwise `true`
     *
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function likeShop(Shop $shop)
    {
        /** @var \App\Models\User $user */
        $user = $this->authManager->guard()->user();

        return $this->userRepository->userLikeShop($user, $shop);
    }

    /**
     * Return `false` if shop is not in the preferred shops list, otherwise `true`
     *
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function dislikeShop(Shop $shop)
    {
        /** @var \App\Models\User $user */
        $user = $this->authManager->guard()->user();

        return $this->userRepository->userDislikeShop($user, $shop);
    }

    /**
     * @return \App\Models\Shop[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function likedShops()
    {
        /** @var \App\Models\User $user */
        $user = $this->authManager->guard()->user();

        return $this->shopRepository->likedShops($user);
    }

    /**
     * @return \App\Models\Shop[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function dislikedShops()
    {
        /** @var \App\Models\User $user */
        $user = $this->authManager->guard()->user();

        return $this->shopRepository->dislikedShops($user);
    }

    /**
     * @param \App\Models\Shop $shop
     *
     * @return bool
     */
    public function deleteLikeShop(Shop $shop)
    {
        /** @var \App\Models\User $user */
        $user = $this->authManager->guard()->user();

        return $this->userRepository->deleteUserLikeShop($user, $shop);
    }
}
