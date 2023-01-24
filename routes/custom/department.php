<?php

use App\Http\Controllers\Department\DepartmentController,
    App\Http\Controllers\InformationTechnologyServices\InformationTechnologyServicesController;

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'departments'
], function ($route) {
    $route->get('/',                                         [DepartmentController::class, 'index']);
    $route->post('/create',                                  [DepartmentController::class, 'create']);
    $route->get('/archive/list',                             [DepartmentController::class, 'list']);
    $route->get('/{branchCode}/{departmentCode}',            [DepartmentController::class, 'show']);
    $route->put('/update/{branchCode}/{departmentCode}',     [DepartmentController::class, 'update']);
    $route->delete('/archive/{branchCode}/{departmentCode}', [DepartmentController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{departmentCode}',  [DepartmentController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{departmentCode}',  [DepartmentController::class, 'delete']);
});



Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'information-technology-services/account/user'
], function ($route) {
    $route->get('/',                            [InformationTechnologyServicesController::class, 'indexUserAccount']);
    $route->get('/archive/list',                [InformationTechnologyServicesController::class, 'listUserAccount']);
    $route->delete('/archive/{employeeNumber}', [InformationTechnologyServicesController::class, 'archiveUserAccount']);
    $route->patch('/restore/{employeeNumber}',  [InformationTechnologyServicesController::class, 'restoreUserAccount']);
    $route->post('/register',                   [InformationTechnologyServicesController::class, 'registerUserAccount']);
    $route->get('/reset/{employeeNumber}',      [InformationTechnologyServicesController::class, 'resetPasswordUserAccount']);
});


Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'information-technology-services/account/student'
], function ($route) {
    $route->get('/',                           [InformationTechnologyServicesController::class, 'indexStudentAccount']);
    $route->get('/archive/list',               [InformationTechnologyServicesController::class, 'listStudentAccount']);
    $route->delete('/archive/{studentNumber}', [InformationTechnologyServicesController::class, 'archiveStudentAccount']);
    $route->patch('/restore/{studentNumber}',  [InformationTechnologyServicesController::class, 'restoreStudentAccount']);
    $route->post('/register',                  [InformationTechnologyServicesController::class, 'registerStudentAccount']);
    $route->get('/reset/{studentNumber}',      [InformationTechnologyServicesController::class, 'resetPasswordStudentAccount']);
});