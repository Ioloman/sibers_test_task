<?php

include_once 'config.php';

$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$model = new UserModel();

$id = $model->createUser($post);

if ($id && $model->addUserData($id, $post)){
    $user = $model->getUser($id);
} else {
    throw new Exception('Couldn\'t create user');
}

$entryTemplate = new Template('templates/inc/entry.php');
$entryTemplate->user = $user;
echo $entryTemplate;
