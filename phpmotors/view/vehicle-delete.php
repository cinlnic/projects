<?php 

if ($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /phpmotors/index.php');
    exit;
}

?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

    <?php
            if (isset($message)) {
                echo $message;
            }
        ?>    

    <h1><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "Delete $invInfo[invMake] $invInfo[invModel]"; }
              elseif (isset($invMake) && isset($invModel)) {
                echo "Delete $invMake $invModel";} ?></h1>

    <p class="error-message">Confirm vehicle. All deletions are permanent.</p>

    <form method="post" action="/phpmotors/vehicles/index.php" class="form">
        
        <label for="invMake">Make</label>
        <input name="invMake" id="invMake" type="text" readonly
        <?php if(isset($invMake)) {echo "value='$invMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>

        <label for="invModel">Model</label>
        <input name="invModel" id="invModel" type="text" readonly
        <?php if(isset($invModel)) {echo "value='$invModel'";} elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; } ?>>

        <label for="invDescription">Description</label>
        <textarea name="invDescription" id="invDescription" rows="5" cols="53" readonly><?php if(isset($invDescription)){echo $invDescription;} elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>

        <button type="submit" class="form-button">Delete Vehicle</button>
        <input type="hidden" name="action" value="deleteVehicle"> 
        <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])) { echo $invInfo['invId'];} ?>">
    </form>
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>