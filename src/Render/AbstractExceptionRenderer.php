<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Render;

/**
 * Provide a base that defines methods that can also be used by concrete
 * descendants.
 */
abstract class AbstractExceptionRenderer implements ExceptionRendererInterface
{
    /**
     * @param \Throwable $throwable
     * @param bool       $pretty
     *
     * @return string
     */
    public static function getErrorDisplayType(
        \Throwable $throwable,
        bool $pretty = true
    ): string {
        if ($pretty && $throwable instanceof \ErrorException) {
            $severity = $throwable->getSeverity();

            $typeNameMap = [
                E_ERROR             => 'Fatal error',
                E_PARSE             => 'Parse error',
                E_CORE_ERROR        => 'Core error',
                E_COMPILE_ERROR     => 'Compile error',
                E_USER_ERROR        => 'User error',
                E_NOTICE            => 'Notice',
                E_DEPRECATED        => 'Deprecated',
                E_USER_NOTICE       => 'User notice',
                E_WARNING           => 'Warning',
                E_USER_WARNING      => 'User warning',
                E_CORE_WARNING      => 'Core warning',
                E_COMPILE_WARNING   => 'Compile warning',
                E_STRICT            => 'Strict message',
                E_RECOVERABLE_ERROR => 'Recoverable error',
                E_USER_DEPRECATED   => 'Deprecated',
            ];

            return $typeNameMap[$severity];
        }

        if ($pretty) {
            try {
                $reflection = new \ReflectionClass($throwable);

                return $reflection->getShortName();
                // @codeCoverageIgnoreStart
            } catch (\Exception $exception) {
                // If exception is thrown just return the plain ol' FQCN
            }
            // @codeCoverageIgnoreEnd
        }

        return get_class($throwable);
    }
}
