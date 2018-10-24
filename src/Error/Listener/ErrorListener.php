<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener;

use tvanc\backtrace\Error\Responder\ErrorResponderInterface;
use tvanc\backtrace\Error\Listener\Exception\UnhandledExceptionException;

/**
 * Class ErrorListener
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
     * @var ErrorResponderInterface[] Error responders.
     */
    private $responders;

    private $displacedExceptionHandler;


    public function __construct(
        bool $override = false
        array $responders = [],
    ) {
        $this->responders = $responders;
        $this->override = $override;
    }


    /**
     * @return ErrorListenerInterface
     */
    public function listenForExceptions(): ErrorListenerInterface
    {
        // Set bogus handler so we we can restore later and be sure $result
        // won't be null unless there was an error.
        $this->displacedExceptionHandler = \set_exception_handler(
            [$this, 'handleException']
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


    public function addResponder(ErrorResponderInterface $handler): ErrorListenerInterface
    {
        $this->responders[] = $handler;

        return $this;
    }


    public function getResponders(): array
    {
        return $this->responders;
    }


    public function setResponders(array $handlers): ErrorListenerInterface
    {
        $this->setResponders($handlers);

        return $this;
    }


    /**
     * @param $severity
     * @param $message
     * @param $file
     * @param $lineNumber
     *
     * @return bool
     *
     * @throws UnhandledExceptionException
     */
    public function handleError($severity, $message, $file, $lineNumber)
    {
        $this->handleException(
            new \ErrorException($message, 0, $severity, $file, $lineNumber)
        );

        return $this->override;
    }


    /**
     * @param \Throwable $throwable
     *
     * @throws UnhandledExceptionException
     * If no handlers exist to handle the exception.
     */
    public function handleException(\Throwable $throwable)
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
     *
     */
    {
            );
        }

        }

    }


    /**
     *
     */
    {
    }
}
