<?php

use Illuminate\Http\Request;

Route::group(['namespace' => 'Api'], function () {
    Route::resource('variables', 'VariablesController');
    Route::resource('pages', 'PagesController');
});
