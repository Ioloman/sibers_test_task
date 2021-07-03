<?php

spl_autoload_register(function (string $class_name){
    require_once 'src/' . $class_name . '.php';
});