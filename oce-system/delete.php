<?php
session_start();

if(!$_SESSION['user']) {
    header('Location: login.php');
} else {
    require_once 'classes/populate.php';

    if(!isset($_GET['file'])) {
        header('Location: ./');
    } else {
        $file = $_GET['file'];
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
        
        <div class="item-container cf">
            <table style="margin:0 auto;">
                <tr>
                    <td><p style="text-align:center;">Are you sure you want to delete</p></td>
                </tr>
                <tr>
                    <td><p style="text-align:center;">"<?php echo $file; ?>" ?</p></td>
                </tr>
            </table>
            <form action="assets/submit.php" method="post" class="slideout">
                <input type="hidden" name="file" value="<?php echo $_GET['file']; ?>">
                <input type="submit" name="delete" value="Yes">
                <a href="./" class="button butred">No</a>
            </form>
        </div>
        
    </body>
</html>

<?php
    }
}
?>