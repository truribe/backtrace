<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Listener;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Responder\ErrorResponderInterface;
use tvanc\backtrace\Error\Listener\ErrorListener;
use tvanc\backtrace\Error\Listener\Exception\UnhandledErrorException;
use tvanc\backtrace\Error\Listener\Exception\UnhandledExceptionException;

/**
 * Class ErrorListenerTest
 */
class ErrorListenerTest extends TestCase
{
    /**
     * Verify listener throws a special exception if it hears an error and has
     * no associated handlers.
     */
    public function testUnhandledError()
    {
        $listener = new ErrorListener([], false);

        $listener->listenForErrors();

        $this->expectException(UnhandledErrorException::class);

        trigger_error('Testing', E_USER_NOTICE);
    }


    /**
     * Verify listener throws a special exception if it hears an exception and
     * has no associated handlers.
     *
     * @throws UnhandledExceptionException
     */
    public function testUnhandledException()
    {
        // Create listener without handlers
        $listener = new ErrorListener([], false);

        $this->expectException(UnhandledExceptionException::class);

        $listener->catchThrowable(new \Exception(
            'Thrown an Exception; landed an UnhandledExceptionException'
        ));
    }


    /**
     * Verify errors are passed back to PHP when override is disabled.
     *
     * Tested separately from the effects of enabling override to sidestep
     * awkwardness of testing a single output buffer for mutually contradictory
     * results.
     *
     * @see testOverrideOn()
     */
    public function testOverrideOff()
    {
        // Create listener with override enabled and noop handler
        $listener = new ErrorListener([
            $this->createMock(ErrorResponderInterface::class)
        ], false);

        // Register the error handler
        $listener->listenForErrors();

        $message = 'This error should go to native error handler.';
        $this->expectOutputRegex("/Warning: $message/");
        trigger_error($message, E_USER_WARNING);
    }


    /**
     * Verify that errors are NOT passed back to PHP when override is enabled.
     *
     * Tested separately from the effects of disabling override to sidestep
     * awkwardness of testing a single output buffer for mutually contradictory
     * results.
     *
     * @see testOverrideOff()
     * @see ErrorListener::override
     */
    public function testOverrideOn()
    {
        // Create listener with override enabled and noop handler
        $listener = new ErrorListener([
            $this->createMock(ErrorResponderInterface::class)
        ], true);

        // Register the error handler
        $listener->listenForErrors();

        $message = 'This error should NOT go to native error handler.';
        $this->expectOutputString('');
        trigger_error($message, E_USER_WARNING);
    }
}
