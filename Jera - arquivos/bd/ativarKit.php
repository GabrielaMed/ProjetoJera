<?php
    include ("conexao.php");
    include("verificacao.php");
    $id_kit = mysqli_real_escape_string($con, $_POST['id_kit']);

    $query = "UPDATE kits SET ativo_inativo = '1' WHERE id_kits = $id_kit";
    $result = mysqli_query($con, $query);
    
    if ($result == ''){
        echo "<script language:'javascript'>window.alert('Não foi possível efetuar o cadastro')</script>";
        if($_SESSION['perfil'] == 1){
            header('Location: ../Administrador/Tela Kits/kits.php');
            exit();
        } else{
            header('Location: ../Gestor/Tela Kits/kits.php');
        }
        exit();
    }

    ?>
        <script src="../funções/Function.js">abrirAviso(".modal_novo_ok")</script>
    <?php

    if($_SESSION['perfil'] == 1){
        header('Location: ../Administrador/Tela Kits/kits.php');
        exit();
    } else{
        header('Location: ../Gestor/Tela Kits/kits.php');
    }
    exit();

?>