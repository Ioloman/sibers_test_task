<?php

/**
 * registering autoload function;
 * include this file to autoload classes from src/ directory;
 */
spl_autoload_register(function (string $class_name){
    require_once 'src/' . $class_name . '.php';
});

session_start();

define('ROOT_URL', '/index.php');

define('USER_URL', '/userEntry.php');

define('DELETE_URL', '/deleteUser.php');

define('UPDATE_URL', '/updateUser.php');

define('LOGIN_URL', '/login.php');

define('LOGOUT_URL', '/logout.php');