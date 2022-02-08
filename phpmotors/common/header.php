
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $invInfo; echo getTitle($action, $invInfo, $classificationName);?>
    <link rel="stylesheet" href="/phpmotors/css/stylesheet.css" media="screen">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Chakra+Petch&family=Khand&display=swap">
</head>
<body>
    <div class="body-content">
        <header class="header">
            <a href="/phpmotors/index.php" title="link to home page"><img class="logo" src="/phpmotors/images/site/logo.png" alt="php motors logo"></a>
            
            <?php 
                if(isset($_SESSION['loggedin'])) {
                    $clientFirstname = $_SESSION['clientData']['clientFirstname'];
                    echo "<a href='/phpmotors/accounts' title='Go to the Administration View' class='welcome'>Welcome $clientFirstname</a>";
                    echo "<a href='/phpmotors/accounts/index.php?action=logout' class='acc'>Logout</a>";
                } else {
                    echo "<a href='/phpmotors/accounts/index.php?action=login-page' title='Sign in and account features' class='acc'>My Account</a>";
                } ?>

            <!-- <a href="/phpmotors/accounts/index.php?action=login-page"  title="Sign in and account features" class="acc">My Account</a> -->
        </header>
        <nav>
            <?php //require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; 
                echo $navList; ?>
        </nav>
        
        <main>