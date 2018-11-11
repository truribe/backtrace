<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Render;


/**
 * A protocol for exception-rendering classes to follow.
 */
interface ExceptionRendererInterface
{
    /**
     * @param \Throwable $throwable
     * @param bool       $pretty
     *
     * @return string
     */
    public static function getErrorDisplayType(
        \Throwable $throwable,
        bool $pretty = true
    ): string;


    public function render(\Throwable $throwable): string;


    public function renderFrame(array $frame): string;
}
