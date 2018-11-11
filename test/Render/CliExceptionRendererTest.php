<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Test\Render;

use TVanC\Backtrace\Render\CliExceptionRenderer;
use TVanC\Backtrace\Render\ExceptionRendererInterface;

/**
 * A test case to verify that exceptions rendered for CLI output are rendered
 * correctly.
 */
class CliExceptionRendererTest extends AbstractExceptionRendererTest
{
    /**
     * Get the renderer implementation for this suite of tests.
     *
     * @return ExceptionRendererInterface
     */
    public function getRenderer(): ExceptionRendererInterface
    {
        return new CliExceptionRenderer();
    }
}
