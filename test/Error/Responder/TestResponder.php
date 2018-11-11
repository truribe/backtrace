<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Responder;

use tvanc\backtrace\Error\Responder\ErrorResponderInterface;

/**
 * A responder implementation to use in test cases because it allows you to
 * verify whether the responder was triggered.
 */
class TestResponder implements ErrorResponderInterface
{
    private $caughtThrowable = false;


    /**
     * @return bool
     * Whether this responder has caught a throwable exception.
     *
     * @see TestResponder::catchThrowable()
     */
    public function caughtThrowable(): bool
    {
        return $this->caughtThrowable;
    }


    /**
     * When an error/exception gets thrown, and a listener is registered to
     * hear it, it's gonna land in an implementation of this method.
     *
     * Sets a flag to indicate that this responder has received an
     * exception.
     *
     * @param \Throwable $throwable
     */
    public function catchThrowable(\Throwable $throwable)
    {
        $this->caughtThrowable = true;
    }
}
