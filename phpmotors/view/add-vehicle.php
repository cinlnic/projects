<?php 

if ($_SESSION['clientData']['clientLevel'] < 2) {
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

    <h1>Add a Vehicle</h1>

    <p class="required"><span>*</span>All fields are required</p>

    <form method="post" action="/phpmotors/vehicles/index.php" class="form">
        <label>Car Classification</label>
        <?php echo $classificationList; ?>

        <label for="invMake">Make</label>
        <input name="invMake" id="invMake" type="text" required
        <?php if(isset($invMake)) {echo "value='$invMake'";} ?>>

        <label for="invModel">Model</label>
        <input name="invModel" id="invModel" type="text" required
        <?php if(isset($invModel)) {echo "value='$invModel'";} ?>>

        <label for="invDescription">Description</label>
        <textarea name="invDescription" id="invDescription" rows="5" cols="53" required><?php if(isset($invDescription)){echo $invDescription;}?></textarea>

        <label for="invImage">Image</label>
        <input name="invImage" id="invImage" type="text" value="/phpmotors/images/vehicles/no-image.php" required>

        <label for="invThumbnail">Thumbnail Image</label>
        <input name="invThumbnail" id="invThumbnail" type="text" value="/phpmotors/images/vehicles/no-image.php" required>

        <label for="invPrice">Price</label>
        <input name="invPrice" id="invPrice" type="number" required 
        <?php if(isset($invPrice)) {echo "value='$invPrice'";} ?>>

        <label for="invStock">Stock Number</label>
        <input name="invStock" id="invStock" type="number" required
        <?php if(isset($invStock)) {echo "value='$invStock'";} ?>>

        <label for="invColor">Color</label>
        <input name="invColor" id="invColor" type="text" required
        <?php if(isset($invColor)) {echo "value='$invColor'";} ?>>

        <button type="submit" class="form-button">Add Vehicle</button>
        <input type="hidden" name="action" value="add-vehicle-info">
    </form>
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>