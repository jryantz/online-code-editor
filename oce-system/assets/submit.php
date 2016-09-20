<?php
session_start();

if(isset($_POST['loginSubmit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(file_exists('users/' . $username . '.php')) {
        $handle = fopen('users/' . $username . '.php', 'r');
        if(filesize('users/' . $username . '.php') > 0) {
            $fileContent = fread($handle, filesize('users/' . $username . '.php'));
        }
        fclose($handle);
        
        $salt = substr($username, 0, 4) . substr($password, 0, 5) . substr($username, -4) . substr($password, -5);
        $hash = hash('sha512', $salt . $password . $salt);
        
        if($hash == $fileContent) {
            $_SESSION['user'] = $username;
            header('Location: .././');
        } else {
            $_SESSION['error'] = 'Error, password not correct.';
            header('Location: .././');
        }
    } else {
        $_SESSION['error'] = 'Error, user does not exist.';
        header('Location: .././');
    }
}

if(isset($_GET['logout'])) {
    if($_GET['logout'] == 'true') {
        session_destroy();
        header('Location: .././');
    } else {
        header('Location: .././');
    }
}

if(isset($_POST['submitNewUser'])) {
    $user = $_POST['newUser'];
    
    $tempPass = 'password';
    $salt = substr($user, 0, 4) . substr($tempPass, 0, 5) . substr($user, -4) . substr($tempPass, -5);
    $tempPass = hash('sha512', $salt . $tempPass . $salt);
    
    if(!file_exists('users/' . $user . '.php')) {
        $handle = fopen('users/' . $user . '.php', 'x');
        fwrite($handle, $tempPass);
        fclose($handle);
        header('Location: ../admin.php');
    } else {
        $_SESSION['error'] = 'Error, user already exists.';
        header('Location: ../admin.php');
    }
}

if(isset($_POST['changePass'])) {
    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];
    $newPassAgain = $_POST['newPassAgain'];
    
    $username = $_SESSION['user'];
    
    if($newPass == $newPassAgain) {
        if(file_exists('users/' . $username . '.php')) {
            $handle = fopen('users/' . $username . '.php', 'r');
            if(filesize('users/' . $username . '.php') > 0) {
                $fileContent = fread($handle, filesize('users/' . $username . '.php'));
                
                $salt = substr($username, 0, 4) . substr($oldPass, 0, 5) . substr($username, -4) . substr($oldPass, -5);
                $oldPass = hash('sha512', $salt . $oldPass . $salt);
            }
            fclose($handle);
            
            $salt = substr($username, 0, 4) . substr($newPass, 0, 5) . substr($username, -4) . substr($newPass, -5);
            $newPass = hash('sha512', $salt . $newPass . $salt);
            
            if($oldPass == $fileContent) {
                $handle = fopen('users/' . $username . '.php', 'w+');
                fwrite($handle, $newPass);
                fclose($handle);
                session_destroy();
                header('Location: .././');
            } else {
                $_SESSION['error'] = 'Error, old password does not match, try again.';
                header('Location: ./changePassword.php');
            }
        } else {
            $_SESSION['error'] = 'Error, user does not exist.';
            session_destroy();
            header('Location: .././');
        }
    } else {
        $_SESSION['error'] = 'Error, new password and repeat new password must match.';
        header('Location: ./changePassword.php');
    }
}

if(isset($_POST['saveAndClose'])) {
    $file = $_POST['file'];
    $data = $_POST['code'];
    
    if(file_exists('../../project_active' . $file)) {
        $unlink = unlink('../../project_active' . $file);
    }

    $handle = fopen('../../project' . $file, 'w+');
    fwrite($handle, $data);
    fclose($handle);

    header('Location: .././');
}

if(isset($_POST['delete'])) {
    require_once '../classes/recurse.php';
    $recurse = new recurse;
    
    if(is_dir($_POST['file'])) {
        $recurse->r_delete('../../project' . $_POST['file']);
        $recurse->r_delete('../../project_active' . $_POST['file']);
    } else {
        $recurse->r_delete('../../project' . $_POST['file']);
    }
    
    header('Location: .././');
}

if(isset($_POST['submitVersion'])) {
    require_once '../classes/recurse.php';
    $recurse = new recurse;
    
    $recurse->r_copy('../../project', '../../project_versions/' . $_POST['version']);
    
    header('Location: .././');
}

if(isset($_POST['submitFileName'])) {
    $name = strtolower($_POST['fileName']);
    $nameArr = str_split($name);
    $allowed = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');
    $diff = array_diff($nameArr, $allowed);
    $diff = array_filter($diff);
    $name = substr($_POST['fileLocation'], 1) . $name;
    if(!empty($diff)) {
        $_SESSION['error'] = 'Error, you can only use letters and numbers.';
        header('Location: .././');
    } else {
        $pos = strpos($name, '.');
        if($pos == false) {
            $_SESSION['error'] = 'Error, that is not a file.';
            header('Location: .././');
        } else {
            if(file_exists('../../project/' . $name)) {
                $_SESSION['error'] = 'Error, file already exists.';
                header('Location: .././');
            } else {
                $handle = fopen('../../project/' . $name, 'x');
                fclose($handle);
                header('Location: .././');
            }
        }
    }
}

if(isset($_POST['submitFolderName'])) {
    $name = strtolower($_POST['folderName']);
    $nameArr = str_split($name);
    $allowed = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $diff = array_diff($nameArr, $allowed);
    $diff = array_filter($diff);
    $name = substr($_POST['fileLocation'], 1) . $name;
    if(!empty($diff)) {
        $_SESSION['error'] = 'Error, you can only use letters and numbers.';
        header('Location: .././');
    } else {
        if(file_exists('../../project/' . $name)) {
            $_SESSION['error'] = 'Error, folder already exists.';
            header('Location: .././');
        } else {
            mkdir('../../project/' . $name);
            mkdir('../../project_active/' . $name);
            header('Location: .././');
        }
    }
}