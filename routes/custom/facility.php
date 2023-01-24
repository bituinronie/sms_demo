<?php

use App\Http\Controllers\Building\BuildingController,
    App\Http\Controllers\Room\RoomController,
    App\Http\Controllers\Laboratory\LaboratoryController;

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'buildings'
], function ($route) {
    $route->get('/',                                       [BuildingController::class, 'index']);
    $route->post('/create',                                [BuildingController::class, 'create']);
    $route->get('/archive/list',                           [BuildingController::class, 'list']);
    $route->get('/{branchCode}/{buildingCode}',            [BuildingController::class, 'show']);
    $route->put('/update/{branchCode}/{buildingCode}',     [BuildingController::class, 'update']);
    $route->delete('/archive/{branchCode}/{buildingCode}', [BuildingController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{buildingCode}',  [BuildingController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{buildingCode}',  [BuildingController::class, 'delete']);
});


Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'rooms'
], function ($route) {
    $route->get('/',                                   [RoomController::class, 'index']);
    $route->post('/create',                            [RoomController::class, 'create']);
    $route->get('/archive/list',                       [RoomController::class, 'list']);
    $route->get('/{branchCode}/{roomCode}',            [RoomController::class, 'show']);
    $route->put('/update/{branchCode}/{roomCode}',     [RoomController::class, 'update']);
    $route->delete('/archive/{branchCode}/{roomCode}', [RoomController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{roomCode}',  [RoomController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{roomCode}',  [RoomController::class, 'delete']);
});


Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'laboratories'
], function ($route) {
    $route->get('/',                                         [LaboratoryController::class, 'index']);
    $route->post('/create',                                  [LaboratoryController::class, 'create']);
    $route->get('/archive/list',                             [LaboratoryController::class, 'list']);
    $route->get('/{branchCode}/{laboratoryCode}',            [LaboratoryController::class, 'show']);
    $route->put('/update/{branchCode}/{laboratoryCode}',     [LaboratoryController::class, 'update']);
    $route->delete('/archive/{branchCode}/{laboratoryCode}', [LaboratoryController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{laboratoryCode}',  [LaboratoryController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{laboratoryCode}',  [LaboratoryController::class, 'delete']);
});