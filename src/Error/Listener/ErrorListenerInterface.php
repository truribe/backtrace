<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener;


use tvanc\backtrace\Error\Handle\ErrorHandlerInterface;

/**
 * Defines a protocol for classes that delegate errors to one or more handlers.
 */
interface ErrorListenerInterface extends ErrorHandlerInterface
{
    const TYPE_ERROR       = 1; // 0b0001
    const TYPE_EXCEPTION   = 2; // 0b0010
    const TYPE_FATAL_ERROR = 4; // 0b0100
    const TYPE_ALL         = self::TYPE_ERROR | self::TYPE_EXCEPTION | self::TYPE_FATAL_ERROR; // 0b0111


    /**
     * Set all handlers at once, overwriting ALL that may have been previously
     * set.
     *
     * @param ErrorHandlerInterface[] $handlers
     * An array of error handlers.
     *
     * @return $this
     */
    public function setHandlers(array $handlers): self;


    /**
     * Add a single error handler, without displacing or overwriting any
     * previously set handlers.
     *
     * @param ErrorHandlerInterface $handler
     *
     * @return $this
     */
    public function addHandler(ErrorHandlerInterface $handler): self;


    /**
     * Get all handlers previously registered to this listener.
     *
     * @return array
     */
    public function getHandlers(): array;


    /**
     * Listen for exceptions and errors.
     *
     * @param int $types
     * A bitmask of one or more of the following:
     * - ErrorListenerInterface::TYPE_ERROR
     * - ErrorListenerInterface::TYPE_EXCEPTION
     * - ErrorListenerInterface::TYPE_FATAL_ERROR
     * Additionally, you can simply provide ErrorListenerInterface::TYPE_ALL,
     * which, as you should expect, is a shortcut for the following:
     * ErrorListenerInterface::TYPE_ERROR | ErrorListenerInterface::TYPE_EXCEPTION | ErrorListenerInterface::TYPE_FATAL_ERROR
     * @return $this
     */
    public function listen ($types = ErrorListenerInterface::TYPE_ALL): self;


    /**
     * Listen for exceptions.
     *
     * @see \set_exception_handler()
     *
     * @return $this
     */
    public function listenForExceptions(): self;


    /**
     * Listen for errors.
     *
     * @see \set_error_handler()
     *
     * @return $this
     */
    public function listenForErrors(): self;


    /**
     * Register this listener as a shutdown handler.
     *
     * @see \register_shutdown_function()
     *
     * @return $this
     */
    public function listenForShutdown(): self;


    /**
     * Enable or disable overriding native error handling.
     *
     * @param bool $override
     * Whether to override native error handling.
     * - `true` to override
     * - `false` not to override
     *
     * @return $this
     */
    public function setOverride(bool $override): self;
}
