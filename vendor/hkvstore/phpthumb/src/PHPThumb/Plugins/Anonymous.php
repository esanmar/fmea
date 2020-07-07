<?php

namespace PHPThumb\Plugins;

/**
 * Anonymous Function Plugin
 *
 * @package PhpThumb
 * @subpackage Plugins
 */
class Anonymous implements \PHPThumb\PluginInterface
{

    private $_func;

    /**
     * @param function $func
     */
    public function __construct($func)
    {
        $this->_func = $func;
    }

    /**
     * @param PHPThumb $phpthumb
     * @return PHPThumb
     */
    public function execute($phpthumb)
    {
        $fn = $this->_func;
        if (is_callable($fn)) {
            $fn($phpthumb);
        }

        return $phpthumb;
    }
}
