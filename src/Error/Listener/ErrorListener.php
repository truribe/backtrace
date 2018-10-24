<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener;

use tvanc\backtrace\Error\Listener\Exception\ShutdownException;
use tvanc\backtrace\Error\Listener\Exception\UnhandledExceptionException;
use tvanc\backtrace\Error\Responder\ErrorResponderInterface;

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
     * @var
     */
    protected $mode;

    /**
     * @var ErrorResponderInterface[] Error responders.
     */
    private $responders;

    /**
     * @var callable The exception handler this class displaces.
     */
    private $displacedExceptionHandler;

    /**
     * @var callable The error handler this class displaces.
     */
    private $displacedErrorHandler;

    /**
     * @var bool Whether to exit after a non-fatal error.
     */
    private $exitAfterTrigger = true;

    /**
     * @var ErrorResponderInterface
     * Fall back to this responder if no specialized one exists.
     */
    private $defaultResponder;


    /**
     * @param array $responders
     * @param int   $mode Default E_ALL | E_STRICT
     * @param bool  $override
     *
     * @see http://php.net/manual/en/errorfunc.constants.php
     *
     * @see http://php.net/manual/en/language.operators.bitwise.php
     */
    public function __construct(
        array $responders = [],
        int $mode = null,
        $override = true
    ) {
        $this->responders = $responders;
        $this->mode = \is_null($mode) ? \E_ALL | \E_STRICT : $mode;
        $this->override = $override;
    }


    public function listen($types = ErrorListenerInterface::TYPE_ALL)
    {
        if ($types & static::TYPE_ERROR) {
            $this->listenForErrors();
        }

        // @codeCoverageIgnoreStart
        if ($types & static::TYPE_EXCEPTION) {
            $this->listenForExceptions();
        }
        if ($types & static::TYPE_FATAL_ERROR) {
            $this->listenForShutdown();
        }

        // @codeCoverageIgnoreEnd

        return $this;
    }


    public function listenForErrors(): ErrorListenerInterface
    {
        $this->displacedErrorHandler = \set_error_handler(
            [$this, 'handleError'],
            $this->mode
        );

        return $this;
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


    /**
     * Listen for shutdown.
     *
     * @return ErrorListenerInterface
     */
    public function listenForShutdown(): ErrorListenerInterface
    {
        \register_shutdown_function([$this, 'handleShutdown']);

        return $this;
    }


    /**
     * @codeCoverageIgnore
     *
     * @param bool $condition
     *
     * @return $this
     */
    public function exitAfterTrigger(bool $condition)
    {
        $this->exitAfterTrigger = $condition;

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
        $handled = false;

        foreach ($this->responders as $responder) {
            if ($responder->considerException($throwable)) {
                $handled = true;
                $responder->handleException($throwable);
            }
        }

        if (
            !$handled
            && $this->defaultResponder
            && $this->defaultResponder->considerException($throwable)
        ) {
            $this->defaultResponder->handleException($throwable);
        }
        else if (!$handled) {
            throw new UnhandledExceptionException($throwable);
        }

        if ($this->exitAfterTrigger) {
            exit(1);
        }
    }


    /**
     * @return void
     *
     * @throws UnhandledExceptionException
     */
    public function handleShutdown(): void
    {
        $error = \error_get_last();
        if (!$error || !($error['type'] & $this->mode)) {
            return;
        }
        if ($this->isFatalError($error['type'])) {
            $this->handleException(
                new ShutdownException(
                    $error['message'],
                    0, $error['type'],
                    $error['file'],
                    $error['line']
                )
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
        foreach (static::FATAL_ERRORS as $fatalCode) {
            if ($code & $fatalCode) {
                return true;
            }
        }

        return false;
    }


    /**
     * @param ErrorResponderInterface $responder
     *
     * @return ErrorListenerInterface
     */
    public function setDefaultResponder(ErrorResponderInterface $responder): ErrorListenerInterface
    {
        $this->defaultResponder = $responder;

        return $this;
    }
}
