<?php

namespace Feather\View;

/**
 *
 * @author fcarbah
 */
interface ViewInterface {
    /**
     * 
     * @param string $view
     * @param array $data
     */
    public function render($view,array $data);
    
    /**
     * 
     * @param string $basePath
     * @param string $cachePath
     * @param array $options
     * @return \Feather\View\ViewInterface
     */
    public static function getInstance($basePath,$cachePath,array $options=[]);
    
}
