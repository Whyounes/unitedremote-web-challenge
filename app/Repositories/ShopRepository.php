<?php

namespace App\Repositories;

interface ShopRepository extends BaseRepository
{
    /**
     * @param string $currentLat
     * @param string $currentLng
     * @param array $excludedShops Array of shop IDs to exclude
     *
     * @return \App\Models\Shop[]|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function shopsSortedByDistance(
        string $currentLat,
        string $currentLng,
        array $excludedShops = []
    );

    /**
     * @param int $page
     * @param array $excludedShops
     *
     * @return \App\Models\Shop[]|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function homeShops(array $excludedShops = []);
}
