<?php

namespace App\Http\Controllers;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preferredShops()
    {
        return view('shops.preferred');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nearbyShops()
    {
        return view('shops.nearby');
    }
}
