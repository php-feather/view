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
     * @return string
     */
    public function render(string $view, array $data);
}
