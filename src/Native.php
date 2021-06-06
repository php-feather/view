<?php

namespace Feather\View;

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

    /** @var int * */
    protected $obLevel;

    /**
     *
     * @var string
     */
    protected $tempViewPath;
    protected $output;

    /**
     *
     * @param string $baseDir Absolute path of base/root directory of views path
     * @param string $cacheDir
     */
    public function __construct(string $baseDir, $cacheDir = '')
    {
        $this->setPaths($baseDir, $cacheDir);
    }

    /**
     * Renders a PHP view
     * @param string $view View path relative to absolute path
     * @param array $data
     * @return string
     */
    public function render(string $view, array $data): string
    {
        try {
            $this->output = $this->renderTemplate($view, $data);
            return $this->output;
        } catch (\Exception $e) {
            while (ob_get_level() > $this->obLevel) {
                ob_end_clean();
            }
            throw new \RuntimeException($e->getMessage(), $e->getCode());
        }
    }

    /**
     *
     * @param string $view
     * @param array $data
     * @throws Exception
     * @return string
     */
    protected function renderTemplate($view, $data = array())
    {

        $this->startViewRender();

        foreach ($data as $key => $val) {
            ${$key} = $val;
        }

        $viewPath = $this->viewPath . $view;

        $filename = $this->setTemplates(array_keys($data), $viewPath);
        if ($view == 'home.php') {
            var_dump($viewPath, $filename);
            die;
        }
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
        $this->obLevel = ob_get_level();
        ob_start();
    }

}
