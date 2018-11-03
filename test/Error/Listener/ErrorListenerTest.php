<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Listener;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Listener\ErrorListener;
use tvanc\backtrace\Error\Listener\Exception\NoResponderException;

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
    public function testNoResponders()
    {
        // Create listener without responders
        $listener = new ErrorListener([], false);

        $this->expectException(NoResponderException::class);

        $listener->catchThrowable(new \Exception(
            'Thrown an Exception; landed an UnhandledExceptionException'
        ));
    }
}
