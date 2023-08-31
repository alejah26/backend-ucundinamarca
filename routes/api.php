<?php

/* -------------------------------------------------
                 RUTAS PARA SECURE
 --------------------------------------------------*/

Route::group([
    'prefix' => 'secure'
], function () {

    Route::get('get', 'SecureController@getSecure');
});
