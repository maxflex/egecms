<?php

use Illuminate\Http\Request;

URL::forceSchema('https');

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    Route::resource('variables', 'VariablesController');
    Route::post('pages/checkExistance/{id?}', 'PagesController@checkExistance');
    Route::resource('pages', 'PagesController');
});
