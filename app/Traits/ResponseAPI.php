<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

trait ResponseAPI
{

    private function coreResponse($message, $statusCode, $data = [], $isSuccess = true){

        if(!$message) return response()->json([ 'message' => 'Message is required.' ], 500);

        if($isSuccess) {
            return response()->json([
                'message' => $message,
                'results' => $data,
                'code'    => $statusCode,
                'error'   => false
            ], $statusCode);
        } else {
            return response()->json([
                'message' => $message,
                'results' => [],
                'code'    => $statusCode,
                'error'   => true
            ], $statusCode);
        }
    }

  
    protected function success($message, $data, $statusCode = 200){

        return $this->coreResponse($message, $statusCode, $data);
    }

   
    protected function error($message, $statusCode = 500){
        
        return $this->coreResponse($message, $statusCode, null, false);
    }
}
