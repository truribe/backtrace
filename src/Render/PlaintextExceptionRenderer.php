<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;

/**
 * Renders exceptions in plaintext format, using only text-based visual
 * formatting, if any.
 */
class PlaintextExceptionRenderer extends AbstractExceptionRenderer
{
    public function render(\Throwable $throwable): string
    {
        // TODO: Implement render() method.
    }


    public function renderStage(array $stage): string
    {
        // TODO: Implement renderStage() method.
    }
}
