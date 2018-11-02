<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Responder;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Responder\DebugResponder;
use tvanc\backtrace\Test\Render\TestRenderer;

/**
 * Covers DebugResponder
 *
 * @see DebugResponder
 */
class DebugResponderTest extends TestCase
{
    /**
     * Verify that DebugResponder::catchThrowable invokes its renderer
     * correctly.
     *
     * @see DebugResponder::catchThrowable()
     */
    public function testCatchThrowable()
    {
        $renderer  = new TestRenderer();
        $responder = new DebugResponder($renderer);

        $responder->catchThrowable(new \Exception('Testing'));

        $this->assertTrue($renderer->isRendered(), 'Renderer invoked');
    }
}
