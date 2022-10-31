<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
if(!$_SESSION['perfil'] == 3){
    header("location: ../../../index.php");
    exit();
}
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT usuario.nome, usuario.sobrenome FROM usuario where id_usuario = $id_usuario;";
$result = mysqli_query($con, $query);

    $row = mysqli_num_rows($result);
    while($data  = mysqli_fetch_array($result)){
        //pedid_equipamento data
        $nome = $data['nome'];
        $sobrenome = $data['sobrenome'];
        $nome_sobrenome = $nome . " " . $sobrenome;
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../imgs/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="../../funções/Function.js"></script>

    <title>Início</title>
</head>
<body> 
    <iframe src="../Barra lateral Colaborador/index.php"></iframe>
    <div class="content">
        <header>
            <div class="container-welcome">
                <div class="welcome-userName">
                    <h1 id="welcome">Seja bem-vindo(a),&#160;</h1>
                    <h1 id="userName"><?php echo $nome_sobrenome?></h1>
                </div>
                <div class="interrogacao">
                    <h2 id="interrogacao">O que deseja fazer hoje?</h2>
                </div>
                <div class="barrasVerde">
                    <div class="barra1"></div>
                    <div class="barra2"></div>
                    <div class="barra3"></div>
                </div>
            </div>
        </header>
        <section class="container-content">
            <div class="titulo-filtro">
                <h1 id="ult-not">Últimas notificações:</h1>
            </div>
            <div class="carrossel">
                <div class="swiper mySwiper container">
                    <div class="swiper-wrapper content">
                        
                    <?php     
                        $query_pedido_equipamento = 
                        "SELECT DATE_FORMAT(pedido_equipamento.datahora, '%d/%m/%y às %H:%i'), objeto_equipamento.nome_objeto_equipamento,
                                             equipamento.descricao, status_validacao.nome
                        FROM pedido_equipamento
                        INNER JOIN equipamento
                        ON pedido_equipamento.fk_equipamento = equipamento.id_equipamento
                        INNER JOIN objeto_equipamento
                        ON equipamento.fk_objeto_equipamento = objeto_equipamento.id_objeto_equipamento
                        INNER JOIN status_validacao
                        ON pedido_equipamento.fk_validacao = status_validacao.id_status
                        where pedido_equipamento.fk_pedido_usuario = $id_usuario AND
                        datahora > now() - interval 1 day;";
                        $result_pedido_equipamento = mysqli_query($con, $query_pedido_equipamento); 
                        $row_pedido_equipamento = mysqli_num_rows($result_pedido_equipamento);
           
                        if ($row_pedido_equipamento == ''){
                            echo "<h2>Não existem dados cadastrados</h2>";
                        }
                        else{
                            while($data_pedido_equipamento = mysqli_fetch_array($result_pedido_equipamento)){
                                //pedid_equipamento data
    
                                $nome_equipamento = $data_pedido_equipamento['nome_objeto_equipamento']. " " .$data_pedido_equipamento['descricao'];
                                $status = $data_pedido_equipamento['nome'];
                                $data = $data_pedido_equipamento["DATE_FORMAT(pedido_equipamento.datahora, '%d/%m/%y às %H:%i')"];
    
                                ?>
                                <div class="swiper-slide card swiper-cardEquip">
                                    <div class="cardEquip">
                                        <div class="info_status">
                                            <p id="fezPedido">Nome equipamento:</p>
                                            <h2 id="nomeEquip" name="nomeEquip"><?php echo $nome_equipamento ?></h2>
                                            <div class="titulo_status">
                                                <p id="userLevel" name="userLevel">Status do Pedido:</p>
                                                <p id="status_solicitacao"><?php echo $status?></p>
                                            </div>
                                        </div>
                                        <div class="data-hora-pedido">
                                            <div class="dataPedido">
                                                <p id="dataPedido">Data do pedido:&nbsp;</p>
                                                <p id="dataPedido" name="dataPedido"><?php echo $data?>h</p>
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
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
            </div>
        </section>
        <footer>
            <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
            <a href="../Tela Sobre nós/index.html" target="_top" id="fabricaSoftware">Fábrica de Software T.57&#160;</a>
            <a href="https://www.ms.senac.br/" target="_blank" id="fabricaSoftware">Senac MS</a>
        </footer>
    </div>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView:4,
            spaceBetween:10,
            slidesPerGroup:4,
            loop: true,
            loopFillGroupWithBlank: true,
            pagination: {
                el:".swiper-pagination",
                clickable: true,
            },
            navigation:{
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        })
    </script>
</body>
</html>