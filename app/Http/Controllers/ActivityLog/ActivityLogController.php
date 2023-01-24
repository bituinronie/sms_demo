<?php

namespace App\Http\Controllers\ActivityLog;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\ActivityLog\IndexActivityLogRequest;


// * REPOSITORIES
use App\Repositories\ActivityLog\IndexActivityLogRepository;

class ActivityLogController extends Controller
{
    protected $index;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexActivityLogRepository $index
    ){
        $this->index = $index;
    }


    protected function index(IndexActivityLogRequest $request) {
        return $this->index->execute();
    }
}