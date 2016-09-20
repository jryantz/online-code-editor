<?php
    if(isset($error)) {
        echo '
            <div class="error-container">
                <span style="text-alight:left; float:left;">
                    <a href="./admin.php" style="text-decoration:none; color:#fff;">X</a>
                </span>
                <p style="text-align:center;">' . $error . '</p>
            </div>
        ';
    }
    $_SESSION['error'] = null;
?>