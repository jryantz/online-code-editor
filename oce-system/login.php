<?php
session_start();
$error = $_SESSION['error'];
?>

<!doctype html>
<html>
    <head>
        <link href="css/global.css" rel="stylesheet" type="text/css">
        <link href="css/form.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
    </head>
    
    <body>
        
        <?php require_once 'assets/errorbar.inc.php'; ?>
        
        <div class="item-container cf">
            <form action="assets/submit.php" method="post" class="slideout">
                <div class="input-group">
                    <input type="text" name="username">
                    <label>Username</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password">
                    <label>Password</label>
                </div>
                <input type="submit" name="loginSubmit" value="Login" style="margin-bottom:35px;">
            </form>
        </div>
        
    </body>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/form.js"></script>
</html>