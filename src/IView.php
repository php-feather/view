<?php

namespace Feather\View;

/**
 *
 * @author fcarbah
 */
interface IView
{

    /**
     *
     * @param string $view
     * @param array $data
     */
    public function render($view, array $data);
}
