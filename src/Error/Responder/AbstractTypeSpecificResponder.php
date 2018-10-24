<?php
/**
 * TODO Add @file block for TypeSpecificResponder.php
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Responder;

/**
 * TODO Document class TypeSpecificResponder
 */
abstract class AbstractTypeSpecificResponder implements ErrorResponderInterface
{
    /**
     * @var string
     */
    private $specificThrowableClass;


    public function __construct(string $specificThrowableClass)
    {
        $this->specificThrowableClass = $specificThrowableClass;
    }


    public function considerException(\Throwable $throwable): bool
    {
        return $throwable instanceof $this->specificThrowableClass;
    }
}
