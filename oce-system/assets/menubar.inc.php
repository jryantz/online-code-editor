<div class="menubar">
    <a href="./" class="aleft">Home</a>
    <?php if($_SESSION['user'] == 'admin') {echo '<a href="admin.php" class="aleft">Admin</a>';} ?>
    
    <a href="assets/submit.php?logout=true" class="aright">Logout</a>
    <a href="user.php" class="aright">User Settings</a>
</div>