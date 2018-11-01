<?php
/**
 * TODO Add @file block for DebugHandler.php
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Handle;

use tvanc\backtrace\Render\ExceptionRendererInterface;

/**
 * TODO Document class DebugHandler
 */
class DebugHandler implements ErrorHandlerInterface
{
    /**
     * @var ExceptionRendererInterface
     */
    private $renderer;


    public function __construct(ExceptionRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }


    /**
     * @param \Throwable $throwable
     *
     * @return mixed
     */
    public function catchThrowable(\Throwable $throwable)
    {
        echo $this->renderer->render($throwable);
    }
}
