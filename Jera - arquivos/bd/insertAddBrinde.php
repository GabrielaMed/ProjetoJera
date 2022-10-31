<?php
    include("conexao.php");
    include("verificacao.php");


    $id_usuario = $_SESSION['id_usuario'];
    $descricao = mysqli_real_escape_string($con, $_POST["descricaobrinde"]);
    $nomebrinde = mysqli_real_escape_string($con, $_POST["nomebrinde"]); 
    $qtd = mysqli_real_escape_string($con, $_POST["qtd"]);
    
    if(empty($descricao) || empty($nomebrinde) || empty($qtd)){
        if ($_SESSION['perfil'] == 1){
            header("location: ../Administrador/Tela Brinde/brindes.php");
        } else{
            header("location: ../Gestor/Tela Brinde/brindes.php");
        }
    }else{
        $query_verifica_objeto = "SELECT * FROM objeto_brinde WHERE nome_objeto_brinde = '$nomebrinde'";
        $result_verifica_objeto = mysqli_query($con, $query_verifica_objeto);
        $row = mysqli_num_rows($result_verifica_objeto);
        while($data = mysqli_fetch_array($result_verifica_objeto)){
            $id_brinde = $data['id_objeto_brinde'];
        }
    
        if($row > 0){
            $query_new_brinde = "INSERT INTO brinde VALUES (null,'$descricao', $qtd, $id_usuario, $id_brinde, 1)";
            $result_insert_objeto = mysqli_query($con, $query_new_brinde);
            if ($_SESSION['perfil'] == 1){
                header("location: ../Administrador/Tela Brinde/brindes.php");
            } else{
                header("location: ../Gestor/Tela Brinde/brindes.php");
            }
        }
        else{
            $query_new_objeto_brinde = "INSERT INTO objeto_brinde VALUES (null,'$nomebrinde')";
            $result_new_objeto_brinde = mysqli_query($con, $query_new_objeto_brinde);
            $query_busca_new_objeto_brinde = "SELECT * FROM objeto_brinde WHERE nome_objeto_brinde = '$nomebrinde'";
            $result_busca_new_objeto_brinde = mysqli_query($con, $query_busca_new_objeto_brinde);
            while($data = mysqli_fetch_array($result_busca_new_objeto_brinde)){
                $id_brinde = $data['id_objeto_brinde'];
            }
            $query_new_brinde = "INSERT INTO brinde VALUES (null,'$descricao', $qtd, $id_usuario, $id_brinde, 1)";
            $result_insert_objeto = mysqli_query($con, $query_new_brinde);
            if ($_SESSION['perfil'] == 1){
                header("location: ../Administrador/Tela Brinde/brindes.php");
            } else{
                header("location: ../Gestor/Tela Brinde/brindes.php");
            }
        }
        
    }
?>