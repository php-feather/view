<?php

namespace Feather\View\Engine;

use Feather\View\IView;

/**
 * Description of ViewEngine
 *
 * @author fcarbah
 */
class Native implements IView
{

    /**
     * Absolute path to views folder
     * @var string
     */
    protected $basePath;

    /**
     *
     * @var string
     */
    protected $tempViewPath;
    protected $output;

    /**
     *
     * @param type $view
     * @param array $data
     */
    public function render($view, array $data)
    {
        $this->output = $this->renderTemplate($view, $data);
        return $this->output;
    }

    /**
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    protected function renderTemplate($view, $data = array())
    {

        $this->startViewRender();

        foreach ($data as $key => $val) {
            //global ${$key};
            ${$key} = $val;
        }

        $viewPath = $this->viewPath . $view;

        $filename = $this->setTemplates(array_keys($data), $viewPath);

        if ($filename == NULL) {

            $filename = set_variables(array_keys($data));

            if (file_exists($filename)) {
                require $filename;
            }

            include_view($view);
        } else {
            include_once $filename;
        }

        return $this->endViewRender();
    }

    /**
     *
     * @param string $path
     * @param string $tempPath
     */
    public function setPaths($path, $tempPath = '')
    {
        $this->viewPath = strripos($path, '/') === strlen($path) - 1 ? $path : $path . '/';

        if ($tempPath == null) {
            $this->tempViewPath = $this->viewPath;
        } else {
            $this->tempViewPath = strripos($tempPath, '/') === strlen($tempPath) - 1 ? $tempPath : $tempPath . '/';
        }
    }

    /**
     *
     * @param string $basePath
     * @param string $cachePath
     * @param array $options
     * @return IView
     */
    public static function getInstance($basePath, $cachePath, array $options = array()): \Feather\View\IView
    {
        $engine = new Native();
        $engine->setPaths($basePath, $cachePath);
        return $engine;
    }

    /**
     *
     * @param array $keys
     * @param string $view
     * @return string
     */
    protected function setTemplates(array $keys, $view)
    {

        $viewFile = fopen($view, 'r');
        $contents = fread($viewFile, filesize($view));
        fclose($viewFile);

        $tempname = hash('sha256', $contents . implode('_', $keys));

        $filepath = $this->tempViewPath . "$tempname.php";

        if (file_exists($filepath)) {
            return $filepath;
        }

        $file = fopen($filepath, 'w');

        if ($file) {
            fwrite($file, "<?php \n");

            foreach ($keys as $key) {
                fwrite($file, "$$key;\n");
            }
            fwrite($file, "?>\n\n");
            fwrite($file, $contents);

            return $filepath;
        }
        return null;
    }

    /**
     *
     * @return string
     */
    protected function endViewRender()
    {
        return ob_get_clean();
    }

    /**
     * 
     */
    protected function startViewRender()
    {
        ob_start();
    }

}
