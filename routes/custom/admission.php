<?php

use App\Http\Controllers\Admission\ApplicantController,
    App\Http\Controllers\Admission\OnlineApplicantController;

Route::group([
    'prefix' => 'applicants/online'
], function ($route) {
    $route->get('/{branchCode?}/{type?}',[OnlineApplicantController::class, 'online']);
    $route->post('/create',              [OnlineApplicantController::class, 'create']);
    $route->get('/email/validation',     [OnlineApplicantController::class, 'emailValidation']);
});

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'applicants'
], function ($route) {
    $route->get('/feeder-school',                 [ApplicantController::class, 'feederSchool']);
    $route->get('/email/validation',              [ApplicantController::class, 'emailValidation']);
    $route->put('/email/update/{priorityNumber}', [ApplicantController::class, 'emailUpdate']);
    $route->put('/status/update/{priorityNumber}',[ApplicantController::class, 'statusUpdate']);

    $route->get('/',                           [ApplicantController::class, 'index']);
    $route->post('/create',                    [ApplicantController::class, 'create']);
    $route->get('/{priorityNumber}',           [ApplicantController::class, 'show']);
    $route->put('/update/{priorityNumber}',    [ApplicantController::class, 'update']);
    $route->get('/archive/list',               [ApplicantController::class, 'list']);
    $route->delete('/archive/{priorityNumber}',[ApplicantController::class, 'archive']);
    $route->patch('/restore/{priorityNumber}', [ApplicantController::class, 'restore']);
    $route->delete('/delete/{priorityNumber}', [ApplicantController::class, 'delete']);
});