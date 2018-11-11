<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Test\Render\Mock;

use tvanc\Backtrace\Render\AbstractExceptionRenderer;
use tvanc\Backtrace\Render\ExceptionRendererInterface;

/**
 * A no-op class that satisfies test conditions.
 */
class TestExceptionRenderer extends AbstractExceptionRenderer implements ExceptionRendererInterface
{
    private $rendered = false;
    private $frameRendered = false;


    /**
     * Did render() get called?
     *
     * @return bool
     * True if yes, false if no.
     */
    public function isRendered(): bool
    {
        return $this->rendered;
    }


    /**
     * Use between assertions to pretend render() was never called. Or to
     * pretend it was. Whatever floats your boat.
     *
     * @param bool $rendered
     * @param bool $frameRendered
     *
     * @return TestExceptionRenderer
     */
    public function setRendered(
        bool $rendered,
        bool $frameRendered = null
    ): TestExceptionRenderer {
        $this->rendered = $rendered;

        if (isset($frameRendered)) {
            $this->frameRendered = $frameRendered;
        }

        return $this;
    }


    /**
     * Did renderFrame() get called?
     *
     * @return bool
     * True if yes, false if no.
     */
    public function isFrameRendered(): bool
    {
        return $this->frameRendered;
    }


    public function setFrameRendered(bool $frameRendered): TestExceptionRenderer
    {
        $this->frameRendered = $frameRendered;

        return $this;
    }


    /**
     * Don't actually render anything. Just set a flag so we know this
     * method was called.
     *
     * @param \Throwable $throwable
     *
     * @return string
     */
    public function render(\Throwable $throwable): string
    {
        $this->rendered = true;

        return '';
    }


    /**
     * Don't render anything. Just implementing to fulfill conditions.
     *
     * @param array $frame
     *
     * @return string
     */
    public function renderFrame(array $frame): string
    {
        $this->frameRendered = true;

        return '';
    }
}
