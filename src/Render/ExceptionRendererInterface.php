<?php
/**
 * TODO Add @file block for BacktraceRenderInterface.php
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;


interface ExceptionRendererInterface
{
    public function render(\Throwable $throwable): string;


    public function renderStage(array $stage): string;
}
