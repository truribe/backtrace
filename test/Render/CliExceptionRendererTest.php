<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use tvanc\backtrace\Render\CliExceptionRenderer;
use tvanc\backtrace\Render\ExceptionRendererInterface;

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
