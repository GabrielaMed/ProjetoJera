<?php
session_start();
include("conexao.php");

if (empty($_POST["email"]) || empty ($_POST["senha"])){
    header("location: ../../index.php");
    exit();
}
// variaveis que recebem informações do formulario
$email= mysqli_real_escape_string($con, $_POST["email"]);
$senha= mysqli_real_escape_string($con, $_POST["senha"]);
$senha_padrao = md5('JeraNovo123@');
//busca por usuario no banco
$query = "SELECT * FROM usuario WHERE email = '{$email}' AND senha = '{$senha}';";
$result = mysqli_query($con, $query);
$row = mysqli_num_rows($result);
$retorno = mysqli_fetch_array($result);
$_SESSION['id_usuario'] = $retorno['id_usuario'];
$_SESSION['perfil'] = $retorno['fk_perfil'];
$_SESSION['atividade'] = $retorno['ativo_inativo'];
// verificação se teve retorno do banco
 
if($row > 0){
    if($_SESSION['perfil'] == 1 and $_SESSION['atividade'] == 1){
        if($senha == $senha_padrao){
            header("location: ../Tela Login/telaPrimeiroAcesso/primeiroAcesso.html");
        } else{
            header("location: ../Administrador/Tela Inicio/index.php");
            exit();
        }
    }
    else if($_SESSION['perfil'] == 2 and $_SESSION['atividade'] == 1){
        if($senha == $senha_padrao){
            header("location: ../Tela Login/telaPrimeiroAcesso/primeiroAcesso.html");
        } else{
        header("location: ../Gestor/Tela Inicio/index.php");
        exit();
        }
    }   
    else if($_SESSION['perfil'] == 3 and $_SESSION['atividade'] == 1){
        if($senha == $senha_padrao){
            header("location: ../Tela Login/telaPrimeiroAcesso/primeiroAcesso.html");
        } else{
        header("location: ../Colaborador/Tela Inicio/index.php");
        exit();
        }
    }
    else{
        $_SESSION["nao_autenticado"] = true;
        echo "<script language:'javascript'> window.alert('Usuário inativo!'); window.location.href='./../index.php';</script>";
        exit();
    } 
}

else{
    $_SESSION["nao_autenticado"] = true;
    echo "<script language:'javascript'> window.alert('Usuário invalido!'); window.location.href='./../index.php';</script>";
    exit();
}
?>
