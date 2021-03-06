<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Test\Render;

use TVanC\Backtrace\Render\ExceptionRendererInterface;

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
     * Test the rendered frame for the expected info.
     *
     * @see ExceptionRendererInterface::renderFrame()
     */
    public function testRenderFrame();


    /**
     * Get the renderer implementation for this suite of tests.
     *
     * @return ExceptionRendererInterface
     */
    public function getRenderer(): ExceptionRendererInterface;
}
