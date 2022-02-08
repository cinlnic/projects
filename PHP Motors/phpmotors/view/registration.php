<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

    <?php
        if (isset($message)) {
            echo $message;
        }
    ?>

    <h1>Create an Account</h1>

    <p class="required"><span>*</span>All fields are required</p>
    
    <form class="register" method="post" action="/phpmotors/accounts/index.php" class="form">
        <label for="clientFirstname">First Name</label>
        <input name="clientFirstname" id="clientFirstname" type="text" required 
        <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?>>

        <label for="clientLastname">Last Name</label>
        <input name="clientLastname" id="clientLastname" type="text" required
        <?php if(isset($clientLastname)) {echo "value='$clientLastname'";}?>>

        <label for="clientEmail">Email</label>
        <input name="clientEmail" id="clientEmail" type="email" required
        <?php if(isset($clientEmail)) {echo "value='$clientEmail'";}?>>

        <label for="clientPassword">Password</label>
        <span class="password">Passwords must be at least 8 characters, contain 1 uppercase letter, <br>least 1 number, and 1 special character.</span>
        <input name="clientPassword" id="clientPassword" type="password" required 
        pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
        
        <button type="submit" class="form-button">Register</button>
        <input type="hidden" name="action" value="register">
    </form>
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>