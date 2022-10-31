<?php
    include("conexao.php");
    include("verificacao.php");

    $id_usuario = $_SESSION['id_usuario'];
    $id_kit = mysqli_real_escape_string($con, $_POST["id_kit"]);
    $nome_kit = mysqli_real_escape_string($con, $_POST["nome_kit"]);
    $qtd = mysqli_real_escape_string($con, $_POST["qtd"]);
    $maior = 0;
    $menor = 100000000000;
    $semBrinde = True;
    if(empty($qtd || empty($nome_kit) || empty($id_usuario) || empty($id_kit))){
      if ($_SESSION['perfil'] == 1){
        echo "<script language:'javascript'> window.alert('Quantidade Inválida Para Saida!'); window.location.href='../Administrador/Tela Kits/kits.php';</script>";
      } else{
        echo "<script language:'javascript'> window.alert('Quantidade Inválida Para Saida!'); window.location.href='../Gestor/Tela Kits/kits.php';</script>";
      }
    }else{
        $query_select_itens_kit = "SELECT * FROM itens_kit JOIN brinde on id_brinde = fk_brinde WHERE fk_kits = $id_kit;";
        $result_select_itens_kit = mysqli_query($con, $query_select_itens_kit);
        $rows = mysqli_num_rows($result_select_itens_kit);
        if($rows > 0){
        while($data = mysqli_fetch_array($result_select_itens_kit)){
            $id_brindes = $data['fk_brinde'];
            $quantidade = $data['quantidade'];
            if($qtd > $quantidade){
                if ($_SESSION['perfil'] == 1){
                    echo "<script language:'javascript'> window.alert('Quantidade de Brindes Insuficiente'); window.location.href='../Administrador/Tela Kits/kits.php';</script>";
                    $semBrinde = False;
              } else if ($_SESSION['perfil'] == 2){
                    echo "<script language:'javascript'> window.alert('Quantidade de Brindes Insuficiente'); window.location.href='../Gestor/Tela Kits/kits.php';</script>";
                    $semBrinde = False;

              }
            }
            if($id_brindes > $maior){
                $maior = $id_brindes;
            }
            if($id_brindes < $menor)
            $menor= $id_brindes;
        }
    }else{
        $semBrinde = False;
    }
        if($semBrinde == True){
            for($i = $menor; $i <= $maior; $i++){
                $query_insert_saida_brinde = "INSERT INTO saida_brinde VALUES (null, curdate(), $qtd, $i, $id_usuario, 'Saída do kit $nome_kit');";
                $result = $con ->query($query_insert_saida_brinde);
            }
            $query_insert_saida_kit = "INSERT INTO saida_kit VALUES (null, curdate(), $qtd,$id_usuario, $id_kit)";
            $result = $con ->query($query_insert_saida_kit);
          if ($_SESSION['perfil'] == 1){
                 echo "<script language:'javascript'> window.alert('Saida de Kit Realizada com Sucesso!'); window.location.href='../Administrador/Tela Kits/kits.php';</script>";
          }
          else if ($_SESSION['perfil'] == 2){
                 echo "<script language:'javascript'> window.alert('Saida de Kit Realizada com Sucesso!'); window.location.href='../Gestor/Tela Kits/kits.php';</script>";                
          }
        }
        else{
            if ($_SESSION['perfil'] == 1){
                 echo "<script language:'javascript'> window.alert('Sem Brindes Para Saida!'); window.location.href='../Administrador/Tela Kits/kits.php';</script>";
          }
          else if ($_SESSION['perfil'] == 2){
                 echo "<script language:'javascript'> window.alert('Sem Brindes Para Saida!'); window.location.href='../Gestor/Tela Kits/kits.php';</script>";                
          }    
        }
    }
?>