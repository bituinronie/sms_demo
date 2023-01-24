<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Student\ProofOfPayment\IndexProofOfPaymentRequest,
    App\Http\Requests\Student\ProofOfPayment\CreateProofOfPaymentRequest,
    App\Http\Requests\Student\ProofOfPayment\UpdateProofOfPaymentRequest;


// * REPOSITORIES
use App\Repositories\Student\ProofOfPayment\IndexStudentProofOfPaymentRepository,
    App\Repositories\Student\ProofOfPayment\CreateStudentProofOfPaymentRepository,
    App\Repositories\Student\ProofOfPayment\UpdateStudentProofOfPaymentRepository;


class ProofOfPaymentStudentController extends Controller
{
    protected $index, $create, $update;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexStudentProofOfPaymentRepository  $index,
        CreateStudentProofOfPaymentRepository $create,
        UpdateStudentProofOfPaymentRepository $update,
    ){
        $this->index  = $index;
        $this->create = $create;
        $this->update = $update;
    }
    

    protected function index(IndexProofOfPaymentRequest $request) {
        return $this->index->execute(auth('student')->user()->applicant_id);
    }


    protected function create(CreateProofOfPaymentRequest $request) {
        return $this->create->execute($request);
    }


    protected function update(UpdateProofOfPaymentRequest $request, $paymentCode) {
        return $this->update->execute($request, $paymentCode);
    }
}
