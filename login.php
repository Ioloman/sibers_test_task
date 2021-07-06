<?php

/**
 * login 'controller' that authenticates admin or provides login page
 * takes login and password parameters
 */

// this file defines autoload function, url constants and initializes session
include_once 'config.php';

// if the user is already logged in redirect to main page
if ($_SESSION['is_logged_in'])
    header('Location: '.ROOT_URL);

// if request method is GET return login page
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $template = new Template('templates/loginView.php');
    echo $template;

    // if request method is POST
} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // get sanitized POST parameters
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $model = new UserModel();

    // if logging in is successful redurect to main page
    if ($model->login($post)){
        header("Location: ".ROOT_URL);
    // if not successful return login page with a message
    } else {
        $template = new Template('templates/loginView.php');
        $template->message = 'Provided credentials are invalid or the user doesn\'t have necessary permissions ';
        echo $template;
    }
}