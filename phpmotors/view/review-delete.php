<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

    <?php
            if (isset($message)) {
                echo $message;
            }
        ?>    

    <h1> <?php if (isset($reviewInfo['invMake']) && isset($reviewInfo['invModel'])) {
                echo "$reviewInfo[invMake] $reviewInfo[invModel] Review";} ?></h1>
    <p>Reviewed on <?php if (isset($reviewInfo['reviewDate'])) { echo date("jS F, Y", strtotime($reviewInfo['reviewDate']));}?></p>
    <p class="error-message">Deleting a review is permanent. <br> Do you wish to proceed?</p> 

    <form method=post action='/phpmotors/reviews/index.php'>
        
        <label for='reviewText'>Review</label>
        <textarea name='reviewText' id='reviewText' rows='10' readonly><?php if(isset($reviewInfo['reviewText'])) {echo $reviewInfo['reviewText'];}?></textarea>

        <button type='submit' class='form-button'>Delete Review</button>
        <input type='hidden' name='action' value='review-delete'> 
        <input type='hidden' name='reviewId' value='<?php if(isset($reviewInfo['reviewId'])) { echo $reviewInfo['reviewId'];}?>'>
        <input type='hidden' name='clientId' value='<?php if(isset($reviewInfo['clientId'])) { echo $reviewInfo['clientId'];}?>'>
        <input type='hidden' name='invId' value='<?php if(isset($reviewInfo['invId'])) { echo $reviewInfo['invId'];}?>'>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>