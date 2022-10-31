<?php
    include("conexao.php");
    include("verificacao.php");

    $objeto = mysqli_real_escape_string($con, $_POST['objEquip']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $estado_conservacao = mysqli_real_escape_string($con, $_POST['estado']);
    $codigo = mysqli_real_escape_string($con, $_POST['patrimonio']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
    $id_equipamento = mysqli_real_escape_string($con, $_POST['id_equipamento']);
    $id_usuario = $_SESSION['id_usuario'];

    if(empty($objeto) || empty($status) || empty($estado_conservacao) || empty($codigo) || empty($descricao) || empty($id_usuario) || empty($id_equipamento)){
        if ($_SESSION['perfil'] == 1){
            header('Location: ../Administrador/Equipamentos/index.php');
        } else{
            header('Location: ../Gestor/Equipamentos/index.php');
        }
        exit();
    }
    else{
        $query_verifica_objeto = "SELECT * FROM objeto_equipamento WHERE nome_objeto_equipamento = '$objeto'";
        $result_verifica_objeto = mysqli_query($con, $query_verifica_objeto);
        $row = mysqli_num_rows($result_verifica_objeto);
        while($data = mysqli_fetch_array($result_verifica_objeto)){
            $id_objeto = $data['id_objeto_equipamento'];
        }
        
        if($row > 0){
            $query = "UPDATE equipamento SET cod_patrimonio = '$codigo', descricao = '$descricao', fk_status = '$status', fk_objeto_equipamento = '$id_objeto', fk_estado_conservacao = '$estado_conservacao', fk_usuario_equip = '$id_usuario' where id_equipamento = '$id_equipamento';";
            $result = mysqli_query($con, $query);
            
            if ($result == ''){
                echo "<script language:'javascript'>window.alert('Não foi possível efetuar o update')</script>";
                
                if ($_SESSION['perfil'] == 1){
                    header('Location: ../Administrador/Equipamentos/index.php');
                } else{
                    header('Location: ../Gestor/Equipamentos/index.php');
                }
                exit();
            }
            else{
                echo "<script language:'javascript'>window.alert('Editado com sucesso!')</script>";
                if ($_SESSION['perfil'] == 1){
                    header('Location: ../Administrador/Equipamentos/index.php');                
                } else{
                    header('Location: ../Gestor/Equipamentos/index.php');
                }
            }
        }
        else{
            $query_new_objeto_equipamento = "INSERT INTO objeto_equipamento VALUES (null,'$objeto')";
            $result_new_objeto_equipamento = mysqli_query($con, $query_new_objeto_equipamento);
            $query_busca_new_objeto_equipamento = "SELECT * FROM objeto_equipamento WHERE nome_objeto_equipamento = '$objeto'";
            $result_busca_new_objeto_equipamento = mysqli_query($con, $query_busca_new_objeto_equipamento);
            while($data = mysqli_fetch_array($result_busca_new_objeto_equipamento)){
                $id_objeto = $data['id_objeto_equipamento'];
            }
            
            $query_new_equipamento = "UPDATE equipamento SET cod_patrimonio = '$codigo', descricao = '$descricao', fk_status = '$status', fk_objeto_equipamento = '$id_objeto', fk_estado_conservacao = '$estado_conservacao', fk_usuario_equip = '$id_usuario' where id_equipamento = '$id_equipamento';";
            $result_insert_objeto = mysqli_query($con, $query_new_equipamento);

            echo "<script language:'javascript'> window.alert('Equipamento editado com sucesso!');</script>";
            if ($_SESSION['perfil'] == 1){
                header('Location: ../Administrador/Equipamentos/index.php');
            } else{
                header('Location: ../Gestor/Equipamentos/index.php');
            }
        }
    }
?>