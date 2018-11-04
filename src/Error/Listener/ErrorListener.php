<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener;

use tvanc\backtrace\Error\Listener\Exception\NoResponderException;
use tvanc\backtrace\Error\Listener\Exception\ShutdownException;
use tvanc\backtrace\Error\Responder\ErrorResponderInterface;

/**
 * A utility class for delegating errors and exceptions to responders.
 */
class ErrorListener implements ErrorListenerInterface
{
    private const FATAL_ERRORS = [
        \E_ERROR,
        \E_PARSE,
        \E_CORE_ERROR,
        \E_CORE_WARNING,
        \E_COMPILE_ERROR,
        \E_COMPILE_WARNING,
    ];
    /**
     * @var bool Whether to escalate errors to exceptions.
     */
    protected $errorEscalation;
    /**
     * @var bool
     * Whether to override PHP's internal error handler.
     * False indicates do NOT override: Native error handling WILL resume.
     * True indicates DO override: Native error handling will NOT resume.
     */
    protected $override;
    /**
     * @var ErrorResponderInterface[] Error responders.
     */
    private $responders;
    /**
     * @var int
     */
    private $mode;
    /**
     * @var bool
     * Whether to halt execution immediately after detecting an error
     * or exception.
     */
    private $exitAfterTrigger;


    public function __construct(
        array $responders = [],
        bool $override = false,
        int $mode = \E_ALL | \E_STRICT
    ) {
        $this->responders = $responders;
        $this->override   = $override;
        $this->mode       = $mode;
    }


    public function listen(
        $types = ErrorListenerInterface::TYPE_ALL
    ): ErrorListenerInterface {
        if ($types & static::TYPE_ERROR) {
            $this->listenForErrors();
        }

        if ($types & static::TYPE_EXCEPTION) {
            $this->listenForExceptions();
        }

        if ($types & static::TYPE_SHUTDOWN) {
            $this->listenForShutdown();
        }

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
        \set_exception_handler([$this, 'catchThrowable']);

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


    public function addResponder(ErrorResponderInterface $responder): ErrorListenerInterface
    {
        $this->responders[] = $responder;

        return $this;
    }


    public function getResponders(): array
    {
        return $this->responders;
    }


    public function setResponders(array $responders): ErrorListenerInterface
    {
        $this->setResponders($responders);

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
     * @throws NoResponderException
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
     * @throws NoResponderException
     * If no responders exist to handle the exception.
     */
    public function catchThrowable(\Throwable $throwable)
    {
        if (!$this->responders) {
            throw new NoResponderException($throwable);
        }

        foreach ($this->responders as $responder) {
            $responder->catchThrowable($throwable);
        }

        // @codeCoverageIgnoreStart
        if ($this->exitAfterTrigger) {
            exit(1);
        }
        // @codeCoverageIgnoreEnd
    }


    /**
     * @throws NoResponderException
     *
     * @codeCoverageIgnore
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
        foreach (self::FATAL_ERRORS as $fatalCode) {
            if ($code & $fatalCode) {
                return true;
            }
        }

        return false;
    }
}
