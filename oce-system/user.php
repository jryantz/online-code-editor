<?php
session_start();
$error = $_SESSION['error'];

if(!$_SESSION['user']) {
    header('Location: ./login.php');
} else {
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
        
        <?php require_once 'assets/menubar.inc.php'; ?>
        <?php require_once 'assets/errorbar.inc.php'; ?>
        
        <div class="left-half">
            <div class="item-container cf">
            
            </div>
        </div>
        
        <div class="right-half">
            <div class="item-container cf">
                <p><span style="font-weight:600;">Reset Password</span></p>
                <form action="assets/submit.php" method="post" class="slideout">
                    <div class="input-group">
                        <input type="password" name="oldPass">
                        <label>Old Password</label>
                    </div>
                    <div class="input-group">
                        <input type="password" name="newPass">
                        <label>New Password</label>
                    </div>
                    <div class="input-group">
                        <input type="password" name="newPassAgain">
                        <label>Repeat New Password</label>
                    </div>

                    <input type="submit" name="changePass" value="Change Password">
                </form>
            </div>
        </div>
        
    </body>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/form.js"></script>
</html>

<?php
}
?>