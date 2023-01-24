<?php

use App\Http\Controllers\Program\ProgramController,
    App\Http\Controllers\Subject\SubjectController,
    App\Http\Controllers\Curriculum\CurriculumController,
    App\Http\Controllers\Section\SectionController,
    App\Http\Controllers\Schedule\ScheduleController;

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'programs'
], function ($route) {
    $route->get('/',                                      [ProgramController::class, 'index']);
    $route->post('/create',                               [ProgramController::class, 'create']);
    $route->get('/archive/list',                          [ProgramController::class, 'list']);
    $route->get('/{branchCode}/{programCode}',            [ProgramController::class, 'show']);
    $route->put('/update/{branchCode}/{programCode}',     [ProgramController::class, 'update']);    
    $route->delete('/archive/{branchCode}/{programCode}', [ProgramController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{programCode}',  [ProgramController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{programCode}',  [ProgramController::class, 'delete']);
});

Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'subjects'
], function ($route) {
    $route->get('/',                                      [SubjectController::class, 'index']);
    $route->post('/create',                               [SubjectController::class, 'create']);
    $route->get('/archive/list',                          [SubjectController::class, 'list']);
    $route->get('/{branchCode}/{subjectCode}',            [SubjectController::class, 'show']);
    $route->put('/update/{branchCode}/{subjectCode}',     [SubjectController::class, 'update']);    
    $route->delete('/archive/{branchCode}/{subjectCode}', [SubjectController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{subjectCode}',  [SubjectController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{subjectCode}',  [SubjectController::class, 'delete']);
});


Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'curriculums'
], function ($route) {
    $route->get('/code/validation',                          [CurriculumController::class, 'codeValidation']);
    $route->put('/code/update/{branchCode}/{curriculumCode}',[CurriculumController::class, 'codeUpdate']);

    $route->get('/',                                         [CurriculumController::class, 'index']);
    $route->post('/create',                                  [CurriculumController::class, 'create']);
    $route->get('/archive/list',                             [CurriculumController::class, 'list']);
    $route->get('/{branchCode}/{curriculumCode}',            [CurriculumController::class, 'show']);
    $route->put('/update/{branchCode}/{curriculumCode}',     [CurriculumController::class, 'update']);
    $route->delete('/archive/{branchCode}/{curriculumCode}', [CurriculumController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{curriculumCode}',  [CurriculumController::class, 'restore']);
});


Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'sections'
], function ($route) {
    $route->get('/schedule/{branchCode}/{sectionCode}',   [SectionController::class, 'sectionSchedule']);

    $route->get('/',                                      [SectionController::class, 'index']);
    $route->post('/create',                               [SectionController::class, 'create']);
    $route->get('/archive/list',                          [SectionController::class, 'list']);
    $route->get('/{branchCode}/{sectionCode}',            [SectionController::class, 'show']);
    $route->put('/update/{branchCode}/{sectionCode}',     [SectionController::class, 'update']);
    $route->delete('/archive/{branchCode}/{sectionCode}', [SectionController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{sectionCode}',  [SectionController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{sectionCode}',  [SectionController::class, 'delete']);
});


Route::group([
    'middleware' => 'auth:user',
    'prefix'     => 'schedules'
], function ($route) {
    $route->post('/validation',                           [ScheduleController::class, 'scheduleValidation']);

    $route->get('/',                                      [ScheduleController::class, 'index']);
    $route->post('/create',                               [ScheduleController::class, 'create']);
    $route->get('/archive/list',                          [ScheduleController::class, 'list']);
    $route->get('/{branchCode}/{scheduleCode}',           [ScheduleController::class, 'show']);
    $route->put('/update/{branchCode}/{scheduleCode}',    [ScheduleController::class, 'update']);
    $route->delete('/archive/{branchCode}/{scheduleCode}',[ScheduleController::class, 'archive']);
    $route->patch('/restore/{branchCode}/{scheduleCode}', [ScheduleController::class, 'restore']);
    $route->delete('/delete/{branchCode}/{scheduleCode}', [ScheduleController::class, 'delete']);
});
