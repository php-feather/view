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
     */
    public function setPaths($basePath,$cachePath);
    
}
