<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Environment;

/**
 * Provides info about the current console session.
 */
class CliInfoProvider
{
    public function getConsoleWidth(): int
    {
        return +exec('tput cols');
    }
}
