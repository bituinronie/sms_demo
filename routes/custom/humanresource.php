<?php

use App\Http\Controllers\Employee\EmployeeController;

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'employees'
], function ($route) {
    $route->get('/',                            [EmployeeController::class, 'index']);
    $route->post('/create',                     [EmployeeController::class, 'create']);
    $route->get('/{employeeNumber}',            [EmployeeController::class, 'show']);
    $route->put('/update/{employeeNumber}',     [EmployeeController::class, 'update']);
    $route->get('/archive/list',                [EmployeeController::class, 'list']);
    $route->delete('/archive/{employeeNumber}', [EmployeeController::class, 'archive']);
    $route->patch('/restore/{employeeNumber}',  [EmployeeController::class, 'restore']);
});