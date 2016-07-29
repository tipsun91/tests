<?php

namespace App\Component;


class View
{

     protected $layout;

    // protected $_args;

    // public function set($key, $value)
    // {
        // $this->_args[$key] = $value;
    // }

    // public function get($key)
    // {
        // return $this->_args[$key];
    // }

    // public function rid($key)
    // {
        // if (isset($this->_args[$key])) {
			// unset($this->_args[$key]);
		// }
    // }

    public function getFolderTemplate()
    {
        return ROOT_DIR.'/src/Resources/view/template/';
    }

    public function getFolderLayout()
    {
        return ROOT_DIR.'/src/Resources/view/layout/';
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function getLayout()
    {
        return $this->getFolderLayout() . ((null === $this->layout) ? 'default.layout.php' : $this->layout);
    }

    public function fetch($template, $args)
    {
        ob_start();
			extract($args, EXTR_PREFIX_SAME, '_'); // extract($args, EXTR_OVERWRITE);
            $_template = $this->getFolderTemplate() . $template;
            include($this->getLayout());
        return ob_get_clean();
    }

    /*******************************************************************************
    public function fetch($template) {
        ob_implicit_flush(0);
        ob_start();
            self::display($template, $this->_args);
            $contents = ob_get_contents();
        ob_end_clean();
        ob_implicit_flush(1);
    return $contents;
    }
     *******************************************************************************/

    // public function display($template, $args)
    // {
		// echo $this->fetch($template, $args);
    // }
}
