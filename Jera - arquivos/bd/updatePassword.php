<?php
    include("conexao.php");
    include("verificacao.php");
    $id_usuario = $_SESSION['id_usuario'];

    $senha = mysqli_real_escape_string($con, $_POST['senha']);
    $conf_senha = mysqli_real_escape_string($con, $_POST['conf_senha']);

    if(empty($senha) || empty($conf_senha)){
        if ($_SESSION['perfil'] == 1){
            header("location: ../Administrador/Tela Configurações do Usuário/index.php");
        } elseif($_SESSION['perfil'] == 2){
            header("location: ../Gestor/Tela Configurações do Usuário/index.php");
        }elseif($_SESSION['perfil'] == 3){
            header("location: ../Colaborador/Tela Configurações do Usuário/index.php");
        }
    } else{
        if($senha == $conf_senha){
            $query = "UPDATE usuario SET senha = '$senha' WHERE id_usuario = '$id_usuario';";
            $result = mysqli_query($con, $query);

            if($result == ''){
                echo "<script language:'javascript'>window.alert('O update falhou');</script>";
            } else{
                echo "<script language:'javascript'>window.alert('Senha alterada com sucesso!');</script>";
                if ($_SESSION['perfil'] == 1){
                    header("location: ../Administrador/Tela Configurações do Usuário/index.php");
                } elseif($_SESSION['perfil'] == 2){
                    header("location: ../Gestor/Tela Configurações do Usuário/index.php");
                }elseif($_SESSION['perfil'] == 3){
                    header("location: ../Colaborador/Tela Configurações do Usuário/index.php");
                }
            }
        } else{
            echo "<script language:'javascript'>window.alert('As senhas devem ser iguais!');</script>";
        }
    }

?>