<?php
    session_start();

    if(!$_SESSION['perfil'] == 1){
        return $_SESSION['id_usuario'];
        header("location: ../../index.php");
        exit();
    }
    else if(!$_SESSION['perfil'] == 2){
        return $_SESSION['id_usuario'];
        header("location: ../../login.php");
        exit();
    }
    else if(!$_SESSION['perfil'] == 3){
        return $_SESSION['id_usuario'];
        header("location: ../../index.php");
        exit();
    }

?>
