<?php
session_start();
$error = $_SESSION['error'];

if(!$_SESSION['user']) {
    header('Location: login.php');
} else {
    require_once 'classes/populate.php';
    $populate = new populate;

    $versionDir = '../project_versions';
    $scanned = $populate->bad($versionDir);
    $scanSplit = explode('_', end($scanned));
    
    if(isset($scanSplit[0]) && isset($scanSplit[1])) {
        $base = $scanSplit[0] + 1;
        $sub = $scanSplit[1] + 1;

        $firstShowVer = $scanSplit[0] . '.' . $sub;
        $secondShowVer = $base . '.' . '0';
        $firstHideVer = $scanSplit[0] . '_' . $sub;
        $secondHideVer = $base . '_' . '0';
    } else {
        $firstShowVer = '0.0';
        $secondShowVer = '1.0';
        $firstHideVer = '0_0';
        $secondHideVer = '1_0';
    }
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
                <table style="margin:0 auto;">
                    <tr>
                        <td><p style="text-align:center; font-weight:600;">File</p></td>
                        <td><p style="text-align:center; font-weight:600;">Load / Delete</p></td>
                    </tr>
                    <?php
                        if(!$populate->files() == null) {
                            foreach($populate->files() as $file) {
                                echo '<tr>
                                        <td><p>' . $file . '</p></td>
                                        <td>
                                        <a href="edit.php?file=' . $file . '" class="button butblue">Load</a>
                                        <a href="delete.php?file=' . $file . '" class="button butred">X</a>
                                        </td>
                                    </tr>';
                            }
                        }
                    ?>
                </table>
            </div>
                    
            <div class="item-container cf">
                <table style="margin:0 auto;">
                    <tr>
                        <td><p style="text-align:center; font-weight:600;">Folder</p></td>
                        <td><p style="text-align:center; font-weight:600;">Delete</p></td>
                    </tr>
                    <?php
                        if(!$populate->folders() == null) {
                            foreach($populate->folders() as $folder) {
                                echo '<tr>
                                        <td><p>' . $folder . '</p></td>
                                        <td><a href="delete.php?file=' . $folder . '" class="button butred" float:right;">X</a></td>
                                    </tr>';
                            }
                        }
                    ?>
                </table>
            </div>
        </div>

        <div class="right-half">
            <div class="item-container cf">
                <p><span style="font-weight:600;">Create File</span></p>
                <form action="assets/submit.php" method="post" class="slideout">
                    <div class="input-group" style="float:left;">
                        <select name="fileLocation">
                            <option value="/">/</option>
                            <?php
                                if(!$populate->folders() == null) {
                                    foreach($populate->folders() as $folder) {
                                        echo '<option value="' . $folder . '">' . $folder . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-group" style="float:left;">
                        <input type="text" name="fileName">
                        <label>File Name</label>
                    </div>
                    <br>
                    <input type="submit" name="submitFileName" value="Create File" style="float:left;">
                </form>
                
                <br>

                <p><span style="font-weight:600;">Create Folder</span></p>
                <form action="assets/submit.php" method="post" class="slideout">
                    <div class="input-group" style="float:left;">
                        <select name="fileLocation">
                            <option value="/">/</option>
                            <?php
                                if(!$populate->folders() == null) {
                                    foreach($populate->folders() as $folder) {
                                        echo '<option value="' . $folder . '">' . $folder . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-group" style="float:left;">
                        <input type="text" name="folderName">
                        <label>Folder Name</label>
                    </div>
                    <br>
                    <input type="submit" name="submitFolderName" value="Create Folder" style="float:left;">
                </form>
            </div>
            
            <div class="item-container cf">
                <p><span style="font-weight:600;">Versions</span></p>
                <div style="margin:0 auto;">
                    <p style="text-align:center;">Versions on file:
                    <?php
                        foreach($scanned as $item) {
                            $item = explode('_', $item);
                            echo '<span style="text-decoration:underline">' . $item[0] . '.' . $item[1] . '</span>&nbsp;';
                        }
                    ?>
                    </p>
                    
                    <form action="assets/submit.php" method="post" class="cf" style="margin:20px auto; display:table;">
                        <div class="selector" style="float:left;">
                            <input id="nextSub" type="radio" name="version" value="<?php echo $firstHideVer; ?>" checked>
                            <label for="nextSub"><?php echo $firstShowVer; ?></label>

                            <input id="nextMain" type="radio" name="version" value="<?php echo $secondHideVer; ?>">
                            <label for="nextMain"><?php echo $secondShowVer; ?></label>

                            <span class="switch"></span>
                        </div>
                        
                        <input type="submit" name="submitVersion" value="Create Version" style="position:relative; left:25%; margin-top:40px;">
                    </form>
                </div>
            </div>
        </div>
        
    </body>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/form.js"></script>
</html>

<?php
}
?>