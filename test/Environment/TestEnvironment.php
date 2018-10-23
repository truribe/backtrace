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


    /**
     * @param bool $isCli
     *
     * @return TestEnvironment
     */
    public function setIsCli(bool $isCli): TestEnvironment
    {
        $this->isCli = $isCli;

        return $this;
    }


    public function isAjaxRequest(): bool
    {
        return $this->isAjaxRequest;
    }


    /**
     * @param bool $isAjaxRequest
     *
     * @return TestEnvironment
     */
    public function setIsAjaxRequest(bool $isAjaxRequest): TestEnvironment
    {
        $this->isAjaxRequest = $isAjaxRequest;

        return $this;
    }
}
