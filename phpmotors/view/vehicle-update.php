<?php 

$clientLevel = $_SESSION['clientData']['clientLevel'];

//test if user is logged in
if ($clientLevel < 2) {
    header('Location: /phpmotors/index.php');
    exit;
}

//drop down menu for car classification on add vehicle page
$classificationList = '<select name="classificationId" class="class-select">';
$classificationList .= '<option>Select a Classification</option>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";

    if(isset($classificationId)) {
        if($classification['classificationId'] === $classificationId) {
            $classificationList .= ' selected ';
        }
    } else if (isset($invInfo['classificationId'])) {
        if ($classification['classificationId'] === $invInfo['classificationId']) {
            $classificationList .= 'selected';
        }
    }

    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .='</select>';
?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

    <?php
            if (isset($message)) {
                echo $message;
            }
        ?>    

    <h1><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "Modify $invInfo[invMake] $invInfo[invModel]"; }
              elseif (isset($invMake) && isset($invModel)) {
                echo "Modify $invMake $invModel";} ?></h1>

    <p class="required"><span>*</span>All fields are required</p>

    <form method="post" action="/phpmotors/vehicles/index.php" class="form">
        <label>Car Classification</label>
        <?php echo $classificationList; ?>

        <label for="invMake">Make</label>
        <input name="invMake" id="invMake" type="text" required
        <?php if(isset($invMake)) {echo "value='$invMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>

        <label for="invModel">Model</label>
        <input name="invModel" id="invModel" type="text" required
        <?php if(isset($invModel)) {echo "value='$invModel'";} elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; } ?>>

        <label for="invDescription">Description</label>
        <textarea name="invDescription" id="invDescription" rows="5" required><?php if(isset($invDescription)){echo $invDescription;} elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>

        <label for="invImage">Image</label>
        <input name="invImage" id="invImage" type="text" value="/phpmotors/images/no-image.php" required>

        <label for="invThumbnail">Thumbnail Image</label>
        <input name="invThumbnail" id="invThumbnail" type="text" value="/phpmotors/images/no-image.php" required>

        <label for="invPrice">Price</label>
        <input name="invPrice" id="invPrice" type="number" required 
        <?php if(isset($invPrice)) {echo "value='$invPrice'";} elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; }?>>

        <label for="invStock">Stock Number</label>
        <input name="invStock" id="invStock" type="number" required
        <?php if(isset($invStock)) {echo "value='$invStock'";} elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; }?>>

        <label for="invColor">Color</label>
        <input name="invColor" id="invColor" type="text" required
        <?php if(isset($invColor)) {echo "value='$invColor'";} elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?>>

        <button type="submit" class="form-button">Update Vehicle</button>
        <input type="hidden" name="action" value="updateVehicle"> 
        <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])) { echo $invInfo['invId'];} elseif (isset($invId)) {echo $invId;}?>">
    </form>
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>