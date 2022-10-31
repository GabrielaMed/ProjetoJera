<?php
include("../../bd/verificacao.php");
include("../../bd/conexao.php");
if(!$_SESSION['perfil'] == 1){
    header("location: ../../../index.php");
    exit();
}

$datainicio = '2000-01-01';
$datafinal = date('y/m/d');

if(!empty($_POST['DataInicio'])){
    $datainicio = ($_POST['DataInicio']);
}
if (!empty($_POST['DataFinal'])){
    $datafinal = ($_POST['DataFinal']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Brindes</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../imgs/brindeGreen.svg">
    <script src="../../funções/Function.js"></script>    
</head>

<body>
    <iframe src="../Barra lateral Administrador/index.php"></iframe>
    <div class="container-content">
            <div class="titulo-principal">
                <h1 id="titulo" >Relatório de Brindes</h1>
           
                <div id="pesquisar">
                    <div id="pesq">
                        <div>
                            <button id="icon" href="#"><img  src="../../imgs/pesquisar.svg" alt=""></button>
                        </div>
                        <div>
                            <input id="input-pesq" placeholder="Pesquisar" type="text" onkeyup="search('accordion')">
                        </div>
                    </div>
                </div>
            </div>    

        
        <section id="area-filtros">
            <div class="container_dados">
                <form action = "brindes.php" method = "POST">
                    <div class="datas">
                        <div id="inputs_data">
                            <p>Opções de filtros para gerar lista de relatórios:</p>
                            <div class="input-format_date">
                                <input type="date" name = "DataInicio" class="input-data" >
                                <input type="date" name = "DataFinal" class="input-data">
                            </div>
                        </div>
                        <div id="check_btns">
                            <div class="input-check">
                                <div class="chkentrada">
                                    <input id="checkbox_entrada" onclick="PesquisaCheckBox('checkbox_entrada','entrada')" type="checkbox" value="1" aria-label="..." checked>
                                    <span>Entrada</span>
                                </div>
                                <div class="chksaida">
                                    <input id="checkbox_saida" onclick="PesquisaCheckBox('checkbox_saida','saida')" type="checkbox" value="2"  aria-label="..." checked>
                                    <span>Saida</span>
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
        <section id="informacoes">
            <div class="teste">
                <div class="largura-scroll">
                    <div class="scroll">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 area-inforacao">
                                    <div class="tamanho_accordion">
                                        <!----------------- Accordion entrada de brindes ------------------------------>
                                        <?php
                                        $cont = 0;
                                        $sql = "SELECT * FROM entrada_brinde
                                                JOIN usuario u on u.id_usuario = fk_en_brinde
                                                JOIN brinde b on b.id_brinde = fk_en_brinde
                                                JOIN objeto_brinde ob on ob.id_objeto_brinde = b.fk_objeto_brinde
                                                WHERE data_entrada_brinde BETWEEN '$datainicio' AND '$datafinal';";
                                        $result = mysqli_query($con, $sql);
                                        $row = mysqli_num_rows($result);
                                        if ($row == '') {
                                            echo "<h3> Não existe dados cadastrados </h3>";
                                        } else {
                                        ?>
                                            <?php
                                            while ($data = mysqli_fetch_array($result)) {
                                                $dataEntrada = $data['data_entrada_brinde'];
                                                $enUsuario = $data['nome'];
                                                $qtdeEntrada = $data['quantidade_entrada'];
                                                $nomeObjeto = $data['nome_objeto_brinde'];
                                                $descricao = $data['descricao'];
                                                $cont = $cont + 1;
                                            ?>
                                        <div class = "entrada">
                                            <div class="accordion" id="accordion">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $cont; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                            <ul id="list">
                                                                <strong> Informações de entrada: </strong>
                                                                <li class="brindes">Data de entrada: <?php echo $dataEntrada; ?></li>
                                                                <li class="brindes">Registrado por: <?php echo $enUsuario; ?></li>
                                                                <li class="brindes">Quantidade: <?php echo $qtdeEntrada; ?></li>
                                                            </ul>
                                                        </button>
                                                    </h2>
                                                    <div class="accordion-collapse collapse" id="collapseOne<?php echo $cont; ?>" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                                        <div class="accordion-body">
                                                            <ul>
                                                                Informações do brinde
                                                                <li>Objeto: <?php echo $nomeObjeto; ?></li>
                                                                <li>Descrição: <?php echo $descricao; ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }
                                        } ?>
                                        <!------------------------------------ Accordion saída de brindes -------------------------------------->
                                        <?php
                                        $sql = "SELECT * FROM saida_brinde
                                                JOIN usuario u on u.id_usuario = fk_s_brinde
                                                JOIN brinde b on b.id_brinde = fk_s_brinde
                                                JOIN objeto_brinde ob on ob.id_objeto_brinde = b.fk_objeto_brinde
                                                WHERE data_saida BETWEEN '$datainicio' AND '$datafinal';";
                                        $result = mysqli_query($con, $sql);
                                        $row = mysqli_num_rows($result);
                                        if ($row == '') {
                                            echo "<h3> Não existe dados cadastrados </h3>";
                                        } else {
                                            while ($data = mysqli_fetch_array($result)) {
                                                $dataSaida = $data['data_saida'];
                                                $sUsuario = $data['nome'];
                                                $qtdeSaida = $data['quantidade_saida'];
                                                $nomeObjeto = $data['nome_objeto_brinde'];
                                                $descricao = $data['descricao'];
                                                $cont = $cont + 1;
                                        ?>
                                    <div class="saida">
                                        <div class="accordion" id="accordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $cont; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                        <ul id="list">
                                                            <strong>Informações de saída:</strong>
                                                            <li class="brindes">Data de saída: <?php echo $dataSaida; ?></li>
                                                            <li class="brindes">Registrado por: <?php echo $sUsuario; ?></li>
                                                            <li class="brindes">Quantidade: <?php echo $qtdeSaida; ?></li>
                                                        </ul>
                                                    </button>
                                                </h2>
                                                <div class="accordion-collapse collapse" id="collapseOne<?php echo $cont; ?>" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                                    <div class="accordion-body">
                                                        <ul>
                                                            Informações do brinde
                                                            <li>Objeto: <?php echo $nomeObjeto; ?></li>
                                                            <li>Descrição: <?php echo $descricao; ?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <?php 
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