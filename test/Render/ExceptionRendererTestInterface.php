<?php
/**
 * TODO Add @file block for ExceptionRendererTestInterface.php
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use tvanc\backtrace\Render\ExceptionRendererInterface;

/**
 * TODO Document class RendererTestInterface
 */
interface ExceptionRendererTestInterface
{
    /**
     * @see ExceptionRendererInterface::render()
     */
    public function testRender();


    /**
     * @see ExceptionRendererInterface::renderStage()
     */
    public function testRenderStage();


    /**
     * @return ExceptionRendererInterface
     */
    public function getRenderer(): ExceptionRendererInterface;
}
