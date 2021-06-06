<?php

namespace Feather\View;

use Twig\Loader\FilesystemLoader;
use Twig\Environment as TwigEnv;
use Feather\View\IView;

/**
 * Description of TwigEngine
 *
 * @author fcarbah
 */
class Twig implements IView
{

    /** @var \Twig\Environment * */
    protected $twig;

    /** @var string * */
    protected $basePath;

    /** @var array * */
    protected $options;

    public function __construct(string $basePath, $options = array())
    {
        $this->basePath = strripos($basePath, '/') === strlen($basePath) - 1 ? $basePath : $basePath . '/';
        $this->options = $options;

        $loader = new FilesystemLoader($this->basePath, $this->basePath);
        $this->twig = new TwigEnv($loader, $options);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->twig, $name], $arguments);
    }

    /**
     * Renders a template/view
     * @param string $view
     * @param array $data
     * @throws Exception
     * @return string
     */
    public function render(string $view, array $data): string
    {
        return $this->twig->render($view, $data);
    }

}
