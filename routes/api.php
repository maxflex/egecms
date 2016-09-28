<?php

use Illuminate\Http\Request;

URL::forceSchema('https');

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    Route::resource('variables', 'VariablesController');
    Route::resource('pages', 'PagesController');
});
