<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Responder;

use tvanc\backtrace\Error\Listener\ErrorListenerInterface;

/**
 * Interface for responders to errors heard by a listener.
 *
 * @see ErrorListenerInterface
 */
interface ErrorResponderInterface
{
    /**
     * When an error/exception gets thrown, and a listener is registered to
     * hear it, it's gonna land in an implementation of this method.
     *
     * @param \Throwable $throwable
     */
    public function catchThrowable(\Throwable $throwable);
}
