<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['preferred_shops', 'disliked_shops'];

    public function transform(User $user)
    {
        return [
            'id'    => $user->id,
            'email' => $user->email,
        ];
    }

    public function includePreferredShops(User $user)
    {
        return $this->collection($user->preferredShops, app(ShopTransformer::class));
    }

    public function includeDislikedShops(User $user)
    {
        return $this->collection($user->dislikedShops, app(ShopTransformer::class));
    }
}
