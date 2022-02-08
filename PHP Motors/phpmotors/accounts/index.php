<?php

//Accounts controller

//create or access session
session_start();

//gets the database connection file
require_once '../library/connections.php';
//gets the php motors model 
require_once '../model/main-model.php';
//gets the accounts model
require_once '../model/accounts-model.php';
//gets the reviews model
require_once '../model/reviews-model.php';
//gets the function library
require_once '../library/functions.php';

//get array of classifications from database using model
$classifications = getClassifications();

//navigation bar using navList function
$navList = navList($classifications);

//changes page views
$action = filter_input (INPUT_GET, 'action');

$invInfo='';
$classificationName='';

if ($action == NULL) {
    $action = filter_input (INPUT_POST, 'action');
}

switch ($action) {
    case 'login-page':
        include '../view/login.php';
        break;

    case 'login':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        //check for missing data
        if (empty($checkPassword) || empty($clientEmail)) {
            $message = "<p class='error-message'>Please provide information for all empty fields.</p>";
            include '../view/login.php';
            exit;
        }

        //a valid password exists, proceed with login process
        //query the client data based on email
        $clientData = getClient($clientEmail);
        //compare password submitted against hashed password for client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);

        //if hashes don't match send error and return to the login view
        if(!$hashCheck) {
            $message = '<p class="error-message">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }

        //valid user exists, log them in --- this creates a flag in the session name loggedin with a value of TRUE
        $_SESSION['loggedin'] = TRUE;
        //Remove password from array
        array_pop($clientData);
        //store the array into a session
        $_SESSION['clientData'] = $clientData;

        //get reviews by clientId and display on the page
        $reviewsByClientId = getReviewsByClientId($_SESSION['clientData']['clientId']);

        if (count($reviewsByClientId) > 0) {
            $clientReviews = displayClientReviews($reviewsByClientId);
        } else {
            $clientReviews =  '<p><i>Visit a vehicle page to leave a review.</i></p>';
        }

        //send them to the admin view
        include '../view/admin.php';
        exit;
        break;

    case 'registration':
        include '../view/registration.php';
        break;
        
    case 'register':
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        //check if email already exists
        $existingEmail = checkExistingEmail($clientEmail);
        
        if ($existingEmail) {
            $message = "<p class='error-message'>That email address already exists. Do you want to login?</p>";
            include '../view/login.php';
            exit;
        }

        //check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($checkPassword) || empty($clientEmail)) {
            $message = "<p class='error-message'>Please provide information for all empty fields.</p>";
            include '../view/registration.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        //send data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
        
        //check and report the result
        if ($regOutcome === 1) {

            //create cookie
            setcookie('firstname', $clientFirstname, strtotime('+ 1 year'), '/' );

            $_SESSION['message'] = "<p class='login-message'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $message = "<p class='error-message'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        break;
    
    case 'updateAccount':
        include '../view/client-update.php';
    break;

    case 'updateAccountInfo':
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        if ($clientEmail != $_SESSION['clientData']['clientEmail']) {
            $existingEmail = checkExistingEmail($clientEmail);
        
            if ($existingEmail) {
                $message = "<p class='error-message'>That email address already exists. Do you want to login?</p>";
                include '../view/login.php';
                exit;
            }
        }

        //check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId)) {
            $message = "<p class='error-message'>Please provide information for all empty fields.</p>";
            include '../view/client-update.php';
            exit;
        }
 
        //send new data to the model
        $updateOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

        if ($updateOutcome === 1) {

            $_SESSION['message'] = "<p class='login-message'>Your information has been updated.</p>";

            //query new data based on Id
            $clientData = getClientInfo($clientId);
            //Remove password from array
            array_pop($clientData);
            //store the array into a session
            $_SESSION['clientData'] = $clientData;
            //send them to the admin view
            header('Location: /phpmotors/accounts/?action=admin');
            exit;
        } else {
            $message = "<p class='error-message'>Sorry $clientFirstname, but the update failed. Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }  
    break;

    case 'changePassword':
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        $checkPassword = checkPassword($clientPassword);

        if (empty($checkPassword)) {
            $message = "<p class='error-message'>Please enter a valid password.</p>";
            include '../view/client-update.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $updatePasswordOutcome = updatePassword($hashedPassword, $clientId);

        if ($updatePasswordOutcome) {

            $_SESSION['message'] = "<p class='login-message'>Your passowrd has been updated, $clientFirstname.</p>";
            header('Location: /phpmotors/accounts/?action=admin');
            exit;
        } else {
            $message = "<p class='error-message'>Sorry $clientFirstname, but the password update failed. Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }
    break;

    case 'logout':
        unset($_SESSION['clientData']);
        session_destroy();
        header('Location: /phpmotors/index.php');
        
    default:
        //get reviews by clientId and display on the page
        $reviewsByClientId = getReviewsByClientId($_SESSION['clientData']['clientId']);

        if (count($reviewsByClientId) > 0) {
            $clientReviews = displayClientReviews($reviewsByClientId);
        } else {
            $clientReviews =  '<p><i>Visit a vehicle page to leave a review.</i></p>';
        }

        include '../view/admin.php';
        break;
}

?>