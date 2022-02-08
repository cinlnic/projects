<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

        <h1 class="class-name"><?php echo $classificationName; ?> Vehicles</h1>
        <?php if (isset($message)) {
                echo $message;}
        ?>
        <?php if(isset($vehicleDisplay)){
                echo $vehicleDisplay;}
        ?>    
        
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
