<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use NewsletterPluginApi\Exceptions\Repositories\ValidatorException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class
    ];

    /**
     * add exception not found
     *
     * @var array
     */
    protected $exceptionsNotFound = [
        NotFoundHttpException::class,
        ModelNotFoundException::class
    ];

    protected $exceptionsBadRequest = [
        BadRequest::class,
        ValidatorException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     *
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
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if (env('APP_DEBUG')) {
            return parent::render($request, $e);
        }

        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($e instanceof MethodNotAllowedHttpException) {
            $status = Response::HTTP_METHOD_NOT_ALLOWED;
            $e = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $e);

        } elseif ($this->isNotFoundException($e)) {
            $status = Response::HTTP_NOT_FOUND;
            $e = new NotFoundHttpException($e->getMessage() ?? 'HTTP_NOT_FOUND', $e);

        } elseif ($this->isBadRequestException($e)) {
            $status = Response::HTTP_BAD_REQUEST;
            $e = new HttpException($status, $e->getMessage());

        } elseif ($e instanceof AuthorizationException) {
            $status = Response::HTTP_FORBIDDEN;
            $e = new AuthorizationException('HTTP_FORBIDDEN', $status);

        } elseif ($e) {
            $e = new HttpException($status, 'HTTP_INTERNAL_SERVER_ERROR');
        }

        return response()->json([
            'success' => false,
            'status'  => $status,
            'message' => $e->getMessage()
        ], $status);

    }

    /**
     * Validate exception is type not found
     *
     * @param Throwable $e
     *
     * @return boolean
     */
    protected function isNotFoundException(Throwable $e)
    {
        return collect($this->exceptionsNotFound)->contains(
            $this->validateInstanceOf($e)
        );
    }

    /**
     * Validate exception is type BadRequest
     *
     * @param Throwable $e
     *
     * @return boolean
     */
    protected function isBadRequestException(Throwable $e)
    {
        return collect($this->exceptionsBadRequest)
            ->contains(
                $this->validateInstanceOf($e)
            );
    }

    /**
     *
     * @param Throwable $e
     *
     * @return \Closure
     */
    protected function validateInstanceOf(Throwable $e)
    {
        return function ($exceptionClass) use ($e) {
            return $e instanceof $exceptionClass;
        };
    }
}

