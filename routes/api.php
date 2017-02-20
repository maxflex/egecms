<?php
URL::forceSchema('https');

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    # Variables
    Route::post('variables/push', 'VariablesController@push');
    Route::post('variables/pull', 'VariablesController@pull');
    Route::resource('variables', 'VariablesController');

    # Pages
    Route::post('pages/checkExistance/{id?}', 'PagesController@checkExistance');
    Route::post('pages/search', 'PagesController@search');
    Route::resource('pages', 'PagesController');

    # Translit
    Route::post('translit/to-url', 'TranslitController@toUrl');

    # Tags
    Route::get('tags/autocomplete', 'TagsController@autocomplete');
    Route::resource('tags', 'TagsController');

    # Factory
    Route::post('factory', 'FactoryController@get');
});
