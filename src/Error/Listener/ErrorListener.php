<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener;

use tvanc\backtrace\Error\Handle\ErrorHandlerInterface;
use tvanc\backtrace\Error\Listener\Exception\ShutdownException;
use tvanc\backtrace\Error\Listener\Exception\UnhandledExceptionException;

/**
 * A utility class that attempts to make dealing with errors as easy as
 * possible.
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

    /**
     * @var int
     */
    private $mode;


    public function __construct(
        array $handlers = [],
        bool $override = false,
        int $mode = \E_ALL | \E_STRICT
    ) {
        $this->handlers = $handlers;
        $this->override = $override;

        if (!\is_int($mode) && !\is_null($mode)) {
            throw new \InvalidArgumentException('Argument $mode has to be integer or null!');
        }

        $this->mode = $mode;
    }


    public function listen(
        $types = ErrorListenerInterface::TYPE_ALL
    ): ErrorListenerInterface {
        if ($types & static::TYPE_ERROR) {
            $this->listenForErrors();
        }
        // @codeCoverageIgnoreStart
        if ($types & static::TYPE_EXCEPTION) {
            $this->listenForExceptions();
        }
        if ($types & static::TYPE_FATAL_ERROR) {
            $this->listenForErrors();
        }

        // @codeCoverageIgnoreEnd
        return $this;
    }


    public function listenForErrors(): ErrorListenerInterface
    {
        \set_error_handler([$this, 'handleError'], $this->mode);

        return $this;
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


    public function listenForShutdown(): ErrorListenerInterface
    {
        \register_shutdown_function([$this, 'handleShutdown']);

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
     * @param $severity
     * @param $message
     * @param $fileName
     * @param $lineNumber
     *
     * @return bool
     *
     * @throws UnhandledExceptionException
     */
    public function handleError($severity, $message, $fileName, $lineNumber)
    {
        $this->catchThrowable(
            new \ErrorException($message, 0, $severity, $fileName, $lineNumber)
        );

        return $this->override;
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
     * @param array $error
     *
     * @return mixed
     * @throws UnhandledExceptionException
     */
    public function handleShutdown()
    {
        $error = \error_get_last();
        if (!$error || !($error['type'] & $this->mode)) {
            return;
        }
        if ($this->isFatalError($error['type'])) {
            $this->catchThrowable(
                new ShutdownException($error['message'], 0, $error['type'], $error['file'], $error['line'])
            );
        }

    }


    /**
     * @codeCoverageIgnore
     *
     * @param int $code
     *
     * @return bool
     */
    private function isFatalError($code)
    {
        // Constant can be an array in PHP >=5.6
        $fatalErrors = array(
            \E_ERROR,
            \E_PARSE,
            \E_CORE_ERROR,
            \E_CORE_WARNING,
            \E_COMPILE_ERROR,
            \E_COMPILE_WARNING,
        );

        foreach ($fatalErrors as $fatalCode) {
            if ($code & $fatalCode) {
                return true;
            }
        }

        return false;
    }
}
