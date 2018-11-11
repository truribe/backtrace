<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Test\Error\Listener;

use PHPUnit\Framework\TestCase;
use TVanC\Backtrace\Error\Listener\ErrorListener;
use TVanC\Backtrace\Error\Listener\Exception\NoResponderException;
use TVanC\Backtrace\Test\Error\Responder\TestResponder;

/**
 * Tests ErrorListener
 *
 * @see ErrorListener
 */
class ErrorListenerTest extends TestCase
{
    /**
     * Test that the listener actually hears and delegates to the responder
     */
    public function testDelegation()
    {
        $errorListener     = $this->getListener(ErrorListener::TYPE_ERROR);
        $exceptionListener = $this->getListener(ErrorListener::TYPE_EXCEPTION);

        /** @var TestResponder $errorResponder */
        /** @var TestResponder $exceptionResponder */
        $errorResponder     = reset($errorListener->getResponders());
        $exceptionResponder = reset($exceptionListener->getResponders());

        $errorListener->handleError(\E_USER_ERROR, 'whatevs', 'any', 1);
        $exceptionListener->catchThrowable(new \ErrorException());

        $this->assertTrue($errorResponder->caughtThrowable());
        $this->assertTrue($exceptionResponder->caughtThrowable());
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
     * Test that the listener starts listening for the right things
     * according to the value passed to listen()
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
