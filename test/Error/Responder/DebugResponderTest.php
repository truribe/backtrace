<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Test\Error\Responder;

use PHPUnit\Framework\TestCase;
use TVanC\Backtrace\Error\Responder\DebugResponder;
use TVanC\Backtrace\Test\Render\Mock\TestExceptionRenderer;

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
        $renderer  = new TestExceptionRenderer();
        $responder = new DebugResponder($renderer);

        $responder->catchThrowable(new \Exception('Testing'));

        $this->assertTrue($renderer->isRendered(), 'Renderer invoked');
    }
}
