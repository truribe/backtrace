<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Test\Error\Listener;

use tvanc\Backtrace\Error\Listener\ErrorListener;
use tvanc\Backtrace\Error\Listener\ErrorListenerInterface;

/**
 * A test error listener that
 */
class TestErrorListener extends ErrorListener
{
    private $listeningForErrors = false;
    private $listeningForExceptions = false;
    private $listeningForShutdown = false;


    /**
     * @return bool
     */
    public function isListeningForErrors(): bool
    {
        return $this->listeningForErrors;
    }


    /**
     * @return bool
     */
    public function isListeningForExceptions(): bool
    {
        return $this->listeningForExceptions;
    }


    /**
     * @return bool
     */
    public function isListeningForShutdown(): bool
    {
        return $this->listeningForShutdown;
    }


    public function listenForErrors(): ErrorListenerInterface
    {
        $this->listeningForErrors = true;

        return parent::listenForErrors();
    }


    public function listenForExceptions(): ErrorListenerInterface
    {
        $this->listeningForExceptions = true;

        return parent::listenForExceptions();
    }


    public function listenForShutdown(): ErrorListenerInterface
    {
        $this->listeningForShutdown = true;

        return parent::listenForShutdown();
    }
}
