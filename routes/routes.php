<?php

/**
 * Routes for the package would go here
 */

use Illuminate\Support\Facades\Route;

Route::group([
    'layout' => config("paksuco-language.template_to_extend", "layouts.app"),
    'prefix' => config("paksuco-language.admin_route_prefix", ""),
    'as' => 'paksuco.',
    'middleware' => config("paksuco-language.middleware"),
], function () {
});
