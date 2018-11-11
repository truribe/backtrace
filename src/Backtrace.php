<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 * @copyright 2018 Travis Van Couvering
 * @license MIT
 */

namespace tvanc\Backtrace;

use tvanc\Backtrace\Environment\Environment;
use tvanc\Backtrace\Error\Listener\ErrorListener;
use tvanc\Backtrace\Error\Responder\DebugResponder;
use tvanc\Backtrace\Render\CliExceptionRenderer;
use tvanc\Backtrace\Render\EnvironmentAwareRenderer;
use tvanc\Backtrace\Render\HtmlExceptionRenderer;
use tvanc\Backtrace\Render\PlaintextExceptionRenderer;

/**
 * Provides convenience methods for interacting with this package.
 */
final class Backtrace
{
    public static function createListener()
    {
        $responder = new DebugResponder(new EnvironmentAwareRenderer(
            new Environment(),
            new CliExceptionRenderer(),
            new PlaintextExceptionRenderer(),
            new HtmlExceptionRenderer(
                realpath(__DIR__ . '/../view'),
                realpath(__DIR__ . '/../public/assets'),
                'throwable.php',
                'frame.php'
            )
        ));

        return new ErrorListener([$responder], true);
    }
}
