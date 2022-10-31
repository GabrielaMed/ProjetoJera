<?php
   include("conexao.php");
   include("verificacao.php");
    
   $id_usuario = $_SESSION['id_usuario'];
   $id_pedido = mysqli_real_escape_string($con, $_POST['idpedido']); 
   $id_equipamento = mysqli_real_escape_string($con, $_POST['idequipamento']);
   
   $query = "UPDATE pedido_equipamento SET fk_validacao = '3' WHERE id_pedido = $id_pedido";
   $ordem_pedido = "INSERT ordem_solicitacao_equipamento VALUES (null, $id_pedido, $id_usuario)";
   $query_status = "UPDATE equipamento SET fk_status = '3' WHERE id_equipamento = $id_equipamento;";

   $con -> query($query);
   $con -> query($ordem_pedido);
   $con ->query($query_status);


   if ($_SESSION['perfil'] == 1){
   header("location: ../Administrador/Notificação/notificacao.php");
      exit();        
  }
  else if ($_SESSION['perfil'] == 2){
     header("location: ../Gestor/Notificação/notificacao.php");
     exit();
  }
?>