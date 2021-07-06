<?php

include_once 'config.php';

$model = new UserModel();
$model->logout();

header('Location: '.ROOT_URL);