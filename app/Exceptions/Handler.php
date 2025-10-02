<?php

namespace App\Exceptions;

use App\Http\Helpers\Http;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use function App\Http\Helpers\responseFail;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return responseFail($e->getStatusCode(), __('messages.No data found'));
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): mixed
    {
        if ($e instanceof TokenExpiredException) {
            return responseFail(Http::UNAUTHORIZED, 'messages.Token expired');
        }
        if ($e instanceof TokenBlacklistedException) {
            return responseFail(Http::UNAUTHORIZED, 'messages.Token blacklisted');
        }
        if ($e instanceof TokenInvalidException) {
            return responseFail(Http::UNAUTHORIZED, 'messages.Token invalid');
        }
        if ($e instanceof JWTException) {
            return responseFail(Http::UNAUTHORIZED, 'messages.JWT error');
        }
        if ($e instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                return responseFail(Http::UNAUTHORIZED, 'messages.Unauthenticated');
            } else {
                return redirect()->route('auth.login');
            }
        }if($e instanceof ModelNotFoundException){
            return responseFail(Http::NOT_FOUND, 'messages.Model not found');
        }


        return parent::render($request, $e);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->all();
        if ($this->isFrontend($request)) {
            return $request->ajax() ? response()->json($errors, Http::UNPROCESSABLE_ENTITY) : redirect()->back()->withInput()->withErrors($errors);
        }

        return responseFail(Http::BAD_REQUEST, 'messages.Validation error', $errors);
    }

    private function isFrontend($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
