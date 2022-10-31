<?php
    include('conexao.php');
    include('verificacao.php');
    $nome_kit_editar = mysqli_real_escape_string($con, $_POST['nome-kit']);
    $decricao_kit_editar = mysqli_real_escape_string($con, $_POST['descricao_kit']);
    $id_kits = mysqli_real_escape_string($con, $_POST['idkit']);
    $contador = mysqli_real_escape_string($con, $_POST['contador']);
    
    if($nome_kit_editar == '' || $decricao_kit_editar == ''){
        header('location: ../../Tela Kits/kits.php');
    }
    
    $query_mudar_nome_kit = "UPDATE kits SET nome_kit = '$nome_kit_editar' WHERE id_kits = $id_kits;";
    $result_mudar_nome_kit = $con ->query($query_mudar_nome_kit);
    
    $query_mudar_descricao_kit = "UPDATE kits SET descricao_kit = '$decricao_kit_editar' WHERE id_kits = $id_kits;";
    $result_mudar_descricao_kit = $con ->query($query_mudar_descricao_kit);
    
    for ($i = 1; $i <= $contador; $i++){
        if(isset($_POST['lista_kits'.strval($i)])){
            $objeto = mysqli_real_escape_string($con, $_POST['lista_kits'.strval($i).'']);            
            $query_delete_brinde = "DELETE FROM itens_kit WHERE id_itens_kit = $objeto;";
            $result_delete_brinde = $con ->query($query_delete_brinde);
        }
    }
    $qtdlinhas = mysqli_real_escape_string($con, $_POST['linhaedt']);
    $qtdlinhasInt = intval($qtdlinhas);
    for($i = 1; $i <= $qtdlinhasInt; $i++){
        $opcao = mysqli_real_escape_string($con, $_POST['edtaddbrinde'.strval($i).'']);
        $brinde = strstr($opcao, '|', true);
        $qtdcaracter = strpos($opcao, '|');
        $descricao = substr($opcao, $qtdcaracter + 2);

        if(!empty($brinde) || !empty($descricao)){
        $query_objeto_brinde ="SELECT id_brinde FROM brinde
                               JOIN objeto_brinde ON id_objeto_brinde = fk_objeto_brinde
                               WHERE nome_objeto_brinde = '$brinde' AND descricao = '$descricao'";
        $result_objeto_brinde = $con -> query($query_objeto_brinde);
        echo $query_objeto_brinde . ' ';
        $rows = mysqli_num_rows($result_objeto_brinde);
        if($rows > 0){
            while($data = mysqli_fetch_array($result_objeto_brinde)){
                $id_objeto_brinde = $data['id_brinde'];
            }
             $query_insert_itens_kit = "INSERT INTO itens_kit VALUES (null, $id_objeto_brinde,$id_kits)"; 
             echo $query_insert_itens_kit;
             $result_insert = $con -> query($query_insert_itens_kit);  
        }
    }
}
    if ($_SESSION['perfil'] == 1){
        header("location: ../Administrador/Tela Kits/kits.php");
        exit();        
    }
    else if ($_SESSION['perfil'] == 2){
        header("location: ../Gestor/Tela Kits/kits.php");
        exit();
    }
?>