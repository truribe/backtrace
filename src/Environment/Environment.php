<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Environment;

/**
 * Class Environment
 *
 * @package tvanc\backtrace\Environment
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
     * @return bool
     */
    public function isAjaxRequest(): bool
    {
        $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';

        return 'xmlhttprequest' === strtolower($requestedWith);
    }
}
