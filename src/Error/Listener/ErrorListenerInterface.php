<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Error\Listener;


use TVanC\Backtrace\Error\Responder\ErrorResponderInterface;

/**
 * Defines a protocol for classes that delegate errors to one or more responders.
 */
interface ErrorListenerInterface extends ErrorResponderInterface
{
    const TYPE_ERROR = 1; // 0b0001
    const TYPE_EXCEPTION = 2; // 0b0010
    const TYPE_SHUTDOWN = 4; // 0b0100
    const TYPE_ALL = self::TYPE_ERROR | self::TYPE_EXCEPTION | self::TYPE_SHUTDOWN; // 0b0111


    /**
     * Set all responders at once, overwriting ALL that may have been previously
     * set.
     *
     * @param ErrorResponderInterface[] $responders
     * An array of error responders.
     *
     * @return $this
     */
    public function setResponders(array $responders): self;


    /**
     * Add a single error responder, without displacing or overwriting any
     * previously set responders.
     *
     * @param ErrorResponderInterface $responder
     *
     * @return $this
     */
    public function addResponder(ErrorResponderInterface $responder): self;


    /**
     * Get all responders previously registered to this listener.
     *
     * @return array
     */
    public function getResponders(): array;


    /**
     * Listen for exceptions and errors.
     *
     * @param int $types
     * A bitmask of one or more of the following:
     * - ErrorListenerInterface::TYPE_ERROR
     * - ErrorListenerInterface::TYPE_EXCEPTION
     * - ErrorListenerInterface::TYPE_FATAL_ERROR
     * Additionally, you can simply provide ErrorListenerInterface::TYPE_ALL,
     * which is a shortcut for the following:
     * ErrorListenerInterface::TYPE_ERROR
     * | ErrorListenerInterface::TYPE_EXCEPTION
     * | ErrorListenerInterface::TYPE_FATAL_ERROR
     *
     * @return $this
     */
    public function listen($types = ErrorListenerInterface::TYPE_ALL): self;


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
     * Register this listener as a shutdown responder.
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
