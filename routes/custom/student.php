<?php

use App\Http\Controllers\Student\AuthStudentController,
    App\Http\Controllers\Student\StudentController,
    App\Http\Controllers\Student\ProofOfPaymentStudentController;

Route::group([
    'prefix' => 'portal/accounts'
], function ($route) {
    $route->post('/login',   [AuthStudentController::class, 'login']);
    $route->post('/refresh', [AuthStudentController::class, 'refresh']);
});

Route::group([
    'middleware' => 'auth:student',
    'prefix'     => 'portal/accounts'
], function ($route) {
    $route->get('/',                 [StudentController::class, 'show']);
    $route->post('/logout',          [AuthStudentController::class, 'logout']);
    $route->post('/change-password', [AuthStudentController::class, 'changePassword']);
});

Route::group([
    'middleware' => 'auth:student',
    'prefix'     => 'portal/payments'
], function ($route) {
    $route->get('/',             [ProofOfPaymentStudentController::class, 'index']);
    $route->post('/create',      [ProofOfPaymentStudentController::class, 'create']);
    $route->put('/update/{paymentCode}',  [ProofOfPaymentStudentController::class, 'update']);
});