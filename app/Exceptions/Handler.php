<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report an exception.
     *
     * The configured log channel can itself be the thing that is broken - an
     * unwritable storage/logs, a bad driver - in which case nothing is ever
     * recorded and the 500 arrives with no explanation. Writing straight to
     * stderr first guarantees the failure shows up in `railway logs` (or
     * `docker logs`) regardless of how logging is configured.
     *
     * @return void
     */
    public function report(Throwable $e)
    {
        if (! $this->shouldntReport($e)) {
            $this->writeToStderr($e);
        }

        parent::report($e);
    }

    /**
     * Write a compact, self-contained report of an exception to stderr.
     *
     * @return void
     */
    protected function writeToStderr(Throwable $e)
    {
        try {
            $lines = [];
            $lines[] = str_repeat('=', 72);
            $lines[] = '[APP ERROR] ' . now()->toIso8601String();

            if (php_sapi_name() !== 'cli') {
                $lines[] = 'Request : ' . Request::method() . ' ' . Request::fullUrl();
            }

            // Unwrap nested exceptions - the outermost one is rarely the cause.
            $depth = 0;
            for ($current = $e; $current !== null && $depth < 5; $current = $current->getPrevious(), $depth++) {
                $label = $depth === 0 ? 'Exception' : 'Previous ';
                $lines[] = $label . ': ' . get_class($current);
                $lines[] = 'Message  : ' . $current->getMessage();
                $lines[] = 'Origin   : ' . $current->getFile() . ':' . $current->getLine();
            }

            // Application frames only - vendor noise buries the real location.
            $appFrames = [];
            foreach ($e->getTrace() as $frame) {
                if (! isset($frame['file']) || str_contains($frame['file'], DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR)) {
                    continue;
                }
                $appFrames[] = '  at ' . $frame['file'] . ':' . ($frame['line'] ?? '?')
                    . ' ' . ($frame['class'] ?? '') . ($frame['type'] ?? '') . ($frame['function'] ?? '');
                if (count($appFrames) >= 15) {
                    break;
                }
            }

            if ($appFrames !== []) {
                $lines[] = 'App trace:';
                $lines = array_merge($lines, $appFrames);
            }

            $lines[] = str_repeat('=', 72);

            file_put_contents('php://stderr', implode(PHP_EOL, $lines) . PHP_EOL);
        } catch (Throwable $ignored) {
            // Never let diagnostics take the application down.
        }
    }
}
