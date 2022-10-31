<?php

use LDAP\Result;

include("../../bd/conexao.php");
include("../../bd/verificacao.php");
require_once("../../bd/selectObjetoEquipamento.php");
$selectEquip = new selectEquipamento;

if(!$_SESSION['perfil'] == 1){
    header("location: ../../../index.php");
    exit();
}
$maior = 0;
$menor = 100000000000000000;

$datainicio = '2000-01-01';
$datafinal = date('y/m/d');

if(!empty($_POST['DataInicio'])){
    $datainicio = ($_POST['DataInicio']);
}
if (!empty($_POST['DataFinal'])){
    $datafinal = ($_POST['DataFinal']);
}

$query = "SELECT * FROM pedido_equipamento;";

if(!empty($_POST['DataInicio']) || !empty($_POST['DataFinal'])){
    $query = "SELECT * FROM pedido_equipamento WHERE datahora BETWEEN '$datainicio' AND '$datafinal'";
}

$result = $con ->query($query);
while($data = mysqli_fetch_array($result)){
    $id = $data['id_pedido'];

    if($id > $maior){
        $maior = $id;
    }
    if($id < $menor){
        $menor = $id;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Equipamentos</title>
    <link rel="stylesheet" href="style.css">
    <!-- CSS bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!------------------->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../imgs/EquipamentosGreen.svg">
    <script src="../../funções/Function.js"></script> 
</head>

<body>
    <iframe src="../Barra lateral Gestor/index.php"></iframe>
    <div class="container-content">
            <div class="titulo-principal">
                <h1 id="titulo" >Relatório de Equipamentos</h1>
           
                <div id="pesquisar">
                    <div id="pesq">
                        <div>
                            <button id="icon"><img  src="../../imgs/pesquisar.svg" alt=""></button>
                        </div>
                        <div>
                            <input id="input-pesq" placeholder="Pesquisar" type="text" onkeyup="search('accordion')">
                        </div>
                    </div>
                </div>
            </div>    

        
        <section id="area-filtros">
            <div class="container_dados">
                <form action="equipamentos.php" method = "POST">
                    <div class="datas">
                        <div id="inputs_data">
                            <p>Opções de filtros para gerar lista de relatórios:</p>
                            <div class="input-format_date">
                                <input type="date" class="input-data" name="DataInicio">
                                <input type="date" class="input-data" name="DataFinal">
                            </div>
                        </div>
                        <div id="check_btns">
                            <div class="input-check">
                                <div class="chkentrada">
                                    <input id="check_emprestimo" onclick="PesquisaCheckBox('check_emprestimo','emprestimo')" type="checkbox" value="1" aria-label="..." checked>
                                    <span>Empréstimo</span>
                                </div>
                                <div class="chksaida">
                                    <input id="check_devolucao"  onclick="PesquisaCheckBox('check_devolucao','devolucao')" type="checkbox" value="2"  aria-label="..." checked>
                                    <span>Devolução</span>
                                </div>
                            </div>
                            <div id="btns_pdf">
                                <div class="btns">
                                    <button class="salvar-doc">Gerar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
           
            <div class="separador"></div>
        </section>


            <!-----------------accordion emprestimo------------------------------>

            <section id="informacoes">
                <div class="teste">
                    <div class="largura-scroll">
                        <div class="scroll">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 area-inforacao">
                                        <div class="tamanho_accordion">

                                        <?php
                                        for($i = $menor; $i <= $maior; $i++){
                                            $queryrelatorio = "SELECT * FROM pedido_equipamento
                                                               JOIN usuario ON id_usuario = fk_pedido_usuario
                                                               WHERE id_pedido = $i";
                                            $result = $con -> query($queryrelatorio);
                                            while($data = mysqli_fetch_array($result)){
                                                $dataemprestimo = $data['datahora'];
                                                $nome = $data['nome'];
                                            }
                                            $query = "SELECT id_pedido, nome, fk_usuario FROM ordem_solicitacao_equipamento
                                                        JOIN usuario ON id_usuario = fk_usuario
                                                        JOIN pedido_equipamento ON id_pedido = fk_pedido_equipamento
                                                        WHERE id_pedido = $i;";
                                            $result = $con ->query($query);
                                            $row2 = mysqli_num_rows($result);
                                            while($data = mysqli_fetch_array($result)){
                                                $aprovado = $data['nome'];
                                            }
                                            $query = "SELECT * FROM pedido_equipamento
                                                      JOIN equipamento ON id_equipamento = fk_equipamento
                                                      JOIN objeto_equipamento ON id_objeto_equipamento = fk_objeto_equipamento
                                                      JOIN estado_conservacao ON id_estado_conservacao = fk_estado_conservacao
                                                      WHERE id_pedido = $i;";
                                            $result = $con ->query($query);
                                            while($data = mysqli_fetch_array($result)){
                                                $patrimonio = $data['cod_patrimonio'];
                                                $objeto_equipamento = $data['nome_objeto_equipamento'];
                                                $estadoConservacao = $data['estado_conservacao'];
                                                $descricao = $data['descricao'];
                                            }
                                            if($row2 > 0){
                                                ?>
                                                 <div class="emprestimo">
                                                    <div class="accordion" id="accordion">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>"
                                                                    aria-expanded="true" aria-controls="collapseOne">
                                                                    <ul id="list">
                                                                        <strong>Informações do emprestimo: </strong>
                                                                        <li class="brindes">Data do emprestimo: <?php echo ' '.$dataemprestimo; ?></li>
                                                                        <li class="brindes">Pedido feito por:<?php echo ' '.$nome; ?></li>
                                                                        <li class="brindes">Aprovado por:<?php echo ' '.$aprovado; ?></li>

                                                                    </ul>
                                                                </button>
                                                            </h2>
                                                            <div class="accordion-collapse collapse" id="collapseOne<?php echo $i; ?>"
                                                                aria-labelledby="headingOne" data-bs-parent="#accordion">
                                                                <div class="accordion-body">
                                                                    <ul>
                                                                        Informações do equipamento
                                                                        <li>patrimônio: <?php echo ' '.$patrimonio; ?></li>
                                                                        <li>Objeto: <?php echo ' '.$objeto_equipamento; ?></li>
                                                                        <li>Estado de conservação: <?php echo ' '.$estadoConservacao; ?></li>
                                                                        <li>Descrição:<?php echo ' '.$descricao; ?></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                 </div>
                                                <?php
                                                $row2 = 0;
                                        }
                                        $query = "SELECT * FROM pedido_equipamento
                                                  JOIN usuario ON id_usuario = fk_pedido_usuario
                                                  WHERE id_pedido = $i";
                                        $result = $con -> query($queryrelatorio);
                                        while($data = mysqli_fetch_array($result)){
                                            $dataemprestimo = $data['datahora'];
                                            $dataDevolucao = $data['datahora_devolucao'];
                                            $nome = $data['nome'];
                                        }
                                        $query = "SELECT id_pedido, nome, fk_usuario FROM ordem_solicitacao_equipamento
                                                 JOIN usuario ON id_usuario = fk_usuario
                                                 JOIN pedido_equipamento ON id_pedido = fk_pedido_equipamento
                                                 WHERE id_pedido = $i;";
                                        $result = $con ->query($query);
                                        $row2 = mysqli_num_rows($result);
                                        while($data = mysqli_fetch_array($result)){
                                            $aprovado = $data['nome'];
                                        }
                                        if($row2 >0){
                                            if(!empty($dataDevolucao)){
                                         ?> 
                                                 
                                <!--------------------accordion devolução----------------------------->
                                            <div class="devolucao">
                                                <div class="accordion" id="accordion">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo '-'.$i; ?>"
                                                                aria-expanded="true" aria-controls="collapseOne">
                                                                <ul>
                                                                    <strong>Informações da devolução</strong>
                                                                    <li>Data do emprestimo: <?php echo ' '.$dataemprestimo; ?></li>
                                                                    <li>Data da devolução: <?php echo ' '.$dataDevolucao; ?></li>
                                                                    <li>Pedido feito por: <?php echo ' '.$nome; ?></li>
                                                                    <li>Confirmado por: <?php echo ' '.$aprovado; ?></li>

                                                                </ul>
                                                            </button>
                                                        </h2>
                                                        <div class="accordion-collapse collapse" id="collapseOne<?php echo '-'.$i; ?>"
                                                            aria-labelledby="headingOne" data-bs-parent="#accordion">
                                                            <div class="accordion-body">
                                                                <ul>
                                                                    Informações do equipamento
                                                                    <li>patrimônio: <?php echo ' '.$patrimonio; ?></li>
                                                                    <li>Objeto: <?php echo ' '.$objeto_equipamento; ?></li>
                                                                    <li>Estado de conservação:<?php echo ' '.$estadoConservacao; ?></li>
                                                                    <li>Descrição: <?php echo ' '.$descricao; ?></li>
                                                                </ul>
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        $row2 = 0;
                                        }
                                    }
                                }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>





            <!--------------------->
        <!-- </main> -->
        <footer>
            <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
            <a href="../Tela Sobre nós/index.php" id="fabricaSoftware">Fábrica de Software T.57&#160;</a>
            <a href="https://www.ms.senac.br/" target="_blank" id="fabricaSoftware">Senac MS</a>
        </footer>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
            defer
        </script>
</body>

</html>