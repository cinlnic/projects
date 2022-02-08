<?php

//Main site controller

//create or access session
session_start();

//gets the database connection file
require_once 'library/connections.php';
//gets the php motors model 
require_once 'model/main-model.php';
//gets the functions file
require_once 'library/functions.php';

//get array of classifications from database using model
$classifications = getClassifications();

//navigation bar using navList function
$navList = navList($classifications);

$invInfo='';
$classificationName='';

//controller to swith views
$action = filter_input (INPUT_GET, 'action');

if ($action == NULL) {
    $action = filter_input (INPUT_POST, 'action');
}

if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
} 

switch ($action) {
    case 'template':
        include 'view/template.php';
        break;
    default:
        include 'view/home.php';
}

?>