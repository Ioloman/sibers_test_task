<?php

/**
 * 'controller' to update user
 * meant only for request from form
 * takes all user information from request
 */

include_once 'config.php';

// get sanitized POST parameters
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$model = new UserModel();

// unset empty fields
foreach($post as $key => $value){
    if ($value == "")
        unset($post[$key]);
}

// if update is successful redirect to the main page
if ($model->updateUser($post)){
    header("Location: ".ROOT_URL.$post['url']);
    exit();
}
// if update is unsuccessful return 523 status code
else{
    header($_SERVER["SERVER_PROTOCOL"]." 523 Origin Is Unreachable ", true, 523);
    echo "<h1>523 Origin Is Unreachable </h1>";
    exit;
}