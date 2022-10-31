<?php
include("conexao.php");
include("verificacao.php");
$id_usuario = $_SESSION['id_usuario'];

if (empty($_POST["nome-kit"]) || empty($_POST["descricao"])){
    echo "<script language:'javascript'> window.alert('Não foi Possivel Cadastrar kit! \\nNome do Kit ou Descrição Vazio!'); window.location.href='../Administrador/Tela Kits/kits.php';</script>";
    exit();
}

$nome_kit = mysqli_real_escape_string($con, $_POST["nome-kit"]);
$descricao = mysqli_real_escape_string($con, $_POST["descricao"]);
$qtdlinhas = mysqli_real_escape_string($con, $_POST["linha"]);
$qtdlinhasInt = intval($qtdlinhas);

$query_insert_kit = "INSERT INTO kits VALUES (NULL, '$nome_kit', '$descricao', $id_usuario, 1)";
$result_insert_kit = $con ->query($query_insert_kit);
$query_select_kit = "SELECT * FROM kits WHERE nome_kit = '$nome_kit' AND descricao_kit = '$descricao'";
$result_select_kit = $con ->query($query_select_kit);
while($data = mysqli_fetch_array($result_select_kit)){
    $id_conjunto_kit = $data['id_kits'];
}

$row = mysqli_num_rows($result_select_kit);
if($row > 0){
    for($i = 1; $i <= $qtdlinhasInt; $i++){
        $opcao = mysqli_real_escape_string($con, $_POST['brindeSelecao'.strval($i).'']);
        $brinde = strstr($opcao, '|', true);
        $sem = str_replace(' ', '', $com);
        $nome_brinde = rtrim($brinde);
        $qtdcaracter = strpos($opcao, '|');
        $descricao = substr($opcao, $qtdcaracter + 2);

        $query_objeto_brinde ="SELECT id_brinde FROM brinde
                               JOIN objeto_brinde ON id_objeto_brinde = fk_objeto_brinde
                               WHERE nome_objeto_brinde = '$nome_brinde' AND descricao = '$descricao'";
        $result_objeto_brinde = $con -> query($query_objeto_brinde);
        echo $query_objeto_brinde;
        $rows = mysqli_num_rows($result_objeto_brinde);
        if($rows > 0){
            while($data = mysqli_fetch_array($result_objeto_brinde)){
                $id_objeto_brinde = $data['id_brinde'];
            }
            $query_insert_itens_kit = "INSERT INTO itens_kit VALUES (null, $id_objeto_brinde, $id_conjunto_kit)"; 
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