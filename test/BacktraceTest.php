<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Backtrace;
use tvanc\backtrace\Error\Listener\ErrorListenerInterface;

/**
 * Class BacktraceTest
 */
final class BacktraceTest extends TestCase
{
    public function testEntryPoint()
    {
        $handler = Backtrace::createListener();

        $this->assertInstanceOf(ErrorListenerInterface::class, $handler);
    }
}
