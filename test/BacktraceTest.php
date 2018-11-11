<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Test;

use PHPUnit\Framework\TestCase;
use tvanc\Backtrace\Backtrace;
use tvanc\Backtrace\Error\Listener\ErrorListenerInterface;

/**
 * Test of the Backtrace class, which doesn't actually do a whole lot.
 */
final class BacktraceTest extends TestCase
{
    public function testCreateListener()
    {
        $listener = Backtrace::createListener();

        $this->assertInstanceOf(ErrorListenerInterface::class, $listener);

        $this->assertNotEmpty(
            $listener->getResponders(), 'Has at least one responder'
        );
    }
}
