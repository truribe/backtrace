<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use tvanc\backtrace\Render\ExceptionRendererInterface;
use tvanc\backtrace\Render\PlaintextExceptionRenderer;

/**
 * Test rendering exceptions in plaintext.
 */
class TestPlaintextExceptionRenderer extends AbstractExceptionRendererTest
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
