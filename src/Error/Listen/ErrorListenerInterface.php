<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listen;


use tvanc\backtrace\Error\Handle\ErrorHandlerInterface;

/**
 * Interface ErrorListenerInterface
 *
 * @package tvanc\backtrace\Error\Listen
 */
interface ErrorListenerInterface extends ErrorHandlerInterface
{
    const TYPE_ERROR       = 1; // 0b0001
    const TYPE_EXCEPTION   = 2; // 0b0010
    const TYPE_FATAL_ERROR = 4; // 0b0100
    const TYPE_ALL         = 7; // 0b0111

    public function setHandlers(array $handlers);


    public function addHandler(ErrorHandlerInterface $handler);


    public function getHandlers(): array;


    /**
     * Listen for exceptions and errors.
     *
     * @param int $types
     *
     * @return ErrorListenerInterface
     */
    public function listen ($types = ErrorListenerInterface::TYPE_ALL): self;


    /**
     * Listen for exceptions.
     *
     * @return ErrorListenerInterface
     */
    public function listenForExceptions(): self;


    /**
     * Listen for errors.
     *
     * @return ErrorListenerInterface
     */
    public function listenForErrors(): self;


    public function listenForShutdown(): self;


    /**
     * Enable or disable overriding native error handling.
     *
     * @param bool $override
     * Whether to override native error handling.
     * - `true` to override
     * - `false` not to override
     *
     * @return ErrorListenerInterface
     */
    public function setOverride(bool $override): self;
}
