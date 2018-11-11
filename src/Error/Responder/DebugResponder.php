<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Error\Responder;

use TVanC\Backtrace\Render\ExceptionRendererInterface;

/**
 * A responder to aid in debugging errors by passing the errors to a renderer
 * and echoing its output.
 */
class DebugResponder implements ErrorResponderInterface
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
