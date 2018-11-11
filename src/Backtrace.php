<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 * @copyright 2018 Travis Van Couvering
 * @license MIT
 */

namespace TVanC\Backtrace;

use TVanC\Backtrace\Environment\Environment;
use TVanC\Backtrace\Error\Listener\ErrorListener;
use TVanC\Backtrace\Error\Responder\DebugResponder;
use TVanC\Backtrace\Render\CliExceptionRenderer;
use TVanC\Backtrace\Render\EnvironmentAwareRenderer;
use TVanC\Backtrace\Render\HtmlExceptionRenderer;
use TVanC\Backtrace\Render\PlaintextExceptionRenderer;

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
