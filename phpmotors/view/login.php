<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

    <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
    ?>

    <?php
        if (isset($message)) {
            echo $message;
        }
    ?>
    
    <h1>Account Login</h1>

    <p class="required"><span>*</span>All fields are required</p>

    <form class="login form" method="post" action="/phpmotors/accounts/">
        <label for="clientEmail">Email</label>
        <input name="clientEmail" id="clientEmail" type="email" required
        <?php if(isset($clientEmail)) {echo "value='$clientEmail'";} ?>>

        <label for="clientPassword">Password</label>
        <p class="password">Passwords must be at least 8 characters, contain 1 uppercase letter, <br> at least 1 number, and 1 special character.</p>
        <input name="clientPassword" id="clientPassword" type="password" required 
        pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
        
        <button type="submit" class="form-button">Sign In</button>
        <input type="hidden" name="action" value="login">
    </form>

    <hr class="login-ln">
    <h2 class="new-user">New User?</h2>  
    <a href="/phpmotors/accounts/index.php?action=registration" title="Create a new account" class="create-link">Create an Account</a>
        
    
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
