<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Render\Exception;

use tvanc\Backtrace\Render\EnvironmentAwareRenderer;

/**
 * An exception for when an EnvironmentAwareRenderer doesn't have a responder
 * for the reported environment.
 *
 * @see EnvironmentAwareRenderer::selectRenderer()
 */
class NoRendererException extends \Exception
{
}
