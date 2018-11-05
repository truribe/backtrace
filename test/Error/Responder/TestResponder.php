<?php
/**
 * TODO Add @file block for TestResponder.php
 *
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Responder;

use tvanc\backtrace\Error\Responder\ErrorResponderInterface;

/**
 * TODO Document TestResponder
 */
class TestResponder implements ErrorResponderInterface
{
    private $caughtThrowable = false;


    /**
     * @return bool
     */
    public function caughtThrowable(): bool
    {
        return $this->caughtThrowable;
    }


    /**
     * When an error/exception gets thrown, and a listener is registered to
     * hear it, it's gonna land in an implementation of this method.
     *
     * @param \Throwable $throwable
     */
    public function catchThrowable(\Throwable $throwable)
    {
        $this->caughtThrowable = true;
    }
}
