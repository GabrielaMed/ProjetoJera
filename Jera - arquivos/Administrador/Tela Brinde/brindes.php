<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
require_once("../../bd/selectObjetoBrinde.php");
$selectBrinde = new selectBrinde;
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
    <link rel="stylesheet" href="brindes.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="icon" type="image/x-icon" href="../../imgs/brindeGreen.svg">
    <script src="../../funções/Function.js"></script>
    <title>Brindes</title>
</head>

<body>

    <body>
        <iframe src="../Barra lateral Administrador/index.php"></iframe>
        <div class="container">

            <div id="titulo_brinde">
                <h1>Brindes</h1>

                <div id="pesquisar">
                    <div id="pesq">
                        <div>
                            <button id="icon"><img src="../../imgs/pesquisar.svg" alt=""></button>
                        </div>
                        <div>
                            <input id="input-pesq" placeholder="Pesquisar" type="text" onkeyup="searchTableColumns()">
                        </div>
                    </div>
                </div>
            </div>

            <main id="main-brinde">
                <div id="scroll-brinde">

                    <table id="tabela_brinde">
                        <thead>
                            <tr>
                                <th class="col_brinde_btn"></th>
                                <th class="col_brinde">Objeto</th>
                                <th class="col_brinde_meio">Descrição</th>
                                <th class="col_brinde_icon">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "SELECT b.id_brinde, b.descricao, b.quantidade, ob.nome_objeto_brinde, b.ativo_inativo
                                      FROM brinde b
                                      JOIN objeto_brinde ob ON ob.id_objeto_brinde = fk_objeto_brinde
                                      ORDER BY b.id_brinde ASC";
                            $result = mysqli_query($con, $query);
                            while ($data = mysqli_fetch_array($result)) {
                                $id = $data['id_brinde'];
                                $descricao = $data['descricao'];
                                $qtd  = $data['quantidade'];
                                $nome_objeto = $data['nome_objeto_brinde'];
                                $inativo = $data['ativo_inativo'];
                                $nome_brinde = $nome_objeto . " " . $descricao;
                                $strid = strval($id);
                            if($inativo == 1){
                                ?>
                                    <tr class="parentRow" style= "color: #dcdcdc;">
                                        <td>
                                            <button onclick="abrirAviso('#editar<?php echo $strid; ?>')" style="border: none; background: #fcfcfc; cursor: pointer;">
                                                <img src="../../imgs/editar.svg" alt="">
                                            </button>
                                        </td>
                                        <td onclick="showHideRow('linha<?php echo $strid; ?>');"><?php echo $nome_objeto; ?></td>
                                        <td onclick="showHideRow('linha<?php echo $strid; ?>');"><?php echo $descricao ?></td>
                                        <?php
                                        if ($qtd > 10) {
                                        ?>
                                            <td onclick="showHideRow('linha<?php echo $strid; ?>');">
                                                <div class="icone_estoque"><img src="../../imgs/aviso_white.svg" id="icone_estoque"><?php echo $qtd; ?></div>
                                            </td>
                                        <?php
                                        } else {
                                        ?>
                                            <td onclick="showHideRow('linha<?php echo $strid; ?>');">
                                                <div class="icone_estoque"><img src="../../imgs/aviso_baixo_estoque.svg" id="icone_estoque"><?php echo $qtd; ?></div>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <tr style="display: none;" class="subRow" id="linha<?php echo $strid; ?>">
                                        <td colspan="4">
                                            <div class="container_pai">
                                                <div class="container_info">
                                                    <button class="link_hover" onclick="abrirAvisoUnico('#estoque<?php echo strval($id); ?>')">Atualizar Estoque</button>
                                                    <?php
                                                        if($inativo == 1){
                                                            ?>
                                                            <button  class="link_hover" onclick="abrirAviso('#inativar<?php echo $strid; ?>')">Inativar Item</button>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <button class="link_hover" onclick="abrirAviso('#ativar<?php echo $strid; ?>')">Ativar Item</button>
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>  
                            <?php
                                }
                            ?> 
                                <div class="modal_aviso_editar" id="editar<?php echo $strid; ?>">
                                    <div class="modal_content_editar">
                                        <!-- cabeça do aviso -->
                                        <div class="head_modal_aviso">
                                            <h2 class="tit_modal">Editar Brinde</h2>
                                            <span><?php echo $nome_brinde?></span>
                                        </div>
                            
                                        <!-- corpo do aviso -->
                                        <div class="body_modal_aviso">
                                            <form action="../../bd/updateBrinde.php" method="POST">
                                                <input style = "display: none;" name="id_brinde" value="<?php echo $id?>">
                                                <div class="form-input-div-mae">
                                                    <div class="form-input">
                                                        
                                                        <input style="text-transform: capitalize;" class="input_qtd" list="brindes" name="nomebrinde" autocomplete="off" maxlength="20" value="<?php echo $nome_objeto; ?>">
                                                        <datalist id="brindes">
                                                            <?php echo $selectBrinde -> selectAllObjetoBrinde();?>                                   
                                                        </datalist>
                                                        
                                                    </div>
                                                    
                                                    <div class="descricao-K">
                                                        <fieldset>
                                                            <legend>Descrição</legend>
                                                            <textarea name="descricaobrinde" id="" cols="54" maxlength="255" rows="4"style="resize: none;" require><?php echo $descricao; ?></textarea>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <!-- rodape do aviso/botoes -->
                                                    <div class="footer_modal_aviso">
                                                        <div id="cancelar_btn">
                                                            <a class="btn" href="" id="btn_cancelarColab">Cancelar</a>
                                                        </div>
                                                        
                                                        <div id="salvar_btn">
                                                            <button type="submit" class="btn" id="btn_salvarColab">Enviar</button>                       
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                </div>

                                <div class="modal_atualizar_estoque" id="estoque<?php echo strval($id); ?>">
                                    <div class="modal_content_estoque">
                                        <div id="cancelar_x">
                                            <a href="">X</a>                                        
                                        </div>
                                        <div class="head_modal_aviso">
                                            <h2 class="tit_modal">Deseja atualizar a saída ou entrada de um brinde?</h2>
                                        </div>
                                        
                                        <!-- <form class="body_modal_aviso"> -->
                                            <div class="body_modal_aviso">
                                                <!-- rodape do aviso/botoes -->
                                                <div class="footer_modal_estoque">
                                                    <div id="cancelar_btn">
                
                                                        <button class="btn" id="btn_cancelarColab"  onclick="abrirAviso('#saida<?php echo strval($id); ?>')">Saída</button>
                                                    </div>
                                                    
                                                    <div id="salvar_btn">
                                                        <button  class="btn" id="btn_salvarColab" onclick="abrirAviso('#entrada<?php echo strval($id); ?>')">Entrada</button>                       
                                                    </div>
                                                </div>                                
                                            </div>
                                        <!-- </form>  -->
                                    </div>
                                </div>
                               
                                <div class="modal_brinde_entrada" id="entrada<?php echo strval($id); ?>">
                                    <div class="modal_content_entrada">
                                        
                                        <!-- cabeça do aviso -->
                                        <div class="head_modal_aviso">
                                            <h2 class="tit_modal">Entrada de Brinde</h2>
                                            <span><?php echo $nome_brinde?></span>
                                        </div>
                            
                                        <!-- corpo do aviso -->
                                        <div class="body_modal_aviso">
                                        <form method="POST" action="../../bd/insertEntradaBrinde.php">
                                                <input style = "display: none;" name="id_brinde" value="<?php echo $id?>">
                                                <div class="form-input-div-mae">
                                                    
                                                    <div class="form-input_saida">                                    
                                                        <input class="input_qtd" type="number" min="0" oninput="validity.valid||(value='');"  id="qtd" name="qtd" placeholder="Quantidade:" autocomplete="off">
                                                    </div>

                                                    <!-- rodape do aviso/botoes -->
                                                    <div class="footer_modal_aviso">
                                                        <div id="cancelar_btn">
                                                            <a class="btn" href="" id="btn_cancelarColab">Cancelar</a>
                                                        </div>
                                                        
                                                        <div id="salvar_btn">
                                                            <button type="submit" class="btn" id="btn_salvarColab">Enviar</button>                       
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                </div>

                                <div class="modal_brinde_saida" id="saida<?php echo strval($id);?>">
                                    <div class="modal_content_saida">
                                        
                                        <!-- cabeça do aviso -->
                                        <div class="head_modal_aviso">
                                            <h2 class="tit_modal">Saída de Brinde</h2>
                                            <span><?php echo $nome_brinde?></span>
                                        </div>
                            
                                        <!-- corpo do aviso -->
                                        <div class="body_modal_aviso">
                                            <form method="POST" action="../../bd/insertSaidaBrinde.php">
                                                <input style = "display: none;" name="id_brinde" value="<?php echo $id?>">
                                                <div class="form-input-div-mae">
                                                    
                                                    <div class="form-input_saida">                                    
                                                        <input class="input_qtd" type="number" min="0" oninput="validity.valid||(value='');"  id="qtd" name="qtd" placeholder="Quantidade:" autocomplete="off">
                                                    </div>

                                                    <div class="descricao-K">
                                                        <fieldset>
                                                            <legend>Descrição</legend>
                                                            <textarea name="descricaobrinde" id="" cols="54" maxlength="255" rows="5" style="resize: none;" require></textarea>
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <!-- rodape do aviso/botoes -->
                                                    <div class="footer_modal_aviso">
                                                        <div id="cancelar_btn">
                                                            <a class="btn" href="" id="btn_cancelarColab">Cancelar</a>
                                                        </div>
                                                        
                                                        <div id="salvar_btn">
                                                            <button type="submit" class="btn" id="btn_salvarColab">Enviar</button>                       
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                </div>

                                <div class="modal_aviso_inativar" id="inativar<?php echo $strid; ?>">
                                    <div class="modal_content_inativar">
                                        <form action="../../bd/inativarBrinde.php" method="post">
                                            <input style = "display: none;" name="id_brinde" value="<?php echo $id?>">

                                            <div class="head_modal_aviso">
                                                <h2 class="tit_modal">Tem certeza que deseja inativar esse brinde?</h2>
                                            </div>
                                            <div class="footer_modal_estoque">
                                                <div id="cancelar_btn">
                                                    <a class="btn" id="btn_cancelarColab" href="">Cancelar</a>
                                                </div>
                                                
                                                <div id="salvar_btn">
                                                    <button type="submit" class="btn" id="btn_salvarColab">Inativar</button>                       
                                                </div>
                                            </div>                                
                                        </form>
                                            
                                        <!-- </form>  -->
                                    </div>
                                </div>

                                <div class="modal_aviso_inativar" id="ativar<?php echo $strid; ?>">
                                    <div class="modal_content_inativar">
                                        <form action="../../bd/ativarBrinde.php" method="post">
                                            <input style = "display: none;" name="id_brinde" value="<?php echo $id?>">

                                            <div class="head_modal_aviso">
                                                <h2 class="tit_modal">Tem certeza que deseja ativar o brinde?</h2>
                                            </div>
                                            <div class="footer_modal_estoque">
                                                <div id="cancelar_btn">
                                                    <a class="btn" id="btn_cancelarColab" href="">Cancelar</a>
                                                </div>
                                                
                                                <div id="salvar_btn">
                                                    <button type="submit" class="btn" id="btn_salvarColab">Ativar</button>                       
                                                </div>
                                            </div>                                
                                        </form>
                                            
                                        <!-- </form>  -->
                                    </div>
                                </div>
                            <?php                    
                            }
// aq
                        $query = "SELECT b.id_brinde, b.descricao, b.quantidade, ob.nome_objeto_brinde, b.ativo_inativo
                                FROM brinde b
                                JOIN objeto_brinde ob ON ob.id_objeto_brinde = fk_objeto_brinde
                                ORDER BY b.id_brinde ASC";
                        $result = mysqli_query($con, $query);
                        while ($data = mysqli_fetch_array($result)) {
                            $id = $data['id_brinde'];
                            $descricao = $data['descricao'];
                            $qtd  = $data['quantidade'];
                            $nome_objeto = $data['nome_objeto_brinde'];
                            $inativo = $data['ativo_inativo'];
                            $nome_brinde = $nome_objeto . " " . $descricao;
                            $strid = strval($id);
                        if($inativo == 0){
                            ?>
                                <tr class="parentRow" style= "color: #dcdcdc;">
                                    <td>
                                    </td>
                                    <td style= "color: #dcdcdc;" onclick="showHideRow('linha<?php echo $strid; ?>');"><?php echo $nome_objeto; ?></td>
                                    <td style= "color: #dcdcdc;" onclick="showHideRow('linha<?php echo $strid; ?>');"><?php echo $descricao ?></td>
                                    <?php
                                    if ($qtd > 10) {
                                    ?>
                                        <td onclick="showHideRow('linha<?php echo $strid; ?>');">
                                            <div class="icone_estoque"><img src="../../imgs/aviso_white.svg" id="icone_estoque"><?php echo $qtd; ?></div>
                                        </td>
                                    <?php
                                    } else {
                                    ?>
                                        <td onclick="showHideRow('linha<?php echo $strid; ?>');">
                                            <div class="icone_estoque"><img src="../../imgs/aviso_baixo_estoque.svg" id="icone_estoque"><?php echo $qtd; ?></div>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                <tr style="display: none;" class="subRow" id="linha<?php echo $strid; ?>">
                                    <td colspan="4">
                                        <div class="container_pai">
                                            <div class="container_info">
                                                <?php
                                                    if($inativo == 0){
                                                        ?>
                                                        <button class="link_hover" onclick="abrirAviso('#ativar<?php echo $strid; ?>')">Ativar Item</button>
                                                        <?php
                                                    }
                                                ?>
                                                
                                            </div>
                                        </div>
                                    </td>
                                </tr>  
                        <?php
                            }                
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <div class="modal_aviso" id="aviso">
                    <div class="modal_content_aviso">
                        <!-- cabeça do aviso -->
                        <div class="head_modal_aviso">
                            <h2 class="tit_modal">Criar Brinde</h2>
                            <span>Adcionar um novo brinde a lista</span>
                        </div>
            
                        <!-- corpo do aviso -->
                        
                        <form class="body_modal_aviso" method="POST" action="../../bd/insertAddBrinde.php">
                            <div class="form-input-div-mae">
                                <div class="form-input">
                                    
                                    <input style="text-transform: capitalize;" class="input_qtd" list="brindes" name="nomebrinde" autocomplete="off" maxlength="20" placeholder="Objeto:">
                                    <datalist id="brindes">
                                        <?php echo $selectBrinde -> selectAllObjetoBrinde();?>                                  
                                    </datalist>
                                    
                                </div>
                                
                                <div class="form-input">                                    
                                    <input class="input_qtd" type="number" id="qtd" name="qtd" placeholder="Quantidade:" autocomplete="off">
                                </div>
                                
                                <div class="descricao-K">
                                    <fieldset>
                                        <legend>Descrição</legend>
                                        <textarea name="descricaobrinde" id="" cols="54" maxlength="255" rows="5"style="resize: none;" require></textarea>
                                    </fieldset>
                                </div>
                                
                                <!-- rodape do aviso/botoes -->
                                <div class="footer_modal_aviso">
                                    <div id="cancelar_btn">
                                        <a class="btn" href="" id="btn_cancelarColab">Cancelar</a>
                                    </div>
                                    
                                    <div id="salvar_btn">
                                        <button type="submit" class="btn" id="btn_salvarColab">Enviar</button>                       
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>

            </main>
            <div class="btn">
                <a href="../Relatorio Brindes/brindes.php" id="btn-relatorio">Relatório</a>
                <button id="btn-novo"  onclick="abrirAviso('.modal_aviso')">Novo</button>
            </div>

            <div id="pe_brinde">
                <footer id="pe">
                    <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
                    <a href="../Tela sobre nós/index.php" class="fabricaSoftware">Fábrica de Software T.57&#160;</a>
                    <a href="https://www.ms.senac.br/" target="_blank" class="fabricaSoftware">Senac MS</a>
                </footer>
            </div>


            <div class="modal_brinde_saida" id="modal_qtd">
                <div class="modal_content_saida">
                    
                    <div class="head_modal_aviso">
                        <h2 class="tit_modal"><?php echo $message_qtd?></h2>
                    </div>
                    <div id="salvar_btn">
                        <a class="btn" id="btn_salvarColab" href="">ok</a>                       
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>