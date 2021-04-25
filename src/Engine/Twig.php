<?php

namespace Feather\View\Engine;

use Twig\Loader\FilesystemLoader;
use Twig\Environment as TwigEnv;
use Feather\View\IView;

/**
 * Description of TwigEngine
 *
 * @author fcarbah
 */
class Twig extends TwigEnv implements IView
{

    /**
     *
     * @param string $basePath
     * @param string $cachePath
     * @param array $options
     * @return IView
     */
    public static function getInstance($basePath, $cachePath, array $options = array()): IView
    {
        $viewPath = strripos($basePath, '/') === strlen($basePath) - 1 ? $basePath : $basePath . '/';
        $loader = new FilesystemLoader($viewPath, $viewPath);
        $engine = new Twig($loader, $options);
        return $engine;
    }

}
