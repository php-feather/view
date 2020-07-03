<?php

namespace Feather\View\Engine;
use Twig\Loader\FilesystemLoader;
use Twig\Environment as Twig;
use Feather\View\ViewInterface;
/**
 * Description of TwigEngine
 *
 * @author fcarbah
 */
class TwigEngine extends Twig implements ViewInterface {
    
    /**
     * 
     * @param string $basePath
     * @param string $cachePath
     * @param array $options
     * @return ViewInterface
     */
    public static function getInstance($basePath, $cachePath, array $options = array()): ViewInterface {
        $viewPath = strripos($path,'/') === strlen($path)-1? $path : $path.'/';        
        $loader = new FilesystemLoader($viewPath, $viewPath);
        $engine = new TwigEngine($loader, $options);
        return $engine;
    }

}
