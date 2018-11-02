<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use tvanc\backtrace\Render\ExceptionRendererInterface;

/**
 * A no-op class that satisfies test conditions.
 */
class TestRenderer implements ExceptionRendererInterface
{
    private $rendered = false;


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
     *
     * @return TestRenderer
     */
    public function setRendered(bool $rendered): TestRenderer
    {
        $this->rendered = $rendered;

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
        return '';
    }
}
