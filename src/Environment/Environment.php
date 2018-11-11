<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Environment;

/**
 * Provides information about the environment in which PHP is being run.
 *
 * @codeCoverageIgnore
 */
class Environment implements EnvironmentInterface
{
    /**
     * Makes every attempt to determine from available information whether
     * the environment is CLI or not.
     *
     * @see https://stackoverflow.com/a/25967493/877574
     *
     * @return bool
     */
    public function isCli(): bool
    {
        if (defined('STDIN')) {
            return true;
        }

        if (php_sapi_name() === 'cli') {
            return true;
        }

        if (array_key_exists('SHELL', $_ENV)) {
            return true;
        }

        if (
            empty($_SERVER['REMOTE_ADDR'])
            && !isset($_SERVER['HTTP_USER_AGENT'])
            && count($_SERVER['argv']) > 0
        ) {
            return true;
        }

        if (!array_key_exists('REQUEST_METHOD', $_SERVER)) {
            return true;
        }

        return false;
    }


    /**
     * Attempts to determine whether PHP is currently serving an AJAX request.
     * This makes no attempt whatsoever to PROVE the point, because that's an
     * impossible goal.
     *
     * @return bool
     */
    public function isAjaxRequest(): bool
    {
        $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';

        return 'xmlhttprequest' === strtolower($requestedWith);
    }
}
