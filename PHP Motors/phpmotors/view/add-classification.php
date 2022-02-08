<?php 
//test if user is logged in
if ($_SESSION['clientData']['clientLevel'] < 2) {
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

    <h1>Add a Vehicle Classification</h1>

    <form method="post" action="/phpmotors/vehicles/index.php" class="add-class form">
        <input name="classificationName" id="classificationName" type="text" required>
        <button type="submit" class="form-button">Add Classification</button>
        <input type="hidden" name="action" value="add-class">
    </form>
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>