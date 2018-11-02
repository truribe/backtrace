<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Handler;

use tvanc\backtrace\Error\Responder\CliErrorResponder;
use tvanc\backtrace\Error\Responder\ErrorResponderInterface;
use tvanc\backtrace\Test\Environment\TestCliInfoProvider;
use tvanc\backtrace\Test\Error\Handler\Exception\ExampleException;

/**
 * Class ErrorHandlerTest
 */
class CliErrorHandlerTest extends AbstractHandlerTest
{
    const ARBITRARY_KNOWN_WIDTH = 40;
    const SEPARATOR = '-';


    public function testCatchThrowable()
    {
        // Get a CliErrorHandler with a mock CliInfoProvider
        $handler = $this->getHandler();

        $message = '<|TESTING|>';
        $separator = preg_quote(str_pad(
            '',
            self::ARBITRARY_KNOWN_WIDTH,
            self::SEPARATOR,
            \STR_PAD_RIGHT
        ));

        // We expect to see the separator, a new line, then our message
        $regex = '/' . $separator . '\n' . \preg_quote($message) . '/';

        $this->expectOutputRegex($regex);

        $handler->handleException(new ExampleException($message));
    }


    /**
     * TODO Finish this test
     */
    public function testHandleError()
    {
        $handler = $this->getHandler();

        $message = '<|BLARP|>';
    }


    /**
     * @return CliErrorResponder
     * A CliErrorHandler with a TestCliInfoProvider that returns a static
     * arbitrary width.
     */
    public function getHandler(): ErrorResponderInterface
    {
        return new CliErrorResponder(
            new TestCliInfoProvider(self::ARBITRARY_KNOWN_WIDTH)
        );
    }
}
