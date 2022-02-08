<?php 
//Images upload controller
session_start();

//gets the database connection file
require_once '../library/connections.php';
//gets the php motors model 
require_once '../model/main-model.php';
//gets the vehicle model
require_once '../model/vehicle-model.php';
//gets the upload model
require_once '../model/uploads-model.php';
//gets the functions file
require_once '../library/functions.php';

//get array of classifications from database using model
$classifications = getClassifications();

//navigation bar using navList Funtion
$navList = navList($classifications);

$invInfo='';
$classificationName ='';

//changes page views
$action = filter_input (INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input (INPUT_GET, 'action');
}

/* * ****************************************************
* Variables for use with the Image Upload Functionality
* **************************************************** */
// directory name where uploaded images are stored
$image_dir = '/phpmotors/images/vehicles';
// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

switch ($action) {
    case 'upload':
        $invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT);
        $imgPrimary = filter_input(INPUT_POST, 'imgPrimary', FILTER_VALIDATE_INT);

        //store name of uploaded image
        $imgName = $_FILES['file1']['name'];
        
        $imgCheck = checkExistingImage($imgName);

        if ($imgCheck) {
            $message = '<p class="notice">An image by that name already exists.</p>';
        } elseif (empty($invId) || empty($imgName)) {
            $message = '<p class="notice">You must select a vehicle and image file for the vehicle.</p>';
        } else {
            //upload the image, store the returned path to the file
            $imgPath = uploadFile('file1');
            //Insert image info to the db, get the result
            $result = storeImages($imgPath, $invId, $imgName, $imgPrimary);

            //set a message based on insert results
            if ($result) {
                $message = '<p class="notice">The upload succeeded.</p>';
            } else {
                $message = '<p class="error-msg">Sorry, the upload failed.</p>';
            }
        }

        //store message to session
        $_SESSION['message'] = $message;
        header('location: .');
    break;
    
    case 'delete':
        $fileName = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
        $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);

        //build the full path to the image to be deleted
        $target = $image_dir_path . '/' . $fileName;

        //check that the file exists in that location
        if (file_exists($target)) {
            //deletes the file in that folder
            $result = unlink($target); 
        }

        //remove from db only if physical file deleted
        if ($result) {
            $remove = deleteImage($imgId);
        }

        //set a message based on delete results
        if ($remove) {
            $message = "<p class='notice'>$fileName was successfully deleted.</p>";
        } else {
            $message = "<p class='notice'>$file was NOT deleted.</p>";
        }

        $_SESSION['message'] = $message;
        header("location: .");

    break;

    default:
        //call function to return image info from db
        $imageArray = getImages();

        
        //build the image info into HTML for display
        if (count($imageArray)) {
            $imageDisplay = buildImageDisplay($imageArray);
        } else {
            $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
        }

        //Get vehicles info from db
        $vehicles = getVehicles();
        //Build a select list of vehicle info for the view
        $prodSelect = buildVehiclesSelect($vehicles);

        include '../view/image-admin.php';
        exit;
    break;
}