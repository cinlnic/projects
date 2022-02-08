<?php

//Vehicles controller

//create or access session
session_start();

//gets the database connection file
require_once '../library/connections.php';
//gets the php motors model 
require_once '../model/main-model.php';
//gets the vehicle model
require_once '../model/vehicle-model.php';
//gets the functions file
require_once '../library/functions.php';
//gets the upload model
require_once '../model/uploads-model.php';
//gets the review model
require_once '../model/reviews-model.php';

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
    case 'add-classification':
        include '../view/add-classification.php';
    break;

    case 'add-class':
        $classificationName = filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING);

        //check for missing data
        if (empty($classificationName)) {
            $message = "<p class='error-message'>Please enter a classification name.</p>";
            include '../view/add-classification.php';
            exit;
        }

        //send data to the model
        $addClassOutcome = addClassification($classificationName);
        
        //check and report the result
        if ($addClassOutcome === 1) {
            header('Location: ../vehicles/index.php');
            exit;
        } else {
            $message = "<p class='error-message'>Sorry adding the $classificationName classification failed. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        }
    break;

    case 'add-vehicle':
        include '../view/add-vehicle.php';
    break;   

    case 'add-vehicle-info':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_URL);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_URL);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
        $classificationId= filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);

        //check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = "<p class='error-message'>Please complete all fields.</p>";
            include '../view/add-vehicle.php';
            exit;
        }

        //send data to the model
        $addVehicleOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
        
        //check and report the result
        if ($addVehicleOutcome === 1) {
            $message = "<p class='login-message'>The $invMake $invModel has been added to the inventory.</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p class='error-message'>Sorry adding the $invMake $invModel failed. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
    break;

    case 'getInventoryItems':
        //get classification Id
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        //fetch vehicles by classificationId from db
        $inventoryArray = getInventoryByClassifications($classificationId);
        //convert array to JSON object and send it back
        echo json_encode($inventoryArray);
    break;

    case 'mod':
        //get inventory id
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        //call function to store vehicle info based on id number
        $invInfo = getInvItemInfo($invId);

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
    break;

    case 'updateVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_URL);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_URL);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
        $classificationId= filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        //check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = "<p class='error-message'>Please complete all fields.</p>";
            include '../view/vehicle-update.php';
            exit;
        }

        //send data to the model
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        
        //check and report the result
        if ($updateResult) {
            $message = "<p class='notice'>The $invMake $invModel has been updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='error-message'>Sorry the $invMake $invModel update failed. Please try again.</p>";
            include '../view/vehicle-update.php';
            exit;
        }

    break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
    break;

    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations, the $invMake $invModel was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='error-message'>Error: $invMake $invModel was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        
    break;

    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);

        if (!count($vehicles)) {
            $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehicleDisplay = buildVehicleDisplay($vehicles);
        }
        include '../view/classification.php';
    break;

    case 'vehicle-detail':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $invInfo = getVehicleDetail($invId);

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';   
        } else {
            $vehicleDetails = buildVehicleDetail($invInfo);
        }

        $imagePath = getThumbnails($invId);

        if (count($imagePath) >= 1) {
            $vehicleImages = buildVehicleThumbnails($imagePath);
        }

        //build review form
        if (isset($_SESSION['loggedin'])) {
            $reviewForm = buildReviewForm($invInfo);
        } else {
            $reviewForm = '<p class="review-p">Please <a href="/phpmotors/accounts/index.php?action=login-page" title="Go to login page">log in</a> to add a review.</p>';
        }

        $reviews = getReviewsByinvId($invId);
        // print_r($reviews);
        // var_dump($reviews);
        // exit;

        if (count($reviews) > 0) {
            $addReviews = buildReviews($reviews);
        } else {
            $addReviews = "<p class='review-p'>Be the first to review the $invInfo[invMake] $invInfo[invModel]</p>";  
        }

        include '../view/vehicle-detail.php';
    break;


    default: 
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicle-management.php';
    break;
}