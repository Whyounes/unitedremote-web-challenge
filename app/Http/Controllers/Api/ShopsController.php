<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use App\Services\ShopsService;
use App\Services\UserService;
use App\Transformers\ShopTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;

class ShopsController extends BaseController
{
    /** @var \App\Services\ShopsService */
    protected $shopsService;

    /** @var \App\Services\UserService */
    protected $userService;

    public function __construct(Manager $manager, ShopsService $shopsService, UserService $userService)
    {
        parent::__construct($manager);

        $this->shopsService = $shopsService;
        $this->userService = $userService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(Request $request)
    {
        $shops = null;

        if ($request->has('lat') && $request->has('lng')) {
            $shops = $this->shopsService->homeShopsSortedByDistance($request->get('lat'), $request->get('lng'));
        } else {
            $shops = $this->shopsService->homeShops();
        }

        return $this->withPagination($shops, app(ShopTransformer::class));
    }

    /**
     * @param \App\Models\Shop $shop
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeShop(Shop $shop)
    {
        if ($this->userService->likeShop($shop) === false) {
            return $this->withError(
                'You already liked this shop. Visit your preferred shops to see the list.',
                'ALREADY-LIKED-SHOP'
            );
        }

        return $this->withCreated($shop, app(ShopTransformer::class));
    }

    /**
     * @param \App\Models\Shop $shop
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteLikeShop(Shop $shop)
    {
        if ($this->userService->deleteLikeShop($shop) === false) {
            // TODO: Maybe this is a 404 response, shop is not found in my preferred shops list.
            return $this->withError(
                'You don\'t have this shop in your preferred shops list.',
                'ALREADY-LIKED-SHOP'
            );
        }

        return $this->withNoContent();
    }

    /**
     * @param \App\Models\Shop $shop
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislikeShop(Shop $shop)
    {
        if ($this->userService->dislikeShop($shop) === false) {
            return $this->withError(
                'You already disliked this shop.',
                'CANT-DISLIKED-SHOP'
            );
        }

        return $this->withCreated($shop, app(ShopTransformer::class));
    }
}
