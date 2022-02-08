<?php
//Reviews Controller

session_start();

//gets the database connection file
require_once '../library/connections.php';
//gets the php motors model 
require_once '../model/main-model.php';
//gets the review model
require_once '../model/reviews-model.php';
//gets the vehicle model
require_once '../model/vehicle-model.php';
//gets the functions file
require_once '../library/functions.php';

//get array of classifications from database using model
$classifications = getClassifications();

// var_dump($classifications);
// exit;

//navigation bar using navList Funtion
$navList = navList($classifications);

$invInfo='';
$classificationName ='';

//changes page views
$action = filter_input (INPUT_GET, 'action');

if ($action == NULL) {
    $action = filter_input (INPUT_POST, 'action');
}


switch ($action) {
    case 'add-review':
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT); 
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);

        if (empty($invId) || empty($clientId) || empty($reviewText)) {
            $message = "<p class='error-message'>Please complete the review.</p>";
            $_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/?action=vehicle-detail&id=$invId");
            exit;
        }

        //send review to db
        $addResults = addReview($invId, $clientId, $reviewText);

        //check and report the result
        if ($addResults) {
            $message = "<p class='notice'>The $invMake $invModel review has been added.</p>";
            $_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/?action=vehicle-detail&id=$invId");
            exit;
        } else {
            $message = "<p class='error-message'>Sorry the $invMake $invModel update failed. Please try again.</p>";
            include '../view/vehicle-detail.php';
            exit;
        }

    break;

    case 'update':
        $reviewId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $reviewInfo = getReviewById($reviewId);

        if (count($reviewInfo) < 1) {
            $message = 'Sorry, something went wrong. That review could not be found.';
        }

        include '../view/review-update.php';

    break;

    case 'review-update':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        $reviewInfo = getReviewById($reviewId);

        if (empty($reviewId) || empty($reviewText) || empty($invId) || empty($clientId)) {
            $message = "<p class='error-message'>Please update the review.</p>";
            include '../view/review-update.php';
            exit;
        }
        
        $updateResult = updateReview($reviewId, $reviewText, $invId, $clientId);

        if ($updateResult === 1) {
            $message = "<p class='notice'>Your review has been updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts/?action=admin');
            exit;
        } else {
            $message = "<p class='error-message'>Sorry the review update failed. Please update the review.</p>";
            include '../view/review-update.php';
            exit;
        }

    break;

    case 'delete':
        $reviewId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $reviewInfo = getReviewById($reviewId);

        if (count($reviewInfo) < 1) {
            $message = 'Sorry, something went wrong. That review could not be found.';
        }

        include '../view/review-delete.php';
    break;

    case 'review-delete':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteReview($reviewId);

        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations, your review was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts/');
            exit;
        } else {
            $message = "<p class='error-message'>Error: the review was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts/');
            exit;
        }

    break;

    default:
        if ($_SESSION['loggedin']) {
            header('Location: ../accounts/');
            exit;
        } else {
            include '../view/home.php';
        }
    break;
}

