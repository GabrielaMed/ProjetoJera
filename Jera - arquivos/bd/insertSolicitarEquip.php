<?php

include("conexao.php");
include("verificacao.php");
$id_usuario = $_SESSION['id_usuario'];
    
    $descricao = mysqli_real_escape_string($con, $_POST["DescricaoPedido"]);
    $idequip = mysqli_real_escape_string($con, $_POST["idequipamento"]);
    $query = "INSERT INTO pedido_equipamento VALUES (null,'$descricao',$idequip,$id_usuario,1,current_timestamp, null);";
    $query_status_equipamento = "UPDATE equipamento SET fk_status = '2' WHERE id_equipamento = $idequip";
    $con -> query($query);
    $con -> query($query_status_equipamento);
    $con -> close();    
    
    if ($_SESSION['perfil'] == 1){
        header("location: ../Administrador/Tela Solicitar Equipamento/SolicitarEquipamento.php");
        exit();        
    }
    else if ($_SESSION['perfil'] == 2){
        header("location: ../Gestor/Tela Solicitar Equipamento/SolicitarEquipamento.php");
        exit();
    }
    else if ($_SESSION['perfil'] == 3){
        header("location: ../Colaborador/Tela Solicitar Equipamento/SolicitarEquipamento.php");
        exit();
    }

    
?>