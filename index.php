<?php

include_once 'config.php';

$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$model = new UserModel();

$params = [];
$params['total'] = $model->getAmount()->total;
if (isset($get['show']) && is_numeric($get['show']))
    $params['show'] = (int) $get['show'];

if (isset($get['page']) && is_numeric($get['page'])){
    $params['page'] = (int) $get['page'];
    $show = isset($params['show']) ? $params['show'] : 10;
    if ($params['page'] > ($params['total'] / $show + ($params['total'] % $show ? 1 : 0))){
        header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
        echo "<h1>400 Bad Request</h1>";
        exit;
    }
    $params['offset'] = $show * ($params['page'] - 1);
    unset($show);
}

if (isset($get['sorting'])){
    switch($get['sorting'][0]){
        case 'a':
            $params['direction'] = 'ASC';
            break;
        case 'd':
            $params['direction'] = 'DESC';
            break;
    }
    $orderBy = substr($get['sorting'], 1);
    switch($orderBy){
        case 'created_at':
        case 'login':
            $params['orderBy'] = 'users.'.$orderBy;
            break;
        case 'last_name':
            $params['orderBy'] = 'ud.'.$orderBy;
            break;
    }
}


$users = $model->getUsers($params);
    
if (isset($get['entries']))
    $home_template = new Template('templates/entries.php');
else
    $home_template = new Template('templates/home.php');

$home_template->users = $users;
$home_template->show = isset($params['show']) ? $params['show'] : 10;
$home_template->page = isset($params['page']) ? $params['page'] : 1;
$home_template->total = $params['total'];
$home_template->sorting = isset($get['sorting']) ? $get['sorting'] : 'dcreated_at';
$home_template->roles = $model->getRoles();
echo $home_template;



