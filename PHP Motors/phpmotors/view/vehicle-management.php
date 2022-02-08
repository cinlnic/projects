<?php 
// $clientLevel = $_SESSION['clientData']['clientLevel'];

// //test if user is logged in
// if (!$_SESSION['loggedin'] || $clientLevel == '1') {
//     header('Location: /phpmotors/index.php');
//     exit;
// }
if ($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /phpmotors/index.php');
    exit;
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<h1>Vehicle Management</h1>

<ul class="vehicle-link">
    <li><a href="/phpmotors/vehicles/index.php?action=add-classification" title="Go to Add a Classification">Add a Classification</a></li>
    <li><a href="/phpmotors/vehicles/index.php?action=add-vehicle" title="Go to Add Vehicle">Add a Vehicle</a></li>
</ul>

<?php
if (isset($message)) {
    echo $message;
}
if (isset($classificationList)) {
    echo '<h2>Vehicles By Classification</h2>';
    echo '<p class="choose-class">Choose a classification to see vehicles.</p>';
    echo $classificationList;
}
?>

<noscript>
    <p><strong>Javascript must be enabled to use this page.</strong></p>
</noscript>

<table id="inventoryDisplay"></table>


<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>