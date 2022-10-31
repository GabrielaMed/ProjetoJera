<?php
    include ("conexao.php");
    include("verificacao.php");
    $id_usuario = mysqli_real_escape_string($con, $_POST['id_usuario_update']);

    $query = "UPDATE usuario SET ativo_inativo = '1' WHERE id_usuario = $id_usuario";
    $result = mysqli_query($con, $query);
    
    if ($result == ''){
        echo "<script language:'javascript'>window.alert('Não foi possível efetuar o cadastro')</script>";
        if ($_SESSION['perfil'] == 1){
            echo "<meta http-equiv='refresh' content='0.3'> url='../Administrador/Tela Usuario/usuario.php'";
        } else{
            echo "<meta http-equiv='refresh' content='0.3'> url='../Gestor/Tela Usuario/usuario.php'";
        }
        exit();
    }

    ?>
        <script src="../funções/Function.js">abrirAviso(".modal_novo_ok")</script>
    <?php

    if($_SESSION['perfil'] == 1){
        header('Location: ../Administrador/Tela Usuario/usuario.php');
        exit();
    } else{
        header('Location: ../Gestor/Tela Usuario/usuario.php');
    }
    exit();

?>