<?php namespace App\Exceptions;

use App\Traits\ResponsableApi;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    use ResponsableApi;

    protected $httpExceptionsFiltered = [
        ModelNotFoundException::class    => 'respondNotFound',
        UnauthorizedHttpException::class => 'respondUnauthorized',
        FatalThrowableError::class       => 'respondInternalError',
    ];

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson() && $renderException = $this->searchException($exception)) {
            return $renderException;
        }

        return parent::render($request, $exception);
    }

    /**
     * @param Exception $exception
     * @return mixed
     */
    private function searchException($exception)
    {
        $exceptionClassName = get_class($exception);
        if (array_key_exists($exceptionClassName, $this->httpExceptionsFiltered)) {
            return $this->{$this->httpExceptionsFiltered[$exceptionClassName]}();
        }
    }
}