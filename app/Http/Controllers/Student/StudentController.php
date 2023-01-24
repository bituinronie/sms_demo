<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

// ** REQUEST
use App\Http\Requests\Student\ShowStudentRequest;


// ** REPOSITORIES
use App\Repositories\Student\ShowStudentRepository;


class StudentController extends Controller
{
    protected $show;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        ShowStudentRepository $show
    ) {
        $this->show = $show;
    }

    protected function show(ShowStudentRequest $request) {
        return $this->show->execute();
    }
}