<?php

use App\Http\Controllers\User\AuthUserController;


Route::group([
    'prefix' => 'accounts'
], function ($route) {
    $route->post('/login', [AuthUserController::class, 'login'])->name('login');
    $route->post('/refresh',[AuthUserController::class, 'refresh']);
});

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'accounts'
], function ($route) {
    $route->post('/logout',          [AuthUserController::class, 'logout']);
    $route->post('/change-password', [AuthUserController::class, 'changePassword']);
});