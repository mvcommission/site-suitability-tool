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

Route::group(['prefix'=>'data'], function(){
	Route::get('bike_network', 'LayerController@get_bike_network');
	Route::get('bus_route', 'LayerController@get_bus_route');
	Route::get('roads', 'LayerController@get_roads');
	Route::get('wetlands', 'LayerController@get_wetlands');
	Route::get('historic', 'LayerController@get_historic');
	Route::get('town/{town}', 'LayerController@get_town_parcels');
	// Route::get('parcel_data/{town}', 'LayerController@get_parcel_data');
	Route::get('vacant/{town}', 'LayerController@get_vacant_parcels');
	Route::get('zoning', 'LayerController@get_zoning');
	Route::get('open', 'LayerController@get_open_space');
	Route::get('watershed', 'LayerController@get_watersheds');
	Route::get('water_supply_protection_zones', 'LayerController@get_water_protection_zones');
	Route::get('wildlife_habitats', 'LayerController@get_wildlife_habitats');
	Route::get('owner/{loc_id}/{town_id}', 'LayerController@get_owner');
	Route::get('get_edgartown_water', 'LayerController@get_edgartown_water');



});

// Route::get('bike_network', 'LayerController@test');