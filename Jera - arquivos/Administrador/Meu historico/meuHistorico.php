
<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
$id_usuario = $_SESSION['id_usuario'];
if(!$_SESSION['perfil'] == 1){
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="meuHistorico_estilo.css">
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.svg">
    <script src="../../funções/Function.js"></script>
    <title>Meu Histórico</title>
</head>
<body>
    <body>
        <iframe src="../Barra lateral Administrador/index.php"></iframe>
        <div class="container">
           <!-- mude o e coloque seu id --> 
            <div id="titulo_MeuHist">
                <h1>Meu Histórico</h1>
           
                <div id="pesquisar">
                    <div id="pesq">
                        <div>
                            <button id="icon" href="#"><img  src="../../imgs/pesquisar.svg" alt=""></button>
                        </div>
                        <div>
                            <input id="input-pesq" placeholder="Pesquisar" type="text" onkeyup="searchTableColumns()">
                        </div>
                    </div>
                </div>
            </div>

            <!-- mude o e coloque seu id -->
            <main id="main-MeuHistorico">
                <div id="scroll-Meuhist">
                    <!-- mude o e coloque seu id com nome de sua tabela-->
                    <table id="tabela_MeuHistorico" >
                        <thead>
                            <tr>
                                <th class="col_Hist">Objeto</th>
                                <th class="col_Hist_meio">Descrição</th>
                                <th class="col_Hist">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query_meu_hist = "SELECT pe.id_pedido, oe.nome_objeto_equipamento, e.descricao, DATE_FORMAT(pe.datahora, '%d/%m/%y'),
                                           DATE_FORMAT(pe.datahora_devolucao, '%d/%m/%y'), pe.fk_validacao 
                                           FROM pedido_equipamento pe
                                           JOIN equipamento e ON e.id_equipamento = pe.fk_equipamento
                                           JOIN objeto_equipamento oe ON oe.id_objeto_equipamento = e.fk_objeto_equipamento
                                           JOIN status_validacao sv ON sv.id_status = e.fk_status
                                           WHERE (fk_pedido_usuario = $id_usuario AND datahora > now() - interval 30 day) OR (fk_pedido_usuario = $id_usuario AND fk_validacao = 2)
                                           ORDER BY pe.id_pedido DESC;";
                        $result_meu_hist = $con -> query($query_meu_hist);
                        while($data = mysqli_fetch_array($result_meu_hist)){
                            $id_pedido = $data['id_pedido'];
                            $nome_objeto_equipamento = $data['nome_objeto_equipamento'];
                            $descricao_equipamento = $data['descricao'];
                            $datahora_Emprestimo = $data["DATE_FORMAT(pe.datahora, '%d/%m/%y')"]; 
                            $datahora_devolucao = $data["DATE_FORMAT(pe.datahora_devolucao, '%d/%m/%y')"];
                            $status = $data['fk_validacao'];
                            ?>
                            <tr class="parentRow"  onclick="showHideRow('linha<?php echo strval($id_pedido)?>');">
                                <td ><?php echo $nome_objeto_equipamento; ?></td>
                                <td><?php echo $descricao_equipamento; ?></td>
                                <?php 
                                if($status == 1){
                                    ?>
                                       <td><Strong>Em Analise</Strong></td>
                                    <?php
                                }
                                else if($status == 2){
                                ?>
                                    <td><Strong><button class="btn_devolver_equipamento" onclick="abrirAviso('#aviso<?php echo strval($id_pedido)?>')">Devolver</button></Strong></button></td>
                                <?php
                                }
                                else if($status == 3){
                                    ?>
                                    <td><Strong>Recusado</Strong></td>
                                    <?php
                                }
                                else if($status == 4){
                                    ?>
                                    <td><Strong>Devolvido</Strong></td>
                                    <?php
                                }
                                ?>
                             </tr>  
                             <tr style="display: none;" class="subRow" id="linha<?php echo strval($id_pedido)?>" >
                                <td colspan="3">
                                    <div class="container_pai">
                                        <div class="container_dados"> 
                                            <span>•</span><strong>Data de Emprestimo:</strong>
                                            <p><?php echo ' ' .$datahora_Emprestimo; ?></p>                                                
                                        </div>
                                        <div class="container_dados"> 
                                            <span>•</span><strong>Data de devolução:</strong>
                                            <p><?php echo ' ' .$datahora_devolucao; ?></p>                                                
                                        </div>
                                    </div>
                                </td>
                             </tr>                      
                        <?php    
                        }
                        ?>                            
                        </tbody>

                    </table>
                </div>
                <?php
                $query_meu_hist = "SELECT pe.id_pedido, id_equipamento, oe.nome_objeto_equipamento, e.descricao, DATE_FORMAT(pe.datahora, '%d/%m/%y'),
                                           DATE_FORMAT(pe.datahora_devolucao, '%d/%m/%y')
                                           FROM pedido_equipamento pe
                                           JOIN equipamento e ON e.id_equipamento = pe.fk_equipamento
                                           JOIN objeto_equipamento oe ON oe.id_objeto_equipamento = e.fk_objeto_equipamento
                                           JOIN status_validacao sv ON sv.id_status = e.fk_status
                                           WHERE (fk_pedido_usuario = $id_usuario AND datahora > now() - interval 30 day) OR (fk_pedido_usuario = $id_usuario AND fk_validacao = 2)
                                           ORDER BY pe.id_pedido DESC";
                        $result_meu_hist = $con -> query($query_meu_hist);
                        while($data = mysqli_fetch_array($result_meu_hist)){
                            $id_pedido = $data['id_pedido'];
                            $id_equipamento = $data['id_equipamento'];
                            $nome_objeto_equipamento = $data['nome_objeto_equipamento'];
                            $descricao_equipamento = $data['descricao'];
                            ?>
                <div class="modal_aviso" id="aviso<?php echo strval($id_pedido)?>">
                    <div class="modal_content_aviso">
                        
                        <div class="head_modal_aviso">
                            <h2 class="tit_modal">Devolver Equipamento</h2>
                        </div>
                        
                        <form class="body_modal_aviso" method="POST" action="../../bd/DevolverEquipamento.php" >
                            
                            <div id="container_modal">
                                <div class="infos_equip_nome">
                                    <strong><span>• Equipamento: </strong></span><label><?php echo $nome_objeto_equipamento; ?></label>
                                </div>            
                                <div class="infos_equip">
                                    <strong><span>• Descricao:</strong></span><?php echo $descricao_equipamento; ?><label></label>
                                </div>            
                            </div>

                            <div class="descricao">
                                <fieldset>
                                    <legend>Descrição</legend>
                                    <textarea name="descricao" onkeypress="SemCaracterEspecial('#descricao_devolucao')"  id="descricao_devolucao" cols="40" rows="5" maxlength="255" style="resize: none;"></textarea>
                                    <input name="idequipamento" style = "display: none;" value = "<?php echo $id_equipamento; ?>"></input>
                                    <input name="idpedidoequipamento" style = "display: none;" value = "<?php echo $id_pedido; ?>"></input>
                                </fieldset>

                            </div>
                            <!-- rodape do aviso/botoes -->
                            <div class="footer_modal_aviso">
                                <div id="cancelar_btn">
                                    <button class="btn" id="btn_cancelarColab"  onclick="closeaviso('.modal_aviso')">Cancelar</button>
                                </div>
                                
                                <div id="salvar_btn">
                                    <button type="submit" class="btn" id="btn_salvarColab" onclick="abrirConfirma('.modal_confirma')" >Enviar</button>                       
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
                <?php
            }
            ?>
            </main>
            <div id="botao_MeuHist">
            </div>
            <div id="pe_MeuHist">
                <footer id="pe">
                    <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
                    <a href="../Tela Sobre nós/index.php" class="fabricaSoftware">Fábrica de Software T.57&#160;</a>
                    <a href="https://www.ms.senac.br/" target="_blank" class="fabricaSoftware">Senac MS</a>
                </footer>
            </div>
        </div>
</body>
</html>