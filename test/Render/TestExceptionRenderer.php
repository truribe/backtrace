<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use tvanc\backtrace\Render\AbstractExceptionRenderer;
use tvanc\backtrace\Render\ExceptionRendererInterface;

/**
 * A no-op class that satisfies test conditions.
 */
class TestExceptionRenderer extends AbstractExceptionRenderer implements ExceptionRendererInterface
{
    private $rendered = false;
    private $stageRendered = false;


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
     * @param bool $stageRendered
     *
     * @return TestExceptionRenderer
     */
    public function setRendered(
        bool $rendered,
        bool $stageRendered = null
    ): TestExceptionRenderer {
        $this->rendered = $rendered;

        if (isset($stageRendered)) {
            $this->stageRendered = $stageRendered;
        }

        return $this;
    }


    /**
     * Did renderStage() get called?
     *
     * @return bool
     * True if yes, false if no.
     */
    public function isStageRendered(): bool
    {
        return $this->stageRendered;
    }


    public function setStageRendered(bool $stageRendered): TestExceptionRenderer
    {
        $this->stageRendered = $stageRendered;

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
     * @param array $stage
     *
     * @return string
     */
    public function renderStage(array $stage): string
    {
        $this->stageRendered = true;

        return '';
    }
}
