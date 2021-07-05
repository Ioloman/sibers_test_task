<?php

include_once 'config.php';

$db = new Database();

$home_template = new Template('templates/home.php');
$home_template->name = 'kirill';
echo $home_template;



