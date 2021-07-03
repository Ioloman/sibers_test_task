<?php

/**
 * registering autoload function;
 * include this file to autoload classes from src/ directory;
 */
spl_autoload_register(function (string $class_name){
    require_once 'src/' . $class_name . '.php';
});