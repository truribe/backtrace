<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use tvanc\backtrace\Render\CliExceptionRenderer;
use tvanc\backtrace\Render\ExceptionRendererInterface;
use tvanc\backtrace\Test\Environment\TestCliInfoProvider;

/**
 * Tests for CLI-formatted renders.
 *
 * @see CliExceptionRenderer
 */
class CliExceptionRendererTest extends AbstractExceptionRendererTest
{
    /**
     * @return ExceptionRendererInterface
     */
    public function getRenderer(): ExceptionRendererInterface
    {
        return new CliExceptionRenderer(
            new TestCliInfoProvider(42)
        );
    }
}
