<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Responder;

/**
 * Interface ErrorHandlerInterface
 */
interface ErrorResponderInterface
{
    /**
     * @param \Throwable $throwable
     *
     * @return mixed
     */
    public function handleException(\Throwable $throwable);

    public function considerException (\Throwable $throwable): bool;
}
