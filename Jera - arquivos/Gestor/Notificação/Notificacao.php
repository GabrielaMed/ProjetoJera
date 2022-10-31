<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
if(!$_SESSION['perfil'] == 2){
    header("location: ../../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.svg">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="../../funções/Function.js"></script>
    <link rel="stylesheet" href="notificacao.css">
    <title>Histórico</title>
</head>
<body>
    <body>
        <iframe src="../Barra lateral Gestor/index.php"></iframe>
        <div class="container">
           <!-- mude o e coloque seu id --> 
            <div id="titulo_Notificacao">
                <h1>Notificação</h1>
           
                <div id="pesquisar">
                    <div id="pesq">
                        <div>
                            <button id="icon" href="#"><img  src="../../imgs/pesquisar.svg" alt=""></button>
                        </div>
                        <div>
                            <input id="input-pesq" placeholder="Pesquisar" type="text" onkeyup="search('pesquisar')">
                        </div>
                    </div>
                </div>
            </div>

            <!-- mude o e coloque seu id -->
           
            <main id="main-Notificacao">
                    <div id="scroll_notificacao">
                            
                        <?php 
                            $cont = 0;
                            $cont_brinde = 0;
                            $query_alerta_equipamento = "SELECT u.nome, oe.nome_objeto_equipamento, u.email, u.telefone, pe.descricao_pedido,
                                                         DATE_FORMAT(pe.datahora, '%d/%m/%y %H:%i'), pe.id_pedido, e.id_equipamento
                                                         FROM objeto_equipamento oe
                                                         JOIN equipamento e ON e.fk_objeto_equipamento = oe.id_objeto_equipamento 
                                                         JOIN pedido_equipamento pe ON pe.fk_equipamento = e.id_equipamento
                                                         join usuario u on u.id_usuario = pe.fk_pedido_usuario
                                                         WHERE pe.fk_validacao = 1;";
                            
                            $result_pedido_equipamento = mysqli_query($con, $query_alerta_equipamento); 
                            $row_pedido_equipamento = mysqli_num_rows($result_pedido_equipamento);

                            $query_alerta_brinde = "SELECT ob.nome_objeto_brinde,b.quantidade
                                                    FROM objeto_brinde ob
                                                    JOIN brinde b ON  b.fk_objeto_brinde = ob.id_objeto_brinde
                                                    WHERE b.quantidade <= 10 AND ativo_inativo = 1;";

                            $resul_alerta_brinde = mysqli_query($con, $query_alerta_brinde);
                            $row_alerta_brinde = mysqli_num_rows($resul_alerta_brinde);
            
                            if ($row_pedido_equipamento and $row_alerta_brinde == ''){
                                echo "<h2>Não existem dados cadastrados</h2>";
                            }
                            else{
                                while($data_pedido_equipamento = mysqli_fetch_array($result_pedido_equipamento)){
                                    $id_pedido = $data_pedido_equipamento['id_pedido'];
                                    $id_equipamento = $data_pedido_equipamento['id_equipamento'];
                                    $nome = $data_pedido_equipamento['nome'];
                                    $nome_equipamento = $data_pedido_equipamento['nome_objeto_equipamento'];
                                    $email = $data_pedido_equipamento['email'];
                                    $telefone = $data_pedido_equipamento['telefone']; 
                                    $descricao = $data_pedido_equipamento['descricao_pedido'];                               
                                    $data = $data_pedido_equipamento["DATE_FORMAT(pe.datahora, '%d/%m/%y %H:%i')"];
                                    $cont = $cont + 1;  
                                ?>

                        <div class="pesquisar">
                            <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo strval($cont); ?>" aria-expanded="true" aria-controls="collapseOne">
                                                <img class="icone_acordeon" src="../../imgs/Equipamentos black.svg" alt="">
                                                
                                                <div class="accordion-content">
                                                    <div class="accordion-info">
                                                    <strong><p><?php echo $nome; ?> solicitou um Equipamento</p></strong>
                                                    </div>
                                                    <div class="accordion-dados">
                                                        <p><?php echo $data; ?></p>
                                                    </div>
                                                </div>
                                            </button>
                                    </div>
                                    <div id="collapseOne<?php echo strval($cont); ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">                            
                                        <div  class="accordion-body" >
                                            <div class="form_row">
                                                <div class="form-input"> 
                                                    <strong><label>Equipamento Solicitado:</label></strong><?php echo $nome_equipamento; ?>                              
                                                </div>
                                            </div>
                                            <div class="form_row">
                                                <div class="form-input"> 
                                                    <div class="icons">
                                                        <img src="../../imgs/email_icon.svg" class="icon">
                                                    </div>
                                                    <label class="email"><?php echo $email; ?></label>                                        
                                                </div>
                                                <div class="form-input">
                                                    <div class="icons">
                                                        <img src="../../imgs/telefone_icon.svg" class="icon">
                                                    </div>
                                                    <label class="email"><?php echo $telefone; ?></label>
                                                </div>
                                            </div>
                                            <div class="equip">
                                                <strong><label>Observações:</label></strong>
                                            </div>
                                            
                                            <div class="form-input_descricao">                                                
                                                <label class="descricao"><?php echo $descricao; ?></label>
                                            </div>

                                            <div class="botoes">
                                                <div>
                                                    <form action="../../bd/RecusarPedidoEquipamento.php" method="POST">
                                                        <input name="idpedido" style = "display: none;" value = "<?php echo $id_pedido; ?>"></input>
                                                        <input name="idequipamento" style = "display: none;" value = "<?php echo $id_equipamento; ?>"></input>
                                                        <button class="btn_recusar">Recusar</button>
                                                    </form>
                                                </div>
                                                <div>
                                                    <form action="../../bd/AceitarPedidoEquipamento.php" method="POST">
                                                        <input name="idpedido" style = "display: none;" value = "<?php echo $id_pedido; ?>"></input>
                                                        <input name="idequipamento" style = "display: none;" value = "<?php echo $id_equipamento; ?>"></input>
                                                        <button class="btn_confirmar">Confirmar</button>
                                                    </form> 
                                                </div>
                                            </div>                                     
                                        </div>
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <?php 
                            }
                            while($data_alerta_pedido = mysqli_fetch_array($resul_alerta_brinde)){
                                $cont = $cont + 1;
                                //alerta brinde data
                                $nome_brinde = $data_alerta_pedido['nome_objeto_brinde'];
                                $quantidade_brindes = $data_alerta_pedido['quantidade'];
                                ?>
                        <!-- acordeon 2 -->
                        <div class="pesquisar">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item_brinde">
                                    <div class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo strval($cont); ?>"  aria-expanded="true" aria-controls="collapseOne">
                                            <img class="icone_acordeon" src="../../imgs/brindeBlack.svg" >
                                            
                                            <div class="accordion-content">
                                                <div class="accordion-info">
                                                <strong><p>Estoque baixo <?php echo $nome_brinde; ?></p></strong>
                                                </div>
                                                <div class="accordion-dados">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                    <div id="collapseOne<?php echo strval($cont); ?>" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">                            
                                        <div  class="accordion-body" >
                                            
                                            <div class="form_row">
                                                <div class="form-input_brindes">                                            
                                                    <label><?php echo $nome_brinde; ?></label>                                        
                                                </div>
                                                <div class="form-input_brindes">                                            
                                                    <strong><label>Quantidade:</label></strong>
                                                    <strong><span><?php echo $quantidade_brindes; ?></span></strong>
                                                </div>
                                            </div>                                    
                                            <div class="botoes">
                                                <div>
                                                    <a  href="../Tela Brinde/brindes.php" class="btn_recusar">Visualizar</a>
                                                </div>
                                            </div>                                     

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
                    
                    
                </main>
                    <div id="pe_Notificacao">
                        <footer id="pe">
                            <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
                            <a href="../Tela Sobre nós/index.php" class="fabricaSoftware">Fábrica de Software T.57&#160;</a>
                            <a href="https://www.ms.senac.br/" target="_blank" class="fabricaSoftware">Senac MS</a>
                        </footer>
                    </div>
                </div>
        </div>
</body>
</html>