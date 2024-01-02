<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use PDOException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Report or log an exception.
     *
     * @param  Throwable $e
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  $request
     * @param  Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json($e->errors(), $e->status);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json(['message' => 'Model não encontrado'], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof BookStoreException) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof PDOException) {
            $message = [
                'message' => 'Ocorreu um erro inesperado ao registrar os dados',
            ];

            if (ENV('APP_DEBUG')) {
                $message['message'] = $e->getMessage();
            }
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e->getCode()) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return parent::render($request, $e);
    }
}
