<?php
    include ("conexao.php");
    include("verificacao.php");
    $id_usuario = mysqli_real_escape_string($con, $_POST['id_usuario_update']);

    $query = "UPDATE usuario SET ativo_inativo = '0' WHERE id_usuario = $id_usuario";
    $result = mysqli_query($con, $query);
    
    if ($result == ''){
        echo "<script language:'javascript'> window.alert('Não Foi Possível Efetuar o Cadastro!'); window.location.href='../Administrador/Tela Usuario/usuario.php';</script>";
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