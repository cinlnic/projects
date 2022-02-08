<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

    <?php
            if (isset($message)) {
                echo $message;
            }
        ?>    

    <h1> <?php if (isset($invMake) && isset($invModel)) { echo "$invMake $invModel" ; } 
                elseif(isset($reviewInfo['invMake']) && isset($reviewInfo['invModel'])) {
                echo "$reviewInfo[invMake] $reviewInfo[invModel] Review";} ?></h1>
    <p>Reviewed on <?php if (isset($reviewDate)) {echo $reviewDate; } elseif(isset($reviewInfo['reviewDate'])) { echo date("jS F, Y", strtotime($reviewInfo['reviewDate']));}?></p>

    <form method=post action='/phpmotors/reviews/index.php'>
        
        <label for='reviewText'>Review</label>
        <textarea name='reviewText' id='reviewText' rows='10' required><?php if(isset($reviewText)) {echo $reviewText; } elseif(isset($reviewInfo['reviewText'])) {echo $reviewInfo['reviewText'];} ?></textarea>

        <button type='submit' class='form-button'>Submit Update</button>
        <input type='hidden' name='action' value='review-update'> 
        <input type='hidden' name='reviewId' value='<?php if(isset($reviewId)) {echo $reviewId; } elseif(isset($reviewInfo['reviewId'])) { echo $reviewInfo['reviewId'];}?>'>
        <input type='hidden' name='clientId' value='<?php if(isset($clientId)) {echo $clientId; } elseif(isset($reviewInfo['clientId'])) { echo $reviewInfo['clientId'];}?>'>
        <input type='hidden' name='invId' value='<?php if(isset($invId)) {echo $invId; } elseif(isset($reviewInfo['invId'])) { echo $reviewInfo['invId'];}?>'>
    </form>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>