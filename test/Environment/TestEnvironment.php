<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Environment;

use tvanc\backtrace\Environment\EnvironmentInterface;

/**
 * Class MockEnvironment
 *
 * @package tvanc\backtrace\Test\Environment
 */
class TestEnvironment implements EnvironmentInterface
{
    private $isCli;

    private $isAjaxRequest;


    public function __construct(bool $isCli, bool $isAjaxRequest)
    {
        $this->isCli = $isCli;
        $this->isAjaxRequest = $isAjaxRequest;
    }


    public function isCli(): bool
    {
        return $this->isCli;
    }


    public function isAjaxRequest(): bool
    {
        return $this->isAjaxRequest;
    }
}
