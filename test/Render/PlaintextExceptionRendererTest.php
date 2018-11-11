<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Test\Render;

use tvanc\Backtrace\Render\ExceptionRendererInterface;
use tvanc\Backtrace\Render\PlaintextExceptionRenderer;

/**
 * Test formatting of plaintext exception rendering
 */
class PlaintextExceptionRendererTest extends AbstractExceptionRendererTest
{
    /**
     * Get the renderer implementation for this suite of tests.
     *
     * @return ExceptionRendererInterface
     */
    public function getRenderer(): ExceptionRendererInterface
    {
        return new PlaintextExceptionRenderer();
    }
}
