<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Backtrace;
use tvanc\backtrace\Error\Listen\ErrorListenerInterface;

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
            $listener->getHandlers(), 'Has at least one handler'
        );
    }
}
