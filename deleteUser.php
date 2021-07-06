<?php

include_once 'config.php';

$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$model = new UserModel();

if ($post['form'] === "true"){
    if ($model->deleteUser($post['id']))
        header("Location: ".ROOT_URL);
    else{
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        echo "<h1>404 Not Found</h1>";
        exit;
    }
} else {
    if ($model->deleteUser($post['id']))
        echo 'Done';
    else
        echo 'Error';
}