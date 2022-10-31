<?php
    include("conexao.php");
    include("verificacao.php");
    $objeto = mysqli_real_escape_string($con, $_POST['objEquip']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $estado_conservacao = mysqli_real_escape_string($con, $_POST['estado']);
    $codigo = mysqli_real_escape_string($con, $_POST['patrimonio']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
    $id_usuario = $_SESSION['id_usuario'];

    if(empty($objeto) || empty($status) || empty($estado_conservacao) || empty($codigo) || empty($descricao) || empty($id_usuario)){
        if ($_SESSION['perfil'] == 1){
            header("location: ../Administrador/Equipamentos/index.php");
        } else{
            header("location: ../Gestor/Equipamentos/index.php");
        }
    } else{
        $query = "SELECT cod_patrimonio, descricao FROM equipamento WHERE cod_patrimonio = '{$codigo}'";
        $result = mysqli_query($con, $query);

        if($result->fetch_row()>0){
            echo "<script language:'javascript'>window.alert('Equipamento já está cadastrado!')</script>";

            if ($_SESSION['perfil'] == 1){
                header("location: ../Administrador/Equipamentos/index.php");
            } else{
                header("location: ../Gestor/Equipamentos/index.php");
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
                $query = "INSERT equipamento VALUE(null, '$codigo', '$descricao', '$status', '$id_objeto', '$estado_conservacao', '$id_usuario');";
                $result = mysqli_query($con, $query);
                
                if ($result == ''){
                    echo "<script language:'javascript'>window.alert('Não foi possível efetuar o cadastro')</script>";
                    if ($_SESSION['perfil'] == 1){
                        header("location: ../Administrador/Equipamentos/index.php");
                    } else{
                        header("location: ../Gestor/Equipamentos/index.php");
                    }
                    exit();
                }
                else{
                    echo "<script language:'javascript'>window.alert('Cadastrado com sucesso!')</script>";
                    if ($_SESSION['perfil'] == 1){
                        header("location: ../Administrador/Equipamentos/index.php");
                    } else{
                        header("location: ../Gestor/Equipamentos/index.php");
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
               
                $query_new_equipamento = "INSERT equipamento VALUE(null, '{$codigo}', '{$descricao}', '{$status}', '{$id_objeto}', '{$estado_conservacao}', '{$id_usuario}');";
                $result_insert_objeto = mysqli_query($con, $query_new_equipamento);
                if($nivel_usuario == 1){
                    header("location: ../Administrador/Equipamentos/index.php");
                } else{
                    header("location: ../Gestor/Equipamentos/index.php");
                }
            }
        }
    }

?>