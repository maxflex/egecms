<?php
URL::forceSchema('https');

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    # Variables
    Route::resource('variables', 'VariablesController');
    Route::group(['prefix' => 'variables'], function() {
        Route::resource('groups', 'VariableGroupsController');
    });

    # Pages
    Route::post('pages/checkExistance/{id?}', 'PagesController@checkExistance');
    Route::post('pages/search', 'PagesController@search');
    Route::resource('pages', 'PagesController');

    # Translit
    Route::post('translit/to-url', 'TranslitController@toUrl');

    Route::resource('sass', 'SassController');

    # Factory
    Route::post('factory', 'FactoryController@get');

    # Sync
    Route::group(['prefix' => 'sync'], function() {
        Route::get('get/{table}', 'SyncController@get');
        Route::post('insert/{table}', 'SyncController@insert');
        Route::post('update/{table}', 'SyncController@update');
    });
});
