<?php

/**
 * 'controller' for the main page / or /index.php that displays a list of users.
 * takes a bunch of parameters such as order, page and how many users to display.php
 * the parameters are processed and then are passed to database model class.
 * resulting list of users is passed to a template.
 */

// this file defines autoload function, url constants and initializes session
include_once 'config.php';

// get sanitized GET parameters
$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$model = new UserModel();

// array of parameters to be passed to database model
$params = [];

// add total number of entries
$params['total'] = $model->getAmount()->total;

// add 'show' parameter (how many entries to display)
if (isset($get['show']) && is_numeric($get['show']))
    $params['show'] = (int) $get['show'];

// add 'page' and 'offset' parameter
if (isset($get['page']) && is_numeric($get['page'])){
    $params['page'] = (int) $get['page'];
    // set show parameter (it may not be passed from client)
    $show = isset($params['show']) ? $params['show'] : 10;
    // if the passed page is greater than actual last page return 400 status code
    if ($params['page'] > ($params['total'] / $show + ($params['total'] % $show ? 1 : 0))){
        header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
        echo "<h1>400 Bad Request</h1>";
        exit;
    }
    // calculate offset
    $params['offset'] = $show * ($params['page'] - 1);
    unset($show);
}

// convert 'sorting' parameter to direction and sorting parameters
// 'sorting' example - alogin
// it means order by login ascending
if (isset($get['sorting'])){
    // parse ascending/descending part
    switch($get['sorting'][0]){
        case 'a':
            $params['direction'] = 'ASC';
            break;
        case 'd':
            $params['direction'] = 'DESC';
            break;
    }
    // parse 'sorting' part
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

// fetch desired list of entries
$users = $model->getUsers($params);
    
// if parameter 'entries' is set than it is AJAX request
// and only rendered list of users has to be returned
// otherwise return full amin page
// the template is chosen based on above
if (isset($get['entries']))
    $home_template = new Template('templates/entries.php');
else
    $home_template = new Template('templates/home.php');

// pass all the necessary data to the template
// for example $home_template->users will be available by just $users name
$home_template->users = $users;
$home_template->show = isset($params['show']) ? $params['show'] : 10;
$home_template->page = isset($params['page']) ? $params['page'] : 1;
$home_template->total = $params['total'];
$home_template->sorting = isset($get['sorting']) ? $get['sorting'] : 'dcreated_at';
$home_template->roles = $model->getRoles();

// render the template
echo $home_template;



