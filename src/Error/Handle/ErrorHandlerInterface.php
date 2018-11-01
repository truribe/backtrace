<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Handle;

/**
 * Interface ErrorHandlerInterface
 *
 * @package tvanc\backtrace\Handler
 */
interface ErrorHandlerInterface
{
    /**
     * @param \Throwable $throwable
     *
     * @return mixed
     */
    public function catchThrowable(\Throwable $throwable);
}
