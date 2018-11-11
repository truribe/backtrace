<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Error\Listener\Exception;

use tvanc\Backtrace\Error\Listener\ErrorListenerInterface;

/**
 * An exception just for when a listener "hears" a shutdown "event".
 *
 * @see ErrorListenerInterface::listenForShutdown()
 */
class ShutdownException extends \ErrorException
{
}
