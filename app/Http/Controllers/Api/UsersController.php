<?php

namespace App\Http\Controllers\Api;

use App\Services\ShopsService;
use App\Services\UserService;
use App\Transformers\ShopTransformer;
use League\Fractal\Manager;

class UsersController extends BaseController
{
    /** @var \App\Services\UserService */
    protected $userService;
    /** @var \App\Services\ShopsService */
    private $shopsService;

    public function __construct(Manager $manager, UserService $userService, ShopsService $shopsService)
    {
        parent::__construct($manager);

        $this->userService = $userService;
        $this->shopsService = $shopsService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function likedShops()
    {
        $shops = $this->userService->likedShops();

        return $this->withPagination($shops, app(ShopTransformer::class));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislikedShops()
    {
        $shops = $this->userService->dislikedShops();

        return $this->withPagination($shops, app(ShopTransformer::class));
    }

    public function nearbyShops()
    {

    }
}
