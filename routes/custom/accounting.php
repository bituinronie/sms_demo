<?php

use App\Http\Controllers\Accounting\ProofOfPaymentController;

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'payments'
], function ($route) {
    $route->put('/status/update/{paymentCode}', [ProofOfPaymentController::class, 'statusUpdate']);

    $route->get('/',                         [ProofOfPaymentController::class, 'index']);
    $route->get('/archive/list',             [ProofOfPaymentController::class, 'list']);
    $route->delete('/archive/{paymentCode}', [ProofOfPaymentController::class, 'archive']);
    $route->patch('/restore/{paymentCode}',  [ProofOfPaymentController::class, 'restore']);
});