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
use tvanc\backtrace\Error\Listener\ErrorListener;
use tvanc\backtrace\Render\CliExceptionRenderer;
use tvanc\backtrace\Render\EnvironmentAwareRenderer;
use tvanc\backtrace\Render\HtmlExceptionRenderer;
use tvanc\backtrace\Render\PlaintextExceptionRenderer;

/**
 * Provides convenience methods for interacting with this package.
 */
final class Backtrace
{
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
