<?php
URL::forceSchema('https');

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    # Variables
    Route::post('variables/push', 'VariablesController@push');
    Route::post('variables/pull', 'VariablesController@pull');
    Route::resource('variables', 'VariablesController');

    Route::resource('variable-groups', 'VariableGroupsController');

    # Pages
    Route::post('pages/checkExistance/{id?}', 'PagesController@checkExistance');
    Route::post('pages/search', 'PagesController@search');
    Route::resource('pages', 'PagesController');

    # Translit
    Route::post('translit/to-url', 'TranslitController@toUrl');

    Route::resource('sass', 'SassController');

    # Factory
    Route::post('factory', 'FactoryController@get');
});
