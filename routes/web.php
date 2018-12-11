<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->namespace('\\App\\Http\\Controllers\\Api\\')
    ->name('api.')
    ->group(function () {
        Route::post('/shops/{shop}/like', 'ShopsController@likeShop')->name('shops.like');
        Route::delete('/shops/{shop}/like', 'ShopsController@deleteLikeShop')->name('shops.like.delete');;

        Route::post('/shops/{shop}/dislike', 'ShopsController@dislikeShop')->name('shops.dislike');;

        Route::get('/me/shops/liked', 'UsersController@likedShops')->name('shops.liked.index');
        Route::get('/me/shops/disliked', 'UsersController@dislikedShops')->name('shops.disliked.index');
    });

Route::get('/shops', 'Api\\ShopsController@home')->name('api.shops.index');
