<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use tvanc\backtrace\Render\ExceptionRendererInterface;
use tvanc\backtrace\Render\PlaintextExceptionRenderer;

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
