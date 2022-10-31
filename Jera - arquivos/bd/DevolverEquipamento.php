<?php
    include("conexao.php");
    include("verificacao.php");


    $id_usuario = $_SESSION['id_usuario'];
    $id_equip = mysqli_real_escape_string($con, $_POST['idequipamento']);
    $id_pedido_equip = mysqli_real_escape_string($con, $_POST['idpedidoequipamento']);
    $descricao_devolucao = mysqli_real_escape_string($con, $_POST['descricao']);

    $query_status = "UPDATE equipamento SET fk_status = '3' WHERE id_equipamento = $id_equip;";
    $con ->query($query_status);

    $query_alterar_fk_valida = "UPDATE pedido_equipamento SET fk_validacao = '4' WHERE id_pedido = $id_pedido_equip";
    $con ->query($query_alterar_fk_valida);

    $query_alterar_descricao = "UPDATE pedido_equipamento SET descricao_pedido = '$descricao_devolucao' WHERE id_pedido = $id_pedido_equip;";
    $con ->query($query_alterar_descricao);

    $query_alterar_data_devolucao = "UPDATE pedido_equipamento SET datahora_devolucao = current_timestamp WHERE id_pedido = $id_pedido_equip;";
    $con ->query($query_alterar_data_devolucao);


    $con ->close();

    if ($_SESSION['perfil'] == 1){
        header("location: ../Administrador/Meu historico/meuHistorico.php");
        exit();        
    }
    else if ($_SESSION['perfil'] == 2){
       header("location: ../Gestor/Meu historico/meuHistorico.php");
       exit();
    }
    else if ($_SESSION['perfil'] == 3){
      header("location: ../Colaborador/Meu historico/meuHistorico.php");
      exit();
    }
?>