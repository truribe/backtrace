<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;


/**
 * A protocol for exception-rendering classes to follow.
 */
interface ExceptionRendererInterface
{
    public static function getErrorType(\Throwable $throwable): string;


    public function render(\Throwable $throwable): string;


    public function renderStage(array $stage): string;
}
