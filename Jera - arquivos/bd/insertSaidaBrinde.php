<?php
    include("conexao.php");
    include("verificacao.php");

    $id_usuario = $_SESSION['id_usuario'];
    $descricao = mysqli_real_escape_string($con, $_POST["descricaobrinde"]);
    $id_brinde = mysqli_real_escape_string($con, $_POST["id_brinde"]);
    $qtd = mysqli_real_escape_string($con, $_POST["qtd"]);

    if(empty($qtd || empty($descricao) || empty($id_usuario) || empty($id_brinde))){
      if ($_SESSION['perfil'] == 1){
            header("location: ../Administrador/Tela Brinde/brindes.php");
      } else{
          header("location: ../Gestor/Tela Brinde/brindes.php");
      }
    }else{
        $query_verifica_estoque = "SELECT * FROM brinde WHERE id_brinde = '$id_brinde'";
        $result_verifica_estoque = mysqli_query($con, $query_verifica_estoque);
        while($data = mysqli_fetch_array($result_verifica_estoque)){
            $qtd_estoque = $data['quantidade'];
        }
        if(($qtd_estoque <= 0) || ($qtd_estoque < $qtd)){
            if ($_SESSION['perfil'] == 1){
                $caminho = "../Administrador/Tela Brinde/brindes.php";
            } else{
                $caminho = "../Gestor/Tela Brinde/brindes.php";
            }
            echo "<script language:'javascript'> window.alert('Essa ação não pode ser concluida pois a quantidade em estoque será menor ou igual a 0!'); window.location.href='$caminho';</script>";
        }else{
            $query_saida_brinde = "INSERT INTO saida_brinde VALUES (null, curdate(), '$qtd','$id_brinde', '$id_usuario', '$descricao')";
    
            $result_saida_brinde = mysqli_query($con, $query_saida_brinde);

            if ($_SESSION['perfil'] == 1){
                header("location: ../Administrador/Tela Brinde/brindes.php");
            } else{
                header("location: ../Gestor/Tela Brinde/brindes.php");
            }
        }
    }
?>