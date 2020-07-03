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
    
    public function setPaths($basePath, $cachePath='') {
        $viewPath = strripos($path,'/') === strlen($path)-1? $path : $path.'/';        
        $loader = new FilesystemLoader($viewPath, $viewPath);
        $this->setLoader($loader);
    }

}
