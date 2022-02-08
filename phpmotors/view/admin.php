<?php 
//test if user is logged in
if (!$_SESSION['loggedin']) {
    header('Location: /phpmotors/index.php');
    exit;
}
?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
    ?>

    <h1 class="admin-h1"><?php echo $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname'];?></h1>

    <p>**You are logged in**</p>
    
    <ul class="admin-list">
        <li>First Name: <?php echo $_SESSION['clientData']['clientFirstname'];?></li>
        <li>Last Name: <?php echo $_SESSION['clientData']['clientLastname'];?></li>
        <li>Email: <?php echo $_SESSION['clientData']['clientEmail'];?></li>
    </ul>

    <h2 class="admin-h2">Account Management</h2>
    <p class="admin-p">Use this link to manage your account.</p>
    <a class="update-link" href="/phpmotors/accounts/index.php?action=updateAccount" title="Go to Account update page">Update Account Information</a>

    <?php 
        $clientLevel = $_SESSION['clientData']['clientLevel'];
        if ($clientLevel > 1) {
            echo '<h2 class="admin-h2">Inventory Management</h2>';
            echo '<p class="admin-p">Use this link to manage inventory.</p>';
            echo '<p class="v-man-link"><a href="/phpmotors/vehicles/index.php" title="Go to Vehicle Management Page">Vehicle Management</a></p>';
        }
    ?>

    <h2 class="admin-h2">Reviews Management</h2>
    <p class="admin-p">Update or delete reviews here.</p>

    <?php if (isset($clientReviews)) { echo $clientReviews;}?>


    <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
