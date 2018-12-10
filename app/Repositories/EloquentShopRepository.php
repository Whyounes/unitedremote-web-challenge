<?php

namespace App\Repositories;

use App\Models\Shop;

class EloquentShopRepository implements ShopRepository
{
    /**
     * @param string $currentLat
     * @param string $currentLng
     * @param int $page
     * @param array $excludedShops Array of shop IDs to exclude
     *
     * @return \App\Models\Shop[]|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function shopsSortedByDistance(
        string $currentLat,
        string $currentLng,
        array $excludedShops = []
    ) {
        $query = Shop::query();

        $sql = "*, (6371 * acos (cos (radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin (radians(?)) * sin(radians(lat)))) as distance";

        $result = $query->selectRaw($sql, [
            $currentLat,
            $currentLng,
            $currentLat,
        ])->whereNotIn('id', $excludedShops)
            ->orderBy('distance')
            ->paginate($this->perPage(), ['*'], 'page');

        return $result;
    }

    /**
     * @return int
     */
    public function perPage()
    {
        return 10;
    }

    /**
     * @param int $page
     * @param array $excludedShops
     *
     * @return \App\Models\Shop[]|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function homeShops(array $excludedShops = [])
    {
        $query = Shop::query();
        $result = $query->whereNotIn('id', $excludedShops)
            ->paginate($this->perPage(), ['*'], 'page');

        return $result;
    }
}
