<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Utility;

/**
 * Class CliContextInfo
 *
 * @package tvanc\backtrace\Utility
 */
class CliInfoProvider
{
    public function getConsoleWidth()
    {
        return exec('tput cols');
    }
}
