<div class="headerimg">
    <img src="/phpmotors/images/site/logo.png" alt="logo">
</div>
<div class="account">
<?php if(isset($_SESSION['loggedin'])){
    $clientFirstname = $_SESSION['clientData']['clientFirstname'];
    
    echo "<a href='/phpmotors/accounts/index.php?login=admin' class='welcomename' title='Welcome'>Welcome $clientFirstname</a>";
    echo "<a href='/phpmotors/accounts/index.php?login=Logout' title='Logout' >Log Out</a>";
} ?>
<?php if(empty($_SESSION['loggedin'])){
    echo "<a href='/phpmotors/accounts/index.php?login=login' title='My Account' >My Account</a>";
} ?>
</div>