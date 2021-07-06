<?php

/**
 * 'controller' for user deletion
 * takes id parameter and form parameters
 * if form parameter is set it is POST request from form, otherwise it is AJAX request
 */

include_once 'config.php';

// get sanitized POST parameters
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$model = new UserModel();

// if request from form 
if ($post['form'] === "true"){
    // if deletion is successful redirect to the main page
    if ($model->deleteUser($post['id']))
        header("Location: ".ROOT_URL);
    // if not return 404 status code
    else{
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        echo "<h1>404 Not Found</h1>";
        exit;
    }
    // if AJAX request
} else {
    if ($model->deleteUser($post['id']))
        echo 'Done';
    else
        echo 'Error';
}