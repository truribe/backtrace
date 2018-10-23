<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener;


use tvanc\backtrace\Error\Handler\ErrorHandlerInterface;

/**
 * Interface ErrorListenerInterface
 */
interface ErrorListenerInterface extends ErrorHandlerInterface
{
    public function setHandlers(array $handlers);


    public function addHandler(ErrorHandlerInterface $handler);


    public function getHandlers(): array;


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
