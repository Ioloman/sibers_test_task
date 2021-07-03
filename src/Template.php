<?php

/**
 * class that represents template
 */
class Template{
    /**
     * path to the template
     *
     * @var string
     */
    protected $path;

    /**
     * variables passed to the template
     *
     * @var array
     */
    protected $vars = array();

    /**
     * constructor that takes a path to the template
     *
     * @param string $template
     */
    public function __construct(string $template){
        $this->path = $template;
    }

    /**
     * property getter to set template variables
     *
     * @param string|int $key
     * @return mixed
     */
    public function __get($key){
        return $this->vars[$key];
    }

    /**
     * property setter to set template variables
     *
     * @param string|int $key
     * @param mixed $value
     */
    public function __set($key, $value){
        $this->vars[$key] = $value;
    }

    /**
     * magic method that returns the template with all variables pasted
     *
     * @return string
     */
    public function __toString(){
        extract($this->vars);
        chdir(dirname($this->path));
        ob_start();
        include basename($this->path);
        return ob_get_clean();
    }
}