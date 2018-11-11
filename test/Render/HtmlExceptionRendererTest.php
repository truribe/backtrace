<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Test\Render;

use TVanC\Backtrace\Render\ExceptionRendererInterface;
use TVanC\Backtrace\Render\HtmlExceptionRenderer;

/**
 * Test for HtmlExceptionRenderer. Tests are actually defined in the parent
 * class.
 *
 * @see AbstractExceptionRendererTest
 * @see HtmlExceptionRenderer
 */
class HtmlExceptionRendererTest extends AbstractExceptionRendererTest
{
    /**
     * @return ExceptionRendererInterface
     */
    public function getRenderer(): ExceptionRendererInterface
    {
        return new HtmlExceptionRenderer(
            realpath(__DIR__ . '/../../view'),
            realpath(__DIR__ . '/../../public/assets'),
            'throwable.php',
            'frame.php'
        );
    }
}
