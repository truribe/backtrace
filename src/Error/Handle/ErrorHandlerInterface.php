<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Handle;

use tvanc\backtrace\Error\Listen\ErrorListenerInterface;

/**
 * Interface for handlers of errors heard by a listener.
 *
 * @see ErrorListenerInterface
 */
interface ErrorHandlerInterface
{
    /**
     * When an error/exception gets thrown, and a listener is registered to
     * hear it, it's gonna land in an implementation of this method.
     *
     * @param \Throwable $throwable
     */
    public function catchThrowable(\Throwable $throwable);
}
