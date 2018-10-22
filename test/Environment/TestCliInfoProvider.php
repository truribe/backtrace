<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Environment;

use tvanc\backtrace\Environment\CliInfoProvider;

/**
 * Class TestCliInfoProvider
 *
 * @package tvanc\backtrace\Test\Utility
 */
class TestCliInfoProvider extends CliInfoProvider
{
    /**
     * @var int
     */
    private $consoleWidth;


    public function __construct(int $consoleWidth)
    {
        $this->consoleWidth = $consoleWidth;
    }


    /**
     * @return int
     */
    public function getConsoleWidth(): int
    {
        return $this->consoleWidth;
    }
}
