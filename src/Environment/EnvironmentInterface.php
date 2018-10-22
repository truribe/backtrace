<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Environment;


interface EnvironmentInterface
{
    public function isCli(): bool;


    public function isAjaxRequest(): bool;
}
