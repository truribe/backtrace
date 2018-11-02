<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render\Exception;

use tvanc\backtrace\Render\EnvironmentAwareRenderer;

/**
 * An exception for when an EnvironmentAwareRenderer doesn't have a responder
 * for the reported environment.
 *
 * @see EnvironmentAwareRenderer::selectRenderer()
 */
class NoRendererException extends \Exception
{
}
