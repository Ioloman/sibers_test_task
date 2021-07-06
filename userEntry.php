<?php

include_once 'config.php';

if (!$_SESSION['is_logged_in']){
    header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden", true, 403);
    echo "<h1>403 Forbidden</h1>";
    exit;
}

$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$model = new UserModel();

$userTemplate = new Template('templates/user.php');
$userTemplate->user = $model->getUser($get['id']);
$userTemplate->roles = $model->getRoles();
echo $userTemplate;