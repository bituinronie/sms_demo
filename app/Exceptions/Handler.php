<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Tymon\JWTAuth\Exceptions\TokenBlacklistedException,
    Tymon\JWTAuth\Exceptions\TokenExpiredException,
    Tymon\JWTAuth\Exceptions\TokenInvalidException,
    Tymon\JWTAuth\Exceptions\JWTException,
    Illuminate\Auth\AuthenticationException,
    Illuminate\Database\QueryException,
    Exception,
    Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (TokenBlacklistedException $e) {
            return response()->json(
                [
                    'message'   =>  "Authentication Blocked",
                    'results'   =>  [],
                    'code'      =>  401,
                    'errors'    =>  true,
                ], 401);
        });

        $this->renderable(function (TokenExpiredException $e) {
            return response()->json(
                [
                    'message'   =>  "Authentication Expired",
                    'results'   =>  [],
                    'code'      =>  401,
                    'errors'    =>  true,
                ], 401);
        });

        $this->renderable(function (TokenInvalidException $e) {
            return response()->json(
                [
                    'message'   =>  "Authentication Invalid",
                    'results'   =>  [],
                    'code'      =>  401,
                    'errors'    =>  true,
                ], 401);
        });

        $this->renderable(function (JWTException $e) {
            return response()->json(
                [
                    'message'   =>  "Authentication Error",
                    'results'   =>  [],
                    'code'      =>  401,
                    'errors'    =>  true,
                ], 401);
        });

        $this->renderable(function (AuthenticationException $e) {
            return response()->json(
                [
                    'message'   =>  "Authentication Invalid",
                    'results'   =>  [],
                    'code'      =>  401,
                    'errors'    =>  true,
                ], 401);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return response()->json(
                [
                    'message'   =>  "Data not found, Please double check your data",
                    'results'   =>  [],
                    'code'      =>  404,
                    'errors'    =>  true,
                ], 404);
        });

        $this->renderable(function (QueryException $e) {
            return response()->json(
                [
                    'message'   =>  "Some data does not exist, Please double check your data",
                    'results'   =>  [],
                    'code'      =>  404,
                    'errors'    =>  true,
                ], 404);
        });

        $this->renderable(function (Exception $e) {
            return response()->json(
                [
                    'message'   =>  "Unexpected error please contact risseu@spcf.edu.ph",
                    'results'   =>  [],
                    'code'      =>  422,
                    'errors'    =>  true,
                ], 422);
        });
    }
}
