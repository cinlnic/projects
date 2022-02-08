<?php 
if (!$_SESSION['loggedin']){
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

    <h1>Update Account Information</h1>

    <hr class="update-ln">

    <h2 class="update-h2">Update Personal Information</h2>

    <p class="required"><span>*</span>All fields are required</p>
    
    <form method="post" action="/phpmotors/accounts/index.php" class="form">
        <label for="clientFirstname">First Name</label>
        <input name="clientFirstname" id="clientFirstname" type="text" required 
        <?php $clientFirstname = $_SESSION['clientData']['clientFirstname']; if(isset($clientFirstname)) {echo "value='$clientFirstname'";}?>>

        <label for="clientLastname">Last Name</label>
        <input name="clientLastname" id="clientLastname" type="text" required
        <?php  $clientLastname = $_SESSION['clientData']['clientLastname']; if(isset($clientLastname)) {echo "value='$clientLastname'";}?>>

        <label for="clientEmail">Email</label>
        <input name="clientEmail" id="clientEmail" type="email" required
        <?php $clientEmail = $_SESSION['clientData']['clientEmail']; if(isset($clientEmail)) {echo "value='$clientEmail'";}?>>

        <button type="submit" class="form-button">Update Account</button>
        <input type="hidden" name="action" value="updateAccountInfo">
        <input type="hidden" name="clientId" value="<?php if(isset($_SESSION['clientData']['clientId'])) { echo $_SESSION['clientData']['clientId'];}?>">
    </form>

    <hr class="update-ln">

    <h2 class="update-h2">Change Password</h2>

    <form method="post" action="/phpmotors/accounts/index.php" class="form">
        <p class="password">**This will change your current password**</p>
        <p class="password">Passwords must be at least 8 characters, contain 1 uppercase letter, <br>  at least 1 number, and 1 special character.</p>
        <input name="clientPassword" id="clientPassword" type="password" required
        pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
        
        <button type="submit" class="form-button">Change Password</button>
        <input type="hidden" name="action" value="changePassword">
        <input type="hidden" name="clientId" value="<?php if(isset($_SESSION['clientData']['clientId'])) { echo $_SESSION['clientData']['clientId'];}?>">
    </form>
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>