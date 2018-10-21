<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Handle;

use tvanc\backtrace\Error\Handle\CliErrorHandler;
use tvanc\backtrace\Error\Handle\ErrorHandlerInterface;
use tvanc\backtrace\Test\Error\Handle\Exception\ExampleException;
use tvanc\backtrace\Utility\CliInfoProvider;

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

        $handler->catchThrowable(new ExampleException($message));
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
     * @return CliErrorHandler
     * A CliErrorHandler with a mock CliContextInfo that returns a static
     * arbitrary width.
     */
    public function getHandler(): ErrorHandlerInterface
    {
        /** @var CliInfoProvider $stub */
        $stub = $this->createMock(CliInfoProvider::class);
        $stub
            ->method('getConsoleWidth')
            ->willReturn(self::ARBITRARY_KNOWN_WIDTH);

        return new CliErrorHandler($stub);
    }
}
