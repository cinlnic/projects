<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        
        
        <h1><?php echo $invInfo['invMake'] ." ". $invInfo['invModel']; ?></h1>

        <?php if (isset($message)) {
                echo $message;} ?> 

        <div class="vehicle-details">
                <?php if(isset($vehicleImages)){
                        echo $vehicleImages;}?>

                <?php if(isset($vehicleDetails)){
                        echo $vehicleDetails;}?>
        </div>

        <hr class=review-hr>
        <h2 class="review-h2">Customer Reviews</h2>
        

        <?php if (isset( $_SESSION['message'])) {
                echo  $_SESSION['message'];}?>

        <?php if (isset($reviewForm)) {
                echo $reviewForm;} ?>

        <hr class="review-hr">

        <?php if(isset($addReviews)){
                echo $addReviews;}?>
       
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
