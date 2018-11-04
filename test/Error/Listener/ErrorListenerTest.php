<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Listener;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Listener\ErrorListener;
use tvanc\backtrace\Error\Listener\Exception\NoResponderException;
use tvanc\backtrace\Test\Error\Responder\TestResponder;

/**
 * Tests ErrorListener
 *
 * @see ErrorListener
 */
class ErrorListenerTest extends TestCase
{
    /**
     *
     */
    public function testListeningTypes()
    {
        $errorListener     = $this->getListener(ErrorListener::TYPE_ERROR);
        $exceptionListener = $this->getListener(ErrorListener::TYPE_EXCEPTION);
        $shutdownListener  = $this->getListener(ErrorListener::TYPE_SHUTDOWN);

        $this->assertTrue($errorListener->isListeningForErrors());
        $this->assertFalse($errorListener->isListeningForExceptions());
        $this->assertFalse($errorListener->isListeningForShutdown());

        $this->assertFalse($exceptionListener->isListeningForErrors());
        $this->assertTrue($exceptionListener->isListeningForExceptions());
        $this->assertFalse($exceptionListener->isListeningForShutdown());

        $this->assertFalse($shutdownListener->isListeningForErrors());
        $this->assertFalse($shutdownListener->isListeningForExceptions());
        $this->assertTrue($shutdownListener->isListeningForShutdown());
    }


    /**
     * @param int $type
     *
     * @return TestErrorListener
     */
    private function getListener(int $type)
    {
        $responder = new TestResponder();
        $listener  = new TestErrorListener([
            $responder
        ], true);

        $listener->listen($type);

        return $listener;
    }


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
