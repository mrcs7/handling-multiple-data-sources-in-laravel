<?php
Route::group(['prefix' => 'products'], function () {;
    Route::post('import', 'ProductImportController@import')->middleware(\App\Http\Middleware\ValidateJsonHeaderMiddleware::class);
    Route::post('import_csv', 'ProductImportController@importCsv');
    Route::get('/{identifier}', 'ProductController@show');
});
