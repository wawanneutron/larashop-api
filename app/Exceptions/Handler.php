<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */


    public function render($request, Throwable $exception)
    {
        // baca konfigurasi apakah aplikasi menggunakan mode production atau development
        $debug = config('app.debug');
        $message = '';
        $status_code = 500;

        // cek jika eksepsinya dikarenakan model tidak ditemukan
        if ($exception instanceof ModelNotFoundException) {
            $message = 'Resource is not found';
            $status_code = 404;
        }
        // cek jika eksepsinya dikarenakan resource tidak ditemukan
        if ($exception instanceof NotFoundHttpException) {
            $message = 'Endpoint is not found';
            $status_code = 404;
        }
        // cek jika eksepsinya dikarenakan method tidak diizinkan
        else if ($exception instanceof MethodNotAllowedHttpException) {
            $message = 'Method is not allowed';
            $status_code = 405;
        }
        // cek jika eksepsinya dikarenakan kegagalan validasi
        else if ($exception instanceof ValidationException) {
            $validationErrors = $exception->validator->errors()->getMessages();
            $validationErrors = array_map(function ($error) {
                return array_map(function ($message) {
                    return $message;
                }, $error);
            }, $validationErrors);
            $message = $validationErrors;
            $status_code = 405;
        }
        // cek jika eksepsinya dikarenakan kegagalan query
        else if ($exception instanceof QueryException) {
            if ($debug) {
                $message = $exception->getMessage();
            } else {
                $message = 'Query failed to execute';
            }
            $status_code = 500;
        }
        $rendered = parent::render($request, $exception);
        $status_code = $rendered->getStatusCode();
        if (empty($message)) {
            $message = $exception->getMessage();
        }
        $errors = [];
        if ($debug) {
            $errors['exception'] = get_class($exception);
            $errors['trace'] = explode("\n", $exception->getTraceAsString());
        }
        return response()->json([
            'status' => 'error',
            'status_code' => $status_code,
            'message' => $message,
            'data' => null,
        ], $status_code);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthenticate',
            'data' => null,
        ], 401);
    }
}
