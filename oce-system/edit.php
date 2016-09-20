<?php
session_start();

if(!$_SESSION['user']) {
    header('Location: login.php');
} else {
    require_once 'classes/populate.php';

    if(!isset($_GET['file'])) {
        header('Location: ./');
    } else {
        $fileContent;
        $file = $_GET['file'];
        $exist = '../project_active' . $file;
        $file = '../project' . $file;

        if(file_exists($exist)) {
            $_SESSION['error'] = 'File is being edited by another user, please wait and try again later.';
            header('Location: ./');
        } else {
            $handle = fopen($file, 'a+');
            if(filesize($file) > 0) {
                $fileContent = fread($handle, filesize($file));
            }
            fclose($handle);
            copy($file, $exist);
?>

<!doctype html>
<html>
    <head>
        <link href="css/global.css" rel="stylesheet" type="text/css">
        <link href="css/form.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
    </head>
    
    <body class="cf">
        
        <form action="assets/submit.php" method="post">
            <div class="left-bigthird">
                <div class="item-container">
                    <textarea cols="150" rows="30" name="code"><?php echo $fileContent; ?></textarea>
                </div>
            </div>
            
            <div class="right-third">
                <div class="item-container">
                    <table>
                        <tr>
                            <td>
                                <input type="hidden" name="file" value="<?php echo $_GET['file']; ?>">
                                <input type="submit" name="saveAndClose" value="Save and Close">
                            </td>
                            <td><p style="color:#ff0000;">DOCUMENT LOCKED</p></td>
                        </tr>
                        <tr>
                            <td colspan="2"><p>CLICK "SAVE AND CLOSE" TO UNLOCK DOCUMENT</p></td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
        
    </body>
    
    <script type="text/javascript">
        var textareas = document.getElementsByTagName('textarea');
        var count = textareas.length;
        for(var i = 0; i < count; i++){
            textareas[i].onkeydown = function(e) {
                if(e.keyCode == 9 || e.which == 9) {
                    e.preventDefault();
                    var s = this.selectionStart;
                    this.value = this.value.substring(0,this.selectionStart) + "    " + this.value.substring(this.selectionEnd);
                    this.selectionEnd = s + 4; 
                }
            }
        }
    </script>
</html>

<?php
}}}
?>