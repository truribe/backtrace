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
     * When an error/exception gets thrown, and a listener is registered to
     * hear it, it's gonna land in an implementation of this method.
     *
     * @param \Throwable $throwable
     */
    public function catchThrowable(\Throwable $throwable)
    {
        // TODO: Implement catchThrowable() method.
    }


    /**
     * Go back to the way things were. Pretend nothing ever happened.
     *
     * @return $this
     */
    public function reset()
    {
        $this->caughtThrowable = false;

        return $this;
    }
}
