<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Handle;

use tvanc\backtrace\Render\ExceptionRendererInterface;

/**
 * A handler to aid in debugging errors by passing the errors to a renderer
 * and echoing its output.
 */
class DebugHandler implements ErrorHandlerInterface
{
    /**
     * @var ExceptionRendererInterface
     * The class to use to render throwables received by this class.
     */
    private $renderer;


    public function __construct(ExceptionRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }


    /**
     * Renders the thrown object - hopefully in a helpful way, though
     * ultimately that's up to the renderer.
     *
     * @param \Throwable $throwable
     *
     * @see ExceptionRendererInterface::render()
     */
    public function catchThrowable(\Throwable $throwable)
    {
        echo $this->renderer->render($throwable);
    }
}
