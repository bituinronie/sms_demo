<?php

use App\Http\Controllers\Strand\StrandController;

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'strands'
], function ($route) {
    $route->get('/',                                     [StrandController::class, 'index']);
    $route->post('/create',                              [StrandController::class, 'create']);
    $route->get('/archive/list',                         [StrandController::class, 'list']);
    $route->get('/{branchCode}/{strandCode}',            [StrandController::class, 'show']);
    $route->put('/update/{branchCode}/{strandCode}',     [StrandController::class, 'update']);    
    $route->delete('/archive/{branchCode}/{strandCode}', [StrandController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{strandCode}',  [StrandController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{strandCode}',  [StrandController::class, 'delete']);
});
