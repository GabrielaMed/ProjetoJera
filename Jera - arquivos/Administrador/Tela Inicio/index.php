<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
$id_usuario = $_SESSION['id_usuario'];
if(!$_SESSION['perfil'] == 1){
    header("location: ../../../index.php");
    exit();
}
$query = "SELECT usuario.nome, usuario.sobrenome FROM usuario where id_usuario = $id_usuario;";
$result = mysqli_query($con, $query);

    $row = mysqli_num_rows($result);
    while($data  = mysqli_fetch_array($result)){
        $nome = $data['nome'];
        $sobrenome = $data['sobrenome'];
        $nome_sobrenome = $nome . " " . $sobrenome;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../imgs/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="../../funções/Function.js"></script>

    <title>Início</title>
</head>
<body> 
    <iframe src="../Barra lateral Administrador/index.php"></iframe>
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
                        $query_pedido_equipamento = "SELECT DATE_FORMAT(pedido_equipamento.datahora, '%d/%m/%y às %H:%i'), pedido_equipamento.descricao_pedido, usuario.id_usuario, usuario.nome, usuario.sobrenome, usuario.foto, usuario.fk_perfil, objeto_equipamento.nome_objeto_equipamento
                        FROM pedido_equipamento
                        INNER JOIN usuario
                        ON pedido_equipamento.fk_pedido_usuario = usuario.id_usuario
                        INNER JOIN equipamento
                        ON pedido_equipamento.fk_equipamento = equipamento.id_equipamento
                        INNER JOIN objeto_equipamento
                        ON equipamento.fk_objeto_equipamento = objeto_equipamento.id_objeto_equipamento
                        WHERE fk_validacao = 1 AND
                        datahora > now() - interval 1 day;";
                        $result_pedido_equipamento = mysqli_query($con, $query_pedido_equipamento); 
                        $row_pedido_equipamento = mysqli_num_rows($result_pedido_equipamento);
    
                        $query_alerta_brinde = "SELECT objeto_brinde.nome_objeto_brinde, brinde.descricao, brinde.quantidade FROM brinde INNER JOIN objeto_brinde ON brinde.fk_objeto_brinde = objeto_brinde.id_objeto_brinde WHERE quantidade <= 10 AND ativo_inativo = 1;";
                        $resul_alerta_brinde = mysqli_query($con, $query_alerta_brinde);
                        $row_alerta_brinde = mysqli_num_rows($resul_alerta_brinde);
           
                        if ($row_pedido_equipamento and $row_alerta_brinde == ''){
                            echo "<h2>Não existem dados cadastrados</h2>";
                        }
                        else{
                            while($data_pedido_equipamento = mysqli_fetch_array($result_pedido_equipamento)){
                                //pedid_equipamento data
                                
    
                                if ($data_pedido_equipamento['fk_perfil'] == 3){
                                    $nivel_usuario = "Colaborador";
    
                                }
    
                                if ($data_pedido_equipamento['fk_perfil'] == 2){
                                    $nivel_usuario = "Gestor";
                                }
                                
                                if ($data_pedido_equipamento['fk_perfil'] == 1){
                                    $nivel_usuario = "Administrador";
                                }
    
                                $id_solicitante = $data_pedido_equipamento['id_usuario'];
                                $foto = $data_pedido_equipamento['foto'];
                                $nome_sobrenome = $data_pedido_equipamento['nome'] . " " . $data_pedido_equipamento['sobrenome'];
                                $nome_equipamento = $data_pedido_equipamento['nome_objeto_equipamento'];
                                $descricao = $data_pedido_equipamento['descricao_pedido'];
                                $data = $data_pedido_equipamento["DATE_FORMAT(pedido_equipamento.datahora, '%d/%m/%y às %H:%i')"];
    
                                ?>
                                <div class="swiper-slide card swiper-cardEquip">
                                    <div class="cardEquip">
                                        <?php
                                            if($foto != " "){
                                                echo "<img id='fotoPerfil' src='../../fotos/$id_solicitante/$foto' alt='Foto usuário'>";
                                            }
                                            else{
                                                echo "<img id='fotoPerfil' src='../../fotos/foto_padrao.svg' alt='Foto usuário'>";
                                            }
                                        ?>
                                        <h1 id="userName-card" name="userName"><?php echo $nome_sobrenome?></h1>
                                        <p id="userLevel" name="userLevel"><?php echo $nivel_usuario?></p>
                                        <p id="fezPedido">Fez pedido do equipamento:</p>
                                        <h2 id="nomeEquip" name="nomeEquip"><?php echo $nome_equipamento ?></h2>
                                        <p id="mensagemColab" name="mensagemColab"><?php echo $descricao?></p>
                                        <a class="equip-visualizarNot" href="../Notificação/Notificacao.php">Visualizar</a>
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
    
                            while($data_alerta_pedido = mysqli_fetch_array($resul_alerta_brinde)){
                                $nome_brinde = $data_alerta_pedido['nome_objeto_brinde'];
                                $quantidade_brindes = $data_alerta_pedido['quantidade'];
                                ?>
                               
                                <div class="swiper-slide card swiper-cardBrinde">
                                    <div class="cardBrinde">
                                        <div class="brindeCard">
                                            <img src="../../imgs/brindePurple.svg" alt="Brindes Icone">
                                        </div>
                                        <h1 id="estoqueBaixo">Estoque Baixo</h1>
                                        <p id="nomeBrinde" name="nomeBrinde"><?php echo $nome_brinde?></p>
                                        <h2 id="mensagemEstoque">Este item está abaixo de 10 unidade em estoque.</h2>
                                        <p id="qntBrinde" name="qntBrinde">(<?php echo $quantidade_brindes?>)</p>
                                        <a class="brinde-visualizarNot" href="../Notificação/Notificacao.php">Visualizar</a>
                                        
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
            <a href="../Tela Sobre nós/index.php" target="_top" id="fabricaSoftware">Fábrica de Software T.57&#160;</a>
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