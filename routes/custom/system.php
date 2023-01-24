<?php

use App\Http\Controllers\Branch\BranchController,
    App\Http\Controllers\ActivityLog\ActivityLogController;

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'branches'
], function ($route) {
    $route->get('/',                        [BranchController::class, 'index']);
    $route->post('/create',                 [BranchController::class, 'create']);
    $route->get('/{branchCode}',            [BranchController::class, 'show']);
    $route->put('/update/{branchCode}',     [BranchController::class, 'update']);
    $route->get('/archive/list',            [BranchController::class, 'list']);
    $route->delete('/archive/{branchCode}', [BranchController::class, 'archive']);
    $route->patch('/restore/{branchCode}',  [BranchController::class, 'restore']);
    $route->delete('/delete/{branchCode}',  [BranchController::class, 'delete']);
});

Route::group([
    'middleware' => 'auth:user,student',
    'prefix'     => 'activity-logs'
], function ($route) {
    $route->get('/', [ActivityLogController::class, 'index']);
});
