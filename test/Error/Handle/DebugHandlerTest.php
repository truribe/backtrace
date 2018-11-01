<?php
/**
 * TODO Add @file block for DebugHandlerTest.php
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Handle;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Handle\DebugHandler;
use tvanc\backtrace\Test\Render\TestRenderer;

/**
 * Covers DebugHandler
 *
 * @see DebugHandler
 */
class DebugHandlerTest extends TestCase
{
    /**
     * Verify that DebugHandler::catchThrowable invokes its renderer correctly.
     *
     * @see DebugHandler::catchThrowable()
     */
    public function testCatchThrowable()
    {
        $renderer = new TestRenderer();
        $handler  = new DebugHandler($renderer);

        $handler->catchThrowable(new \Exception('Testing'));

        $this->assertTrue($renderer->isRendered(), 'Renderer invoked');
    }
}
