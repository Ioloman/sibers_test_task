<?php

/**
 * 'controller' for user creating
 * takes all user data from parameters
 * meant only for AJAX request
 */

include_once 'config.php';

// get sanitized POST parameters
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$model = new UserModel();

// create user, save id
$id = $model->createUser($post);

// if user is created and user's data is added successfully fetch user
if ($id && $model->addUserData($id, $post)){
    $user = $model->getUser($id);
// else throw an exception
} else {
    throw new Exception('Couldn\'t create user');
}

// return single entry html for further javascript processing
$entryTemplate = new Template('templates/inc/entry.php');
$entryTemplate->user = $user;
echo $entryTemplate;
