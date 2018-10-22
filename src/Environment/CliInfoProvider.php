<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Environment;

/**
 * Class CliContextInfo
 *
 * @package tvanc\backtrace\Utility
 */
class CliInfoProvider
{
    public function getConsoleWidth(): int
    {
        return +exec('tput cols');
    }
}
