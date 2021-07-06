<?php

/**
 * 'controller' that logs user out and redirects to main page
 */

include_once 'config.php';

$model = new UserModel();
$model->logout();

header('Location: '.ROOT_URL);