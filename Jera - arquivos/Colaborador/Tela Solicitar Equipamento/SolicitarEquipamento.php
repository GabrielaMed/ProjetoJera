<?php
    include("../../bd/verificacao.php");
    require_once('../../bd/ShowTabelasColab.php');
    include("../../bd/conexao.php");
    $tabelaSolicitarEquipamento = new preenchertabelas();    
    if(!$_SESSION['perfil'] == 3){
        header("location: ../../../index.php");
            exit();
        }
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Solicitar_equipamento.css">
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.svg">
   <script src="../../funções/Function.js"></script>   
    <title>Equipamentos</title>
</head>
<body>
    <body>
        <iframe src="../Barra lateral Colaborador/index.php"></iframe>
        <div class="container">
           <!-- mude o e coloque seu id --> 
            <div id="tituloEquipamentos_colab">
                <h1>Solicitar Equipamento</h1>
           
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
            <main id="mainEquipamentos_colab">
                <div id="scrollEquipamentos_colab">
                    <!-- mude o e coloque seu id com nome de sua tabela-->
                    <table id="tabelaEquipamentos_colab">
                        <thead>
                            <tr>
                                <th class="col_equipaments_colab">Objeto</th>
                                <th class="col_equipaments_colab_meio">Descrição</th>
                                <th class="col_equipaments_colab"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT e.id_equipamento,oe.nome_objeto_equipamento, e.descricao,ec.estado_conservacao
                                          FROM equipamento e
                                          LEFT JOIN estado_conservacao ec ON ec.id_estado_conservacao  = e.fk_objeto_equipamento
                                          LEFT JOIN objeto_equipamento oe ON oe.id_objeto_equipamento = e.fk_objeto_equipamento
                                          WHERE fk_status = 3
                                          ORDER BY id_equipamento ASC";
                                $result = $con -> query($query);
                                while($data = mysqli_fetch_array($result)){
                                    $id = $data['id_equipamento'];
                                    $objeto = $data['nome_objeto_equipamento'];
                                    $descricao = $data['descricao'];
                            ?>
                                <tr class="parentRow">
                                    <td><?php echo $objeto ?></td>
                                    <td><?php echo $descricao ?></td>
                                    <td><button class="btn_solicitarEquipament" onclick="abrirAviso('<?php echo '.modalsolicitacao'. strval($id); ?>')">Solicitar</button></td>
                                </tr>
                                <tr class="subRow" style="display: none;">
                                    <td></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
                <!-- mude o e coloque seu id com nome da sua tela -->
        <?php
       
        $query = "SELECT e.id_equipamento,oe.nome_objeto_equipamento, e.descricao,ec.estado_conservacao, e.fk_status
                  FROM equipamento e
                  LEFT JOIN estado_conservacao ec ON ec.id_estado_conservacao  = e.fk_objeto_equipamento
                  LEFT JOIN objeto_equipamento oe ON oe.id_objeto_equipamento = e.fk_objeto_equipamento
                  WHERE fk_status = 3
                  ORDER BY id_equipamento ASC";
        
        $result = mysqli_query($con, $query);
        $row = mysqli_num_rows($result);

        if ($row == '') {
            echo "<h3>Não existem dados cadastrados</h3>";
        } 

        else 
        {
            while ($data = mysqli_fetch_array($result)){
                $id = $data['id_equipamento'];
                $objeto = $data['nome_objeto_equipamento'];
                $descricao = $data['descricao'];
                $estado_conservacao = $data['estado_conservacao'];                
            ?>
            
            <div class="modal_aviso <?php echo ' modalsolicitacao'. strval($id); ?>" id="aviso">
                <div class="modal_content_aviso">
                    
                    <div class="head_modal_aviso">
                        <h2 class="tit_modal">Solicitar Equipamento</h2>
                    </div>
                    <form class="body_modal_aviso" method="POST" action="../../bd/insertSolicitarEquip.php">
                        <div class="bd_modal">
                            <label id="nomeEquip"><span class="font_bold">• Equipamento:</span><?php echo $objeto;?></label>
                        </div>    

                        <div class="bd_modal">
                            <label id="descricaoequip"><span class="font_bold">• Descrição do Equipamento:</span><?php echo $descricao;?></label>
                        </div>
                                                            
                        <div class="bd_modal">
                            <label id="estadoConservcaoequip"><span class="font_bold">• Estado de Conservação:</span><?php echo $estado_conservacao; ?></label>
                        </div>
                        <div class="descricao">
                            <fieldset>
                                <legend>Descrição</legend>
                                <textarea name="DescricaoPedido" cols="40" rows="5" maxlength = '255' style="resize: none;" require></textarea>
                                <input name="idequipamento" style = "display: none;" value = "<?php echo $id; ?>"></input>
                                <input name="idusuario" style = "display: none;" value = "<?php echo $id_usuario; ?>"></input>

                            </fieldset>
                        </div>
                        <div class="footer_modal_aviso">
                            <div id="cancelar_btn">
                                <a class="btn" href="" id="btn_cancelarColab" value="Cancel" onclick="closeaviso()">Cancelar</a>
                            </div>
                            <div id="salvar_btn">
                                <button  class="btn" id="btn_salvarColab" onclick="abrirConfirma()" value="Submit">Enviar</button>                       
                            </div>
                        </div>
                    </form> 
                </div>
            </div>    
        <?php
            }
        }
        ?>
            </main>
          
            
            <div id="peEquipamentos_colab">
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