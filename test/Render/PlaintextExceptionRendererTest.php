<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Test\Render;

use TVanC\Backtrace\Render\ExceptionRendererInterface;
use TVanC\Backtrace\Render\PlaintextExceptionRenderer;

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
