<?php
    include("conexao.php");
    include("verificacao.php");

    $id_usuario = $_SESSION['id_usuario'];
    $id_brinde = mysqli_real_escape_string($con, $_POST["id_brinde"]);
    $qtd = mysqli_real_escape_string($con, $_POST["qtd"]);
    
    if(empty($qtd || empty($id_usuario) || empty($id_brinde))){
      if ($_SESSION['perfil'] == 1){
            header("location: ../Administrador/Tela Brinde/brindes.php");
      } else{
          header("location: ../Gestor/Tela Brinde/brindes.php");
      }
    }else{
        $query_new_brinde = "INSERT INTO entrada_brinde VALUES (null, curdate(), '$qtd', '$id_brinde', '$id_usuario')";
        $result_insert_objeto = mysqli_query($con, $query_new_brinde);
        if ($_SESSION['perfil'] == 1){
            header("location: ../Administrador/Tela Brinde/brindes.php");
        } else{
            header("location: ../Gestor/Tela Brinde/brindes.php");
        }
    }
?>