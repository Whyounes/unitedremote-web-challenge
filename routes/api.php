<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')
    ->namespace('\\App\\Http\\Controllers\\Api\\')
    ->group(function () {
        Route::post('/shops/{shop}/like', 'ShopsController@likeShop');
        Route::delete('/shops/{shop}/like', 'ShopsController@deleteLikeShop');

        Route::post('/shops/{shop}/dislike', 'ShopsController@dislikeShop');

        Route::get('/me/shops/liked', 'UsersController@likedShops');
        Route::get('/me/shops/disliked', 'UsersController@dislikedShops');
    });

Route::get('/shops', 'Api\\ShopsController@home');
