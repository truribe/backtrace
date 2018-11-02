<?php
/**
 * @author Travis Raymond Uribe <turibe@rentecdirect.com>
 * @copyright 2018 Rentec Direct
 * @license Proprietary
 */

namespace tvanc\backtrace;

use tvanc\backtrace\Environment\CliInfoProvider;
use tvanc\backtrace\Environment\Environment;
use tvanc\backtrace\Error\Handle\DebugHandler;
use tvanc\backtrace\Error\Listen\ErrorListener;
use tvanc\backtrace\Render\CliExceptionRenderer;
use tvanc\backtrace\Render\EnvironmentAwareRenderer;
use tvanc\backtrace\Render\HtmlExceptionRenderer;
use tvanc\backtrace\Render\PlaintextExceptionRenderer;

/**
 * Provides convenience methods for interacting with this package.
 */
final class Backtrace
{
    /**
     * @param \Throwable $throwable
     * @param bool       $shorten
     *
     * @return string
     */
    static function getErrorType($throwable, $shorten = true)
    {
        if ($throwable instanceof \ErrorException) {
            $severity = $throwable->getSeverity();

            $typeNameMap = [
                E_ERROR             => 'Fatal error',
                E_PARSE             => 'Parse error',
                E_CORE_ERROR        => 'Core error',
                E_COMPILE_ERROR     => 'Compile error',
                E_USER_ERROR        => 'User error',
                E_NOTICE            => 'Notice',
                E_DEPRECATED        => 'Deprecated',
                E_USER_NOTICE       => 'User notice',
                E_WARNING           => 'Warning',
                E_USER_WARNING      => 'User warning',
                E_CORE_WARNING      => 'Core warning',
                E_COMPILE_WARNING   => 'Compile warning',
                E_STRICT            => 'Strict message',
                E_RECOVERABLE_ERROR => 'Recoverable error',
                E_USER_DEPRECATED   => 'Deprecated',
            ];

            return $typeNameMap[$severity];
        }

        if ($shorten) {
            try {
                $reflection = new \ReflectionClass($throwable);

                return $reflection->getShortName();
            }
            catch (\Exception $exception) {
                // If exception is thrown just return the plain ol' FQCN
            }
        }

        return get_class($throwable);
    }


    public static function createListener()
    {
        $handler = new DebugHandler(new EnvironmentAwareRenderer(
            new Environment(),
            new CliExceptionRenderer(new CliInfoProvider()),
            new PlaintextExceptionRenderer(),
            new HtmlExceptionRenderer(
                realpath(__DIR__ . '/../view'),
                realpath(__DIR__ . '/../public/assets'),
                'throwable.php',
                'stage.php'
            )
        ));

        return new ErrorListener([$handler], true);
    }
}
