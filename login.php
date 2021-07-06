<?php

include_once 'config.php';

if ($_SESSION['is_logged_in'])
    header('Location: '.ROOT_URL);

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $template = new Template('templates/loginView.php');
    echo $template;
} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $model = new UserModel();
    if ($model->login($post)){
        header("Location: ".ROOT_URL);
    } else {
        $template = new Template('templates/loginView.php');
        $template->message = 'Provided credentials are invalid or the user doesn\'t have necessary permissions ';
        echo $template;
    }
}