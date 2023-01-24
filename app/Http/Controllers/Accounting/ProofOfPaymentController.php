<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Accounting\ProofOfPayment\IndexProofOfPaymentRequest,
    App\Http\Requests\Accounting\ProofOfPayment\ListProofOfPaymentRequest,
    App\Http\Requests\Accounting\ProofOfPayment\ArchiveProofOfPaymentRequest,
    App\Http\Requests\Accounting\ProofOfPayment\RestoreProofOfPaymentRequest,
    App\Http\Requests\Accounting\ProofOfPayment\Miscellaneous\StatusProofOfPaymentRequest;


// * REPOSITORIES
use App\Repositories\Accounting\ProofOfPayment\IndexProofOfPaymentRepository,
    App\Repositories\Accounting\ProofOfPayment\ListProofOfPaymentRepository,
    App\Repositories\Accounting\ProofOfPayment\ArchiveProofOfPaymentRepository,
    App\Repositories\Accounting\ProofOfPayment\RestoreProofOfPaymentRepository,
    App\Repositories\Accounting\ProofOfPayment\Miscellaneous\StatusProofOfPaymentRepository;

class ProofOfPaymentController extends Controller
{
    
    protected $index, $list, $archive, $restore, $statusUpdate;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexProofOfPaymentRepository   $index,
        ListProofOfPaymentRepository    $list,
        ArchiveProofOfPaymentRepository $archive,
        RestoreProofOfPaymentRepository $restore,
        StatusProofOfPaymentRepository  $statusUpdate
    ){
        $this->index        = $index;
        $this->list         = $list;
        $this->archive      = $archive;
        $this->restore      = $restore;
        $this->statusUpdate = $statusUpdate;
    }


    protected function index(IndexProofOfPaymentRequest $request) {
        return $this->index->execute();
    }


    protected function list(ListProofOfPaymentRequest $request){
        return $this->list->execute();
    }


    protected function archive(ArchiveProofOfPaymentRequest $request, $paymentCode){
        return $this->archive->execute($paymentCode);
    }
 

    protected function restore(RestoreProofOfPaymentRequest $request, $paymentCode){
        return $this->restore->execute($paymentCode);
    }

    
    protected function statusUpdate(StatusProofOfPaymentRequest $request, $paymentCode) {
        return $this->statusUpdate->execute($request, $paymentCode);
    }
}
