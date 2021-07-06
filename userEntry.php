<?php

include_once 'config.php';

$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$model = new UserModel();

$userTemplate = new Template('templates/user.php');
$userTemplate->user = $model->getUser($get['id']);
$userTemplate->roles = $model->getRoles();
echo $userTemplate;