<?php
    include ("conexao.php");
    include("verificacao.php");
    $nome = mysqli_real_escape_string($con, $_POST["nome"]);
    $sobrenome = mysqli_real_escape_string($con, $_POST['sobrenome']);
    $telefone = mysqli_real_escape_string($con, $_POST['telefone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $fk_id_perfil_usuario = mysqli_real_escape_string($con, $_POST['valueDropdown']);
    $id_usuario = mysqli_real_escape_string($con, $_POST['id_usuario_update']);
    $id_usuario_logged = $_SESSION['id_usuario'];

    if(empty($nome) || empty($sobrenome) || empty($telefone) || empty($email)){
        if ($_SESSION['perfil'] == 1){
            header('Location: ../Administrador/Tela Usuario/usuario.php');
        } else{
            header('Location: ../Gestor/Tela Usuario/usuario.php');
        } 
        exit();
    }
    else{
        $query = "UPDATE usuario SET nome = '$nome', sobrenome = '{$sobrenome}', telefone = '{$telefone}', email = '{$email}', fk_perfil = '{$fk_id_perfil_usuario}' WHERE id_usuario = $id_usuario";
        $result = mysqli_query($con, $query);
        
        if ($result == ''){
            echo "<script language:'javascript'> window.alert('Usuário inativo!'); window.location.href='./../index.php';</script>
            <script language:'javascript'>window.alert('Não foi possível efetuar o cadastro')</script>";
            if ($_SESSION['perfil'] == 1){
                header('Location: ../Administrador/Tela Usuario/usuario.php');
            } else{
                header('Location: ../Gestor/Tela Usuario/usuario.php');
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
        
    }
?>