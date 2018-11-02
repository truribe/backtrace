<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listen\Exception;

use tvanc\backtrace\Error\Listen\ErrorListenerInterface;

/**
 * An exception just for when a listener "hears" a shutdown "event".
 *
 * @see ErrorListenerInterface::listenForShutdown()
 */
class ShutdownException extends \ErrorException
{
}
