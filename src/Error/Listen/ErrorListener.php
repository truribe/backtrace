<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listen;

use tvanc\backtrace\Error\Handle\ErrorHandlerInterface;
use tvanc\backtrace\Error\Listen\Exception\UnhandledErrorException;
use tvanc\backtrace\Error\Listen\Exception\UnhandledExceptionException;

/**
 * Class ErrorListener
 *
 * @package tvanc\backtrace\Error\Listen
 */
class ErrorListener implements ErrorListenerInterface
{
    /**
     * @var bool Whether to escalate errors to exceptions.
     */
    protected $errorEscalation;

    /**
     * @var bool Whether to override PHP's internal error handler.
     */
    protected $override;


    /**
     * @var ErrorHandlerInterface[] Error handlers.
     */
    private $handlers;



    public function __construct(
        array $handlers = [],
        bool $override = false
    ) {
        $this->override = $override;
        $this->handlers = $handlers;
    }


    /**
     * @return ErrorListenerInterface
     */
    public function listenForExceptions(): ErrorListenerInterface
    {
        // Set bogus handler so we we can restore later and be sure $result
        // won't be null unless there was an error.
        \set_exception_handler(
            [$this, 'catchThrowable']
        );

        return $this;
    }


    public function listenForErrors($types = \E_ALL | \E_STRICT): ErrorListenerInterface
    {
        \set_error_handler([$this, 'handleError'], $types);

        return $this;
    }


    public function setOverride(bool $override): ErrorListenerInterface
    {
        $this->override = $override;

        return $this;
    }


    public function addHandler(ErrorHandlerInterface $handler): ErrorListenerInterface
    {
        $this->handlers[] = $handler;

        return $this;
    }


    public function getHandlers(): array
    {
        return $this->handlers;
    }


    public function setHandlers(array $handlers): ErrorListenerInterface
    {
        $this->setHandlers($handlers);

        return $this;
    }


    /**
     * @param \Throwable $throwable
     *
     * @throws UnhandledExceptionException
     * If no handlers exist to handle the exception.
     */
    public function catchThrowable(\Throwable $throwable)
    {
        if ($throwable instanceof UnhandledExceptionException) {
            exit($throwable->__toString());
        }

        if (!$this->handlers) {
            throw new UnhandledExceptionException($throwable);
        }

        foreach ($this->handlers as $handler) {
            $handler->catchThrowable($throwable);
        }
    }


    /**
     * @param $severity
     * @param $message
     * @param $fileName
     * @param $lineNumber
     *
     * @return bool
     *
     * @throws UnhandledErrorException
     */
    public function handleError($severity, $message, $fileName, $lineNumber)
    {
        if (!$this->handlers) {
            throw new UnhandledErrorException(
                $severity,
                $message,
                $fileName,
                $lineNumber
            );
        }

        foreach ($this->handlers as $handler) {
            $handler->handleError($severity, $message, $fileName, $lineNumber);
        }

        return $this->override;
    }


    /**
     * @param array $error
     *
     * @return mixed
     */
    public function handleFatalError(array $error)
    {
        // TODO: Implement handleFatalError() method.
    }
}
