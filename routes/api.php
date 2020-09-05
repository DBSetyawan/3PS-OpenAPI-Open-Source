<?php


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin','middleware' => ['json.response']], function () {

  Route::post('/login', 'AuthController@login')->name('login.api');
  Route::post('/registers', 'AuthController@fetch_access_token_customer')->name('refresh.token.api');
  // Route::post('/registers', 'AuthController@registers')->name('refresh.token.api');fetch_access_token_customer

});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Projects
    Route::apiResource('projects', 'ProjectsApiController');
    
    //Customers
    Route::apiResource('Customers', 'CustomersApi');
    
    //ItemCustomers
    Route::apiResource('ItemCustomers', 'ItemCustomerApi');

    //AddressBookApi
    Route::post('/add-AddressBooks', 'AddressBookApi@saveAddressBookForms');
    Route::get('/AddressBooks', 'AddressBookApi@index');

    //CreateShipment
    Route::post('/create-shipment', 'TransactionTransportPassive@createShipment');
    
    //CityApi
    Route::get('/Citys/{CityId?}', 'CityApi@getALlcity');
    
    Route::get('logout', 'AuthController@logout');

    Route::post('/details', 'AuthController@details')->name('detail_user');


});
