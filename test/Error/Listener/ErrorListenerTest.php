<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Listener;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Listener\ErrorListener;
use tvanc\backtrace\Error\Listener\Exception\NoResponderException;
use tvanc\backtrace\Error\Responder\ErrorResponderInterface;

/**
 * Tests ErrorListener
 *
 * @see ErrorListener
 */
class ErrorListenerTest extends TestCase
{
    /**
     * Verify listener throws a special exception if it hears an exception and
     * has no associated responders.
     *
     * @throws NoResponderException
     */
    public function testUnhandledException()
    {
        // Create listener without responders
        $listener = new ErrorListener([], false);

        $this->expectException(NoResponderException::class);

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
        // Create listener with override enabled and noop responder
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
        // Create listener with override enabled and noop responder
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
