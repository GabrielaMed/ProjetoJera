<?php
    include ("conexao.php");
    include("verificacao.php");
    $id_brinde = mysqli_real_escape_string($con, $_POST['id_brinde']);

    $query = "UPDATE brinde SET ativo_inativo = '1' WHERE id_brinde = $id_brinde";
    $result = mysqli_query($con, $query);
    
    if ($result == ''){
        echo "<script language:'javascript'>window.alert('Não foi possível efetuar o cadastro')</script>";
        if($_SESSION['perfil'] == 1){
            header('Location: ../Administrador/Tela Brinde/brindes.php');
            exit();
        } else{
            header('Location: ../Gestor/Tela Brinde/brindes.php');
        }
        exit();
    }

    ?>
        <script src="../funções/Function.js">abrirAviso(".modal_novo_ok")</script>
    <?php

    if($_SESSION['perfil'] == 1){
        header('Location: ../Administrador/Tela Brinde/brindes.php');
        exit();
    } else{
        header('Location: ../Gestor/Tela Brinde/brindes.php');
    }
    exit();

?>