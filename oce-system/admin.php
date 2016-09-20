<?php
session_start();
$error = $_SESSION['error'];

if(!$_SESSION['user']) {
    header('Location: ./login.php');
} else {
    if($_SESSION['user'] != 'admin') {
        header('Location: ./');
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
                <p><span style="font-weight:600;">Users</span></p>
                <table style="margin:0 auto;">
                    <?php
                        $dir = opendir('assets/users');
                        while(($file = readdir($dir)) !== false) {
                            if(($file != '.') && ($file != '..')) {
                                echo '<tr><td>' . substr($file, 0, -4) . '</td></tr>';
                            }
                        }
                        closedir($dir);
                    ?>
                </table>
            </div>
        </div>
        
        <div class="right-half">
            <div class="item-container cf">
                <p><span style="font-weight:600;">Create New User</span></p>
                <form action="assets/submit.php" method="post" class="slideout">
                    <div class="input-group">
                        <input type="text" name="newUser">
                        <label>New User</label>
                    </div>
                    
                    <input type="submit" name="submitNewUser" value="Create User">
                </form>
            </div>
        </div>
    
    </body>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/form.js"></script>
</html>

<?php
}}
?>