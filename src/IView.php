<?php

namespace Feather\View;

/**
 *
 * @author fcarbah
 */
interface IView {
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
     * @return \Feather\View\IView
     */
    public static function getInstance($basePath,$cachePath,array $options=[]);
    
}
