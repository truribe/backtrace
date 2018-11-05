<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener\Exception;

use tvanc\backtrace\Error\Listener\ErrorListenerInterface;

/**
 * An exception just for when a listener "hears" a shutdown "event".
 *
 * @see ErrorListenerInterface::listenForShutdown()
 */
class ShutdownException extends \ErrorException
{
}
