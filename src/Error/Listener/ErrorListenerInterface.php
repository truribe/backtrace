<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener;


use tvanc\backtrace\Error\Responder\ErrorResponderInterface;

/**
 * Interface ErrorListenerInterface
 */
interface ErrorListenerInterface extends ErrorResponderInterface
{
    const FATAL_ERRORS = [
        \E_ERROR,
        \E_PARSE,
        \E_CORE_ERROR,
        \E_CORE_WARNING,
        \E_COMPILE_ERROR,
        \E_COMPILE_WARNING,
    ];

    const TYPE_ERROR       = 1; // 0b0001
    const TYPE_EXCEPTION   = 2; // 0b0010
    const TYPE_FATAL_ERROR = 4; // 0b0100
    const TYPE_ALL         = 7; // 0b0111



    public function setResponders(array $handlers);


    public function addResponder(ErrorResponderInterface $handler);


    public function getResponders(): array;


    /**
     * @param ErrorResponderInterface $responder
     *
     * @return ErrorListenerInterface
     */
    public function setDefaultResponder(ErrorResponderInterface $responder): self;


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
