<?php

include_once 'config.php';

$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$model = new UserModel();

foreach($post as $key => $value){
    if ($value == "")
        unset($post[$key]);
}

if ($model->updateUser($post)){
    header("Location: ".ROOT_URL);
    exit();
}
else{
    header($_SERVER["SERVER_PROTOCOL"]." 523 Origin Is Unreachable ", true, 523);
    echo "<h1>523 Origin Is Unreachable </h1>";
    exit;
}