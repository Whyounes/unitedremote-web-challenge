<?php

namespace App\Transformers;

use App\Models\Shop;
use App\Services\ShopsService;
use Illuminate\Auth\AuthManager;
use League\Fractal\TransformerAbstract;

class ShopTransformer extends TransformerAbstract
{
    /** @var \Illuminate\Auth\AuthManager */
    protected $authManager;

    /** @var \App\Services\ShopsService */
    protected $shopsService;

    public function __construct(AuthManager $authManager, ShopsService $shopsService)
    {
        $this->authManager = $authManager;
        $this->shopsService = $shopsService;
    }

    public function transform(Shop $shop)
    {
        $shopData = [
            'id'          => $shop->id,
            'name'        => $shop->name,
            'image'       => $shop->image,
            'lat'         => $shop->lat,
            'lng'         => $shop->lng,
            'created_at'  => $shop->created_at->timestamp
        ];

        if ($user = $this->authManager->guard()->user()) {
            /** @var \App\Models\User $user */

            $user->load(['preferredShops', 'dislikedShops']);

            $shopData['is_liked'] = $this->shopsService->doesUserLikeShop($user, $shop);
            $shopData['is_disliked'] = $this->shopsService->doesUserDislikeShop($user, $shop);
        }

        return $shopData;
    }
}
