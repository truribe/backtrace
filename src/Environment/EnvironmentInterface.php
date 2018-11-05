<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Environment;


/**
 * Interface for classes purporting to provide information about PHP's
 * environment.
 */
interface EnvironmentInterface
{
    public function isCli(): bool;


    public function isAjaxRequest(): bool;
}
