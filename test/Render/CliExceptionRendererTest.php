<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Test\Render;

use tvanc\Backtrace\Render\CliExceptionRenderer;
use tvanc\Backtrace\Render\ExceptionRendererInterface;

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
