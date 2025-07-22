<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ... autres routes ...

Route::get('/sirene/search', [\App\Http\Controllers\Api\SireneController::class, 'search']);

Route::get('/test', function () {
    return ['ok' => true];
});