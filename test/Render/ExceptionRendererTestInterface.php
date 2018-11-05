<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use tvanc\backtrace\Render\ExceptionRendererInterface;

/**
 * Standard protocol for renderer tests.
 *
 * @see ExceptionRendererInterface
 * @see AbstractExceptionRendererTest
 */
interface ExceptionRendererTestInterface
{
    /**
     * Test the entire render output for the expected info.
     * So here you might check for things like the exception class,
     * file and line number being included in the output.
     *
     * @see ExceptionRendererInterface::render()
     */
    public function testRender();


    /**
     * Test the rendered stage for the expected info.
     *
     * @see ExceptionRendererInterface::renderStage()
     */
    public function testRenderStage();


    /**
     * Get the renderer implementation for this suite of tests.
     *
     * @return ExceptionRendererInterface
     */
    public function getRenderer(): ExceptionRendererInterface;
}
