<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*
*   Creating Orders Route
*/
Route::post('orders', 'OrderController@index');

/*
*   Updating order 
*/
Route::put('orders/{id}', 'OrderController@update');

/*
*   Cancel the order
*/
Route::put('orders/{id}/cancel', 'OrderController@cancel');

/*
*   Add Payment to order
*/
Route::put('orders/{id}/payment', 'OrderController@payment');

/*
*   Get Order by ID
*/
Route::get('orders/{id}', 'OrderController@getOrder');

/*
*   Get Orders by Users
*/
Route::get('orders/search/user_id={user_id}', 'OrderController@getOrderByUser');

/*
*   Get Orders Today
*/
Route::get('orders/today', 'OrderController@getTodayOrder');