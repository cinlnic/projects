<?php

//function to build dynamic navigation menu
function navList($classifications) {
    $navList = '<ul class = "navigation">';
    $navList .= "<li><a href='/phpmotors/' title='View of the PHP Motors home page'>Home</a></li>";

    foreach ($classifications as $classification) {
    $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])." ' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }

    $navList .= '</ul>';
    return $navList;
}

//function to validate email input
function checkEmail($clientEMail) {
    $valEmail = filter_var($clientEMail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

//function for password validation
function checkPassword($clientPassword) {
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

//build the classification select list for vehicle management page
function buildClassificationList($classifications) {
    $classificationList = '<select name="classificationId" id="classificationList">';
    $classificationList .= "<option>Select a Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
    return $classificationList;
}

//title function
function getTitle($action, $invInfo, $classificationName) {
    $title = '<title>';
    switch($action) {
        case 'del':
            if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                $title .= "Delete $invInfo[invMake] $invInfo[invModel] | "; }
              elseif (isset($invMake) && isset($invModel)) {
                $title .="Delete $invMake $invModel | ";} 
        break;
            
        case 'mod':
            if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                $title .= "Modify $invInfo[invMake] $invInfo[invModel] | "; }
              elseif (isset($invMake) && isset($invModel)) {
                $title .="Modify $invMake $invModel | ";}
         break;

         case 'classification':
            $title .= "$classificationName Vehicles | ";
        break;

        case 'vehicle-detail':
            $title .= "$invInfo[invMake] $invInfo[invModel] | ";
        break;

        case 'image-admin':
            $title .= "Image Management | ";
        break;
    }
        $title .= 'PHP Motors</title>';
        return $title;
    }

    //build vehicles html 
    function buildVehicleDisplay($vehicles) {
        $dv= '<ul id="inv-display">';
        foreach ($vehicles as $vehicle) {
            $price = number_format($vehicle['invPrice'], 2, '.', ',');
            $dv .= "<li><a href='/phpmotors/vehicles/?action=vehicle-detail&id=$vehicle[invId]' title='See $vehicle[invMake] $vehicle[invModel] details'>";
            $dv .= "<img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
            $dv .= '<hr>';
            $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
            $dv .= "<p>$$price<p>";
            $dv .= '</a></li>';
        }
        $dv .='</ul>';
        return $dv;
    }

    function buildVehicleDetail($invInfo) {
        $price = number_format($invInfo['invPrice'], 2, '.', ',');
        $vehicleDetail = "<section class='vehicle-info'>";
        $vehicleDetail .= "<img src='$invInfo[imgPath]' alt='Image of $invInfo[invMake] $invInfo[invModel]' class='vehicle-img'>";  
        $vehicleDetail .= "<h2>$$price</h2>";
        $vehicleDetail .= "<p>Color: $invInfo[invColor]";
        $vehicleDetail .= "<p>$invInfo[invDescription]</p>";
        $vehicleDetail .= '</section>';

        return $vehicleDetail;
    }

    //add vehicle thumbnail images to detail page
    function buildVehicleThumbnails($imagePath) {
        $vehicleImages = '<section id="vehicle-tn">';
        $vehicleImages .= '<h3>Additional Images</h3>';
        $vehicleImages .= '<ul>';
        foreach ($imagePath as $path) {
            $vehicleImages .= '<li>';
            $vehicleImages .= "<img src=$path[imgPath] alt='$path[imgName] on PHP Motors'>";
            $vehicleImages .= '</li>';
        }
        $vehicleImages .= '</ul>';
        $vehicleImages .= '</section>';
        return $vehicleImages;
    }

    function buildReviewForm($invInfo){
        $clientFirstname = substr($_SESSION['clientData']['clientFirstname'], 0, 1);
        $clientLastname = $_SESSION['clientData']['clientLastname'];
        $clientId = $_SESSION['clientData']['clientId'];
        $form = "<p class='review-p'>Review the  $invInfo[invMake] $invInfo[invModel]";
        $form .= "<form method=post action='/phpmotors/reviews/index.php'>";
        $form .= "<label for='screenName'>Screen Name</label>";
        $form .= "<input name='screenName' id='screenName' type='text' readonly value='$clientFirstname$clientLastname'>";
        $form .= "<label for='reviewText'>Review</label>";
        $form .= "<textarea name='reviewText' id='reviewText' rows='10' required></textarea>";
        $form .= "<button type='submit' class='form-button'>Submit Review</button>";
        $form .= "<input type='hidden' name='action' value='add-review'>";
        $form .= "<input type='hidden' name='invId' value='$invInfo[invId]'>";
        $form .= "<input type='hidden' name='clientId' value='$clientId'>";
        $form .= "</form> "; 
        return $form;
    }

    function buildReviews($reviews) {
        $reviewDetail = '<ul id="review-detail">';
        foreach ($reviews as $review) {
            $clientFirstname = substr($review['clientFirstname'], 0, 1);
            $clientLastname = $review['clientLastname'];
            $date = date("jS F, Y", strtotime($review['reviewDate']));
            $reviewDetail .= '<li>';
            $reviewDetail .= "<h4>$clientFirstname$clientLastname</h4>";
            $reviewDetail .= "<p class='review-date'>Reviewed on $date</p>";
            $reviewDetail .= "<p>$review[reviewText]</p>";
            $reviewDetail .= '</li>';
        }
        $reviewDetail .= '</ul>';
        return $reviewDetail;
    } 

    function displayClientReviews($reviewsById) {
        $clientReviews = '<ul id="client-reviews">';
        foreach ($reviewsById as $review) {
            $date = date("jS F, Y", strtotime($review['reviewDate']));
            $clientReviews .= "<li>$review[invMake] $review[invModel] reviewed on $date:  
                                <a href='/phpmotors/reviews?action=update&id=$review[reviewId]' title='Click to Update'>Update</a>  |  
                                <a href='/phpmotors/reviews?action=delete&id=$review[reviewId]' title='Click to Delete'>Delete</a></li>";
        }
        $clientReviews .= '</ul>';
        return $clientReviews;
    }

/* * ********************************
*  Functions for working with images
* ********************************* */

    //adds -tn designation to the file name
    function makeThumbnailName($image) {
        $i = strrpos($image, '.');
        $image_name = substr($image, 0, $i);
        $ext = substr($image, $i);
        $image = $image_name . "-tn" . $ext;
        return $image;
    }

    //build images display for image management view
    function buildImageDisplay($imageArray) {
        $id = '<ul id="image-display">';
        foreach ($imageArray as $image) {
            $id .= '<li>';
            $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHPMotors.com' alt='$image[invMake] $image[invModel] image on PHPMotors.com'>";
            $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
            $id .= '</li>';
        }
        $id .= '</ul>';
        return $id;
    }

    //build the vehicle select list
    function buildVehiclesSelect($vehicles) {
        $prodList = '<select name="invId" id="invId">';
        $prodList .= "<option>Choose a Vehicle</option>";
        foreach ($vehicles as $vehicle) {
            $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
        }
        $prodList .= '</select>';
        return $prodList;
    }

    //handles the file upload proccess and returns the path
    //the file path is stored in the db
    function uploadFile($name) {
        //gets the paths, full and local directory
        global $image_dir, $image_dir_path;
        if (isset($_FILES[$name])) {
            //gets the actual file name
            $filename = $_FILES[$name]['name'];
            
            if (empty($filename)) {
                return;
            }

            //get the file from the temp folder on the server
            $source = $_FILES[$name]['tmp_name'];
            //sets the new path - images folder in this directory
            $target = $image_dir_path . '/' . $filename;
            //moves the file to the target folder
            move_uploaded_file($source, $target);
            //send file for further processing
            processImage($image_dir_path, $filename);
            //sets the path for the image for db storage
            $filepath = $image_dir . '/' . $filename;
            //returns the path where the file is stored
            return $filepath;
        }
    }

    //processes images by getting paths and creating smaller versions of the image
    function processImage($dir, $filename) {
        //set up the variables
        $dir = $dir . '/';
        
        //set the image path
        $image_path = $dir . $filename;

        //set up the thumbnail image path
        $image_path_tn = $dir.makeThumbnailName($filename);

        //create a thumbnail image that's a max of 200px square
        resizeImage($image_path, $image_path_tn, 200, 200);

        //resize original to a max of 50px square
        resizeImage($image_path, $image_path, 500, 500);
    }

    //checks and resizes images
    function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
        //get the image type
        $image_info = getimagesize($old_image_path);
        $image_type = $image_info[2];

        //set up the function names
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                $image_from_file = 'imagecreatefromjpeg';
                $image_to_file = 'imagejpeg';
            break;
            case IMAGETYPE_GIF:
                $image_from_file = 'imagecreatefromgif';
                $image_to_file = 'imagegif';
            break;
            case IMAGETYPE_PNG:
                $image_from_file = 'imagecreatefrompng';
                $image_to_file = 'imagepng';
            break;
            default:
                return;
        } //ends the switch

        //get the old image and its height and width
        $old_image = $image_from_file($old_image_path);
        $old_width = imagesx($old_image);
        $old_height = imagesy($old_image);

        //calculate the height and width ratios
        $width_ratio = $old_width / $max_width;
        $height_ratio = $old_height / $max_height;

        //if image is larger than specified ratio, create the new image
        if ($width_ratio > 1 || $height_ratio > 1) {
            //calculate the height and width for the new image
            $ratio = max($width_ratio, $height_ratio);
            $new_height = round($old_height / $ratio);
            $new_width = round($old_width / $ratio);

            //create the new image
            $new_image = imagecreatetruecolor($new_width, $new_height);

            //set transparency according to image typ
            if ($image_type == IMAGETYPE_GIF) {
                $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
                imagecolortransparent($new_image, $alpha);
            }

            if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
                 imagealphablending($new_image, false);
                 imagesavealpha($new_image, true);
            }

            //copy old image to new image - this resizes the image
            $new_x = 0;
            $new_y = 0;
            $old_x = 0;
            $old_y = 0;
            imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

            //write the image to a new file
            $image_to_file($new_image, $new_image_path);
            //free any memory associated with new image
            imagedestroy($new_image);   
        } else {
            //write old image to a new file
            $image_to_file($old_image, $new_image_path);
        }
        //free any memory associated with old image
        imagedestroy($old_image);
    } //ends image resize function

?> 