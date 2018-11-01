<?php
/**
 * TODO Add @file block for TestRendererInterface.php
 *
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
     * @return bool
     */
    public function isRendered(): bool
    {
        return $this->rendered;
    }


    /**
     * @param bool $rendered
     *
     * @return TestRenderer
     */
    public function setRendered(bool $rendered): TestRenderer
    {
        $this->rendered = $rendered;

        return $this;
    }


    public function render(\Throwable $throwable): string
    {
        $this->rendered = true;

        return '';
    }


    public function renderStage(array $stage): string
    {
        return '';
    }
}
