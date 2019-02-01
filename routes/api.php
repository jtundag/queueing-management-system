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

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1'], function(){

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function ($router) {
        Route::post('register', 'AuthController@register')->name('register');
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::post('refresh', 'AuthController@refresh')->name('refresh');
        Route::post('me', 'AuthController@me')->name('me');
    });
    
    Route::group(['prefix' => '/users', 'as' => 'users.'], function(){
        Route::get('/', 'UsersController@get')->name('get');
        Route::get('/find', 'UsersController@find')->name('find');
        Route::post('/create', 'UsersController@create')->name('create');
        Route::patch('/update', 'UsersController@update')->name('update');
        Route::delete('/delete', 'UsersController@delete')->name('delete');
        Route::group(['prefix' => '/import', 'as' => 'import.'], function(){
            Route::post('/csv', 'UsersController@importCSV')->name('csv');
        });
    });

    Route::group(['prefix' => '/servers', 'as' => 'servers.'], function(){
        Route::get('/', 'ServersController@get')->name('get');
        Route::get('/find', 'ServersController@find')->name('find');
        Route::get('/{id}/reports', 'ServersController@reports')->name('reports');
        Route::post('/create', 'ServersController@create')->name('create');
        Route::patch('/{id}/update', 'ServersController@update')->name('update');
        Route::delete('/delete', 'ServersController@delete')->name('delete');
    });

    Route::group(['prefix' => '/config', 'as' => 'config.'], function(){
        Route::get('/', 'ConfigController@get')->name('get');

        Route::group(['prefix' => '/services', 'as' => 'services.'], function(){
            Route::get('/', 'ServicesController@get')->name('get');
            Route::get('/for-department', 'ServicesController@forDepartment')->name('for_department');
            Route::post('/create', 'ServicesController@create')->name('create');
            Route::patch('/{id}/update', 'ServicesController@update')->name('update');
            Route::delete('/delete', 'ServicesController@delete')->name('delete');
        });

        Route::group(['prefix' => '/groups', 'as' => 'groups.'], function(){
            Route::get('/', 'GroupsController@get')->name('get');
            Route::post('/create', 'GroupsController@create')->name('create');
            Route::patch('/{id}/update', 'GroupsController@update')->name('update');
            Route::delete('/delete', 'GroupsController@delete')->name('delete');
        });

        Route::group(['prefix' => '/departments', 'as' => 'departments.'], function(){
            Route::get('/', 'DepartmentsController@get')->name('get');
            Route::post('/create', 'DepartmentsController@create')->name('create');
            Route::patch('/{id}/update', 'DepartmentsController@update')->name('update');
            Route::delete('/delete', 'DepartmentsController@delete')->name('delete');
        });

        Route::group(['prefix' => '/predefined-flows', 'as' => 'predefined-flows.'], function(){
            Route::get('/', 'PredefinedFlowsController@get')->name('get');
            Route::post('/create', 'PredefinedFlowsController@create')->name('create');
            Route::get('/find', 'PredefinedFlowsController@find')->name('find');
            Route::patch('/{id}/update', 'PredefinedFlowsController@update')->name('update');
            Route::delete('/delete', 'PredefinedFlowsController@delete')->name('delete');
        });
    });

    Route::group(['prefix' => '/server', 'as' => 'server.'], function(){
        Route::get('/queues', 'QueueController@getQueues')->name('get_queues');
        Route::post('/next', 'QueueController@serveNext')->name('serve_next');
    });

    Route::post('/push', 'QueueController@push')->name('push_queue');
    Route::get('/{id}/waiting-time', 'QueueController@retrieveWaitingTime')->name('retrieve_waiting_time');
    
    Route::get('/service-queues', 'QueueController@serviceQueues')->name('push_queue');

    Route::post('/request-verification', 'UsersController@requestVerification')->name('request_verification');
    Route::post('/verify', 'UsersController@verify')->name('verify');
    Route::post('/change-password', 'UsersController@changePassword')->name('change_password');

    Route::group(['prefix' => 'tags', 'name' => '.tags'], function(){
        Route::get('/', 'TagsController@get')->name('get');
    });

    Route::post('update-player-id', 'UsersController@updatePlayerId')->name('update_player_id');
    Route::get('/user-queues', 'UsersController@queues')->name('queues');

    Route::group(['prefix' => 'transactions', 'name' => '.transactions'], function(){
        Route::get('/find', 'QueueController@find')->name('find');
    });
});