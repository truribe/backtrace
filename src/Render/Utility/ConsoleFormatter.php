<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render\Utility;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * TODO Document ConsoleFormatter
 */
class ConsoleFormatter extends OutputFormatter
{
    public function __construct(bool $decorated = false, $styles = array())
    {
        parent::__construct($decorated, $styles);

        $public        = new OutputFormatterStyle(null, 'green');
        $protected     = new OutputFormatterStyle(null, 'yellow');
        $private       = new OutputFormatterStyle(null, 'red');
        $indeterminate = new OutputFormatterStyle('red', 'white');

        $class    = $this->getStyle('info');
        $function = $class;
        $type     = new OutputFormatterStyle();

        $file   = new OutputFormatterStyle('cyan');
        $joiner = new OutputFormatterStyle();
        $line   = new OutputFormatterStyle('magenta');

        $this->setStyle('public', $public);
        $this->setStyle('protected', $protected);
        $this->setStyle('private', $private);

        $this->setStyle('indeterminate', $indeterminate);

        $this->setStyle('class', $class);
        $this->setStyle('function', $function);
        $this->setStyle('type', $type);

        $this->setStyle('file', $file);
        $this->setStyle('line', $line);
        $this->setStyle('joiner', $joiner);
    }
}
