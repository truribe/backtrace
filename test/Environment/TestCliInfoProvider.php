<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Environment;

use tvanc\backtrace\Environment\CliInfoProvider;

/**
 * A mock of CliInfoProvider to assist in testing.
 */
class TestCliInfoProvider extends CliInfoProvider
{
    /**
     * @var int
     * Whatever value you want for testing.
     */
    private $consoleWidth;


    /**
     * TestCliInfoProvider constructor.
     *
     * @param int $consoleWidth
     * Whatever value you want for testing.
     */
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
