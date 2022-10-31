<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
require_once("../../bd/selectObjetoEquipamento.php");
$selectEquip = new selectEquipamento;
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" 
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="icon" type="image/x-icon" href="../../imgs/EquipamentosGreen.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="../../funções/Function.js"></script>
    <link rel="stylesheet" href="estilo.css">
    <title>Equipamentos</title>
</head>
<body>
    <iframe src="../Barra lateral Administrador/index.php"></iframe>
    <div class="container-fluid">
        <!-- mude o e coloque seu id --> 
        <div id="titulo_Equip">
            <h1>Equipamentos</h1>
        
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
        <main id="main-equipamentos">
            <div id="scroll_tabela">
                <!-- mude o e coloque seu id com nome de sua tabela-->
                <table id="tabela_equipamento" style="margin-right: 2.5%;">
                    <thead>
                        <tr>
                            <th class="titulo_tabela_editar"></th>
                            <th class="titulo_tabela">Patrimônio</th>
                            <th class="titulo_tabela">Objeto</th>
                            <th class="titulo_tabela_meio">Descrição</th>
                            <th class="titulo_tabela">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query_dados_equipamento = "SELECT equipamento.id_equipamento, equipamento.fk_status, equipamento.fk_estado_conservacao, equipamento.cod_patrimonio, equipamento.descricao, status_equipamento.status_equipamento, objeto_equipamento.nome_objeto_equipamento, estado_conservacao.estado_conservacao
                            FROM equipamento 
                            INNER JOIN estado_conservacao 
                            ON estado_conservacao.id_estado_conservacao = equipamento.fk_estado_conservacao
                            INNER JOIN objeto_equipamento
                            ON objeto_equipamento.id_objeto_equipamento = equipamento.fk_objeto_equipamento
                            INNER JOIN status_equipamento
                            ON status_equipamento.id_status_equipamento = equipamento.fk_status 
                            WHERE fk_status IN ('1','2','3')
                            ORDER BY equipamento.id_equipamento ASC";
                            $result_dados_equipamento = mysqli_query($con, $query_dados_equipamento);
                            $row_dados_equipamento = mysqli_num_rows($result_dados_equipamento);
                            if ($row_dados_equipamento == '') {
                                echo "<h3>Não existem dados cadastrados</h3>";
                            } 
                            else 
                            {
                                while ($data = mysqli_fetch_array($result_dados_equipamento)){
                                    $id_equip = $data['id_equipamento'];
                                    $patrimonio = $data['cod_patrimonio'];
                                    $objeto = $data['nome_objeto_equipamento'];
                                    $descricao = $data['descricao'];
                                    $status = $data['status_equipamento'];
                                    $fk_status = $data['fk_status'];
                                    $estado_conservacao = $data['estado_conservacao'];
                                    $fk_estado = $data['fk_estado_conservacao'];
                                    $id = strval($id_equip);
                        ?>
                        <tr class="parentRow" onclick="showHideRow('linha<?php echo $id; ?>');" >
                            <td>
                                <button   onclick="abrirAviso('#editar<?php echo $id; ?>')">
                                    <img src="../../imgs/editar.svg"  alt="editar">
                                </button>
                            </td>
                            <td><?php echo $patrimonio ?></td>
                            <td><?php echo $objeto ?></td>
                            <td><?php echo $descricao ?></td>
                            <td><?php echo $status ?></td>
                        </tr>
                        <tr style="display: none;" class="subRow" id="linha<?php echo $id; ?>">
                            <td colspan="5">
                            <div class="div_nome">
                                <div id="div_nome_mae">
                               
                                <?php 
                                    $query_dados_pedido_equip = "SELECT usuario.nome, usuario.sobrenome, DATE_FORMAT(pedido_equipamento.datahora, '%d/%m/%y às %H:%i')
                                    FROM pedido_equipamento 
                                    INNER JOIN usuario
                                    ON usuario.id_usuario = pedido_equipamento.fk_pedido_usuario
                                    WHERE fk_equipamento = {$id} AND fk_validacao = 2
                                    ORDER BY datahora DESC LIMIT 1;";

                                    $result_dados_pedido_equip = mysqli_query($con, $query_dados_pedido_equip);
                                    $row_dados_pedido_equip = mysqli_num_rows($result_dados_pedido_equip);
                                    $nome_sobrenome = null;
                                    $data_solicitação = null;
                                    
                                    if($row_dados_pedido_equip == null){
                                        echo "
                                            <div class='infos'>
                                                <span>•</span><strong>Estado de conservação:</strong>
                                                <p>$estado_conservacao</p>
                                            </div>
                                            <div class='infos'>
                                                <span>•</span><strong>Responsável:</strong>
                                                <p>$nome_sobrenome</p>
                                            </div>
                                            <div class='infos'>
                                                <span>•</span><strong>Data de Empréstimo:</strong>
                                                <p>$data_solicitação</p>
                                            </div>
                                          
                                        ";
                                    }else{
                                        while ($data_pedidos = mysqli_fetch_array($result_dados_pedido_equip)){
                                            $nome_sobrenome = $data_pedidos['nome'] . " " . $data_pedidos['sobrenome'];
                                            $data_solicitação = $data_pedidos["DATE_FORMAT(pedido_equipamento.datahora, '%d/%m/%y às %H:%i')"];
                                    
                                        echo "
                                            <div class='infos'>
                                                <span>•</span><strong>Estado de conservação:</strong>
                                                <p>$estado_conservacao</p>
                                            </div>
                                            <div class='infos'>
                                                <span>•</span><strong>Responsável:</strong>
                                                <p>$nome_sobrenome</p>
                                            </div>
                                            <div class='infos'>
                                                <span>•</span><strong>Data de Empréstimo:</strong>
                                                <p>$data_solicitação</p>
                                            </div>
                                            ";
                                        }
                                    ?>
                                    
                                </div>
                            </div>
                                <?php
                                    }
                                ?>
                        </tr>
                        <!-- modal de editar equipamento -->
                        <div class="modal_equipamentos_editar" id="editar<?php echo $id; ?>">
                            <div class="modal_content_novo">
                        <!-- cabeça do aviso -->
                                <div class="head_modal_aviso">
                                    <h2 class="tit_modal">Editar Equipamento</h2>
                                </div>
                                <!-- corpo do aviso -->
                                <div class="body_modal_aviso">
                                    <form method="POST" action="../../bd/updateEquipamento.php">
                                        <input style = "display: none;" name="id_usuario" value="<?php echo $id_usuario?>">
                                        <input style = "display: none;" name="id_equipamento" value="<?php echo $id?>">
                                        <div class="form-input-div-mae">
                                            <div class="forms_row">
                                                <div class="space_forms">
                                                    <div class="form-input">                                    
                                                        <input style="text-transform: capitalize;" class="input_qtd" list="equipamentos" name="objEquip" autocomplete="off" maxlength="20" value="<?php echo $objeto; ?>">
                                                        <datalist id="equipamentos">
                                                            <?php echo $selectEquip -> selectAllObjetoEquip();?>
                                                        </datalist>
                                                    </div>                               
                                                </div>
                                                <div class="space_forms">
                                                    <div class="editar_form-input">                                   
                                                        <div class="editar_dropdown">
                                                            <button class="nivelUsuario dropdown-toggle" type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <?php echo $status?>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 130px !important;">
                                                                <li class="status" value="2"><a class="dropdown-item" href="#">Indisponivel</a></li>
                                                                <li class="status" value="1"><a class="dropdown-item" href="#">Manutenção</a></li>
                                                                <li class="status" value="3"><a class="dropdown-item" href="#">Disponivel</a></li>
                                                                <li class="status" value="4"><a class="dropdown-item" href="#">Inativo</a></li>
                                                            </div>
                                                        </div>
                                                        <input type='hidden' name='status' value='<?php echo $fk_status?>' />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="forms_row">
                                                <div class="space_forms">
                                                    <div class="form-input">                                    
                                                        <input class="input_qtd" type="text"  name="patrimonio" max-lenght="15" value="<?php echo $patrimonio; ?>" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="space_forms">
                                                    <div class="editar_form-input">                                    
                                                        <div class="editar_dropdown">
                                                            <button class="nivelUsuario dropdown-toggle" type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <?php echo $estado_conservacao?>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 161px !important;">
                                                                <?php echo $selectEquip -> selectEstadoEquip();?>  
                                                            </div>
                                                        </div>
                                                        <input type='hidden' name="estado" value='<?php echo $fk_estado?>' />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="descricao-K">
                                            <fieldset>
                                                <legend>Descrição</legend>
                                                <textarea name="descricao" id="" cols="54" maxlength="255" rows="4"style="resize: none;"><?php echo $descricao; ?></textarea>
                                            </fieldset>
                                        </div>
                                        
                                        <!-- rodape do aviso/botoes -->
                                        <div class="footer_modal_aviso">
                                            <div id="cancelar_btn">
                                                <a  href="" id="btn_cancelar_equip">Cancelar</a>
                                            </div>
                                            
                                            <div id="salvar_btn">
                                                <button type="submit"  id="btn_salvar_equip">Enviar</button>                       
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                                
                        <?php
                                }
                                }
                                $query_dados_equipamento = "SELECT equipamento.id_equipamento, equipamento.fk_status, equipamento.fk_estado_conservacao, equipamento.cod_patrimonio, equipamento.descricao, status_equipamento.status_equipamento, objeto_equipamento.nome_objeto_equipamento, estado_conservacao.estado_conservacao
                                FROM equipamento 
                                INNER JOIN estado_conservacao 
                                ON estado_conservacao.id_estado_conservacao = equipamento.fk_estado_conservacao
                                INNER JOIN objeto_equipamento
                                ON objeto_equipamento.id_objeto_equipamento = equipamento.fk_objeto_equipamento
                                INNER JOIN status_equipamento
                                ON status_equipamento.id_status_equipamento = equipamento.fk_status 
                                WHERE fk_status = 4
                                ORDER BY equipamento.id_equipamento ASC";
                                $result_dados_equipamento = mysqli_query($con, $query_dados_equipamento);
                                $row_dados_equipamento = mysqli_num_rows($result_dados_equipamento);
                                if ($row_dados_equipamento == '') {
                                    echo "<h3>Não existem dados cadastrados</h3>";
                                } 
                                else 
                                {
                                    while ($data = mysqli_fetch_array($result_dados_equipamento)){
                                        $id_equip = $data['id_equipamento'];
                                        $patrimonio = $data['cod_patrimonio'];
                                        $objeto = $data['nome_objeto_equipamento'];
                                        $descricao = $data['descricao'];
                                        $status = $data['status_equipamento'];
                                        $fk_status = $data['fk_status'];
                                        $estado_conservacao = $data['estado_conservacao'];
                                        $fk_estado = $data['fk_estado_conservacao'];
                                        $id = strval($id_equip);
                            ?>
                            <tr class="parentRow" onclick="showHideRow('linha<?php echo $id; ?>');" >
                                <td>
                                    <button   onclick="abrirAviso('#editar<?php echo $id; ?>')">
                                        <img src="../../imgs/editar.svg"  alt="editar">
                                    </button>
                                </td>
                                <td style = "color: #dcdcdc;"><?php echo $patrimonio ?></td>
                                <td style = "color: #dcdcdc;"><?php echo $objeto ?></td>
                                <td style = "color: #dcdcdc;"><?php echo $descricao ?></td>
                                <td style = "color: #808080;"><?php echo $status ?></td>
                            </tr>
                            <tr style="display: none;" class="subRow" id="linha<?php echo $id; ?>">
                                <td colspan="5">
                                <div class="div_nome">
                                    <div id="div_nome_mae">
                                   
                                    <?php 
                                        $query_dados_pedido_equip = "SELECT usuario.nome, usuario.sobrenome, DATE_FORMAT(pedido_equipamento.datahora, '%d/%m/%y às %H:%i')
                                        FROM pedido_equipamento 
                                        INNER JOIN usuario
                                        ON usuario.id_usuario = pedido_equipamento.fk_pedido_usuario
                                        WHERE fk_equipamento = {$id} AND fk_validacao = 2
                                        ORDER BY datahora DESC LIMIT 1;";
    
                                        $result_dados_pedido_equip = mysqli_query($con, $query_dados_pedido_equip);
                                        $row_dados_pedido_equip = mysqli_num_rows($result_dados_pedido_equip);
                                        $nome_sobrenome = null;
                                        $data_solicitação = null;
                                        
                                        if($row_dados_pedido_equip == null){
                                            echo "
                                                <div class='infos'>
                                                    <span>•</span><strong>Estado de conservação:</strong>
                                                    <p>$estado_conservacao</p>
                                                </div>
                                            ";
                                        }else{
                                            while ($data_pedidos = mysqli_fetch_array($result_dados_pedido_equip)){
                                                $nome_sobrenome = $data_pedidos['nome'] . " " . $data_pedidos['sobrenome'];
                                                $data_solicitação = $data_pedidos["DATE_FORMAT(pedido_equipamento.datahora, '%d/%m/%y às %H:%i')"];
                                        
                                            echo "
                                                <div class='infos'>
                                                    <span>•</span><strong>Estado de conservação:</strong>
                                                    <p>$estado_conservacao</p>
                                                </div>
                                                ";
                                            }
                                        ?>
                                        
                                    </div>
                                </div>
                                    <?php
                                        }
                                    ?>
                            </tr>
                
                            <!-- modal de editar equipamento -->
                            <div class="modal_equipamentos_editar" id="editar<?php echo $id; ?>">
                                <div class="modal_content_novo">
                            <!-- cabeça do aviso -->
                                    <div class="head_modal_aviso">
                                        <h2 class="tit_modal">Editar Equipamento</h2>
                                    </div>
                                    <!-- corpo do aviso -->
                                    <div class="body_modal_aviso">
                                        <form method="POST" action="../../bd/updateEquipamento.php">
                                            <input style = "display: none;" name="id_usuario" value="<?php echo $id_usuario?>">
                                            <input style = "display: none;" name="id_equipamento" value="<?php echo $id?>">
                                            <div class="form-input-div-mae">
                                                <div class="forms_row">
                                                    <div class="space_forms">
                                                        <div class="form-input">                                    
                                                            <input style="text-transform: capitalize;" class="input_qtd" list="equipamentos" name="objEquip" autocomplete="off" maxlength="20" value="<?php echo $objeto; ?>">
                                                            <datalist id="equipamentos">
                                                                <?php echo $selectEquip -> selectAllObjetoEquip();?>
                                                            </datalist>
                                                        </div>                               
                                                    </div>
                                                    <div class="space_forms">
                                                        <div class="editar_form-input">                                   
                                                            <div class="editar_dropdown">
                                                                <button class="nivelUsuario dropdown-toggle" type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <?php echo $status?>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 130px !important;">
                                                                    <li class="status" value="2"><a class="dropdown-item" href="#">Indisponivel</a></li>
                                                                    <li class="status" value="1"><a class="dropdown-item" href="#">Manutenção</a></li>
                                                                    <li class="status" value="3"><a class="dropdown-item" href="#">Disponivel</a></li>
                                                                    <li class="status" value="4"><a class="dropdown-item" href="#">Inativo</a></li>
                                                                </div>
                                                            </div>
                                                            <input type='hidden' name='status' value='<?php echo $fk_status?>' />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="forms_row">
                                                    <div class="space_forms">
                                                        <div class="form-input">                                    
                                                            <input class="input_qtd" type="text"  name="patrimonio" max-lenght="15" value="<?php echo $patrimonio; ?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="space_forms">
                                                        <div class="editar_form-input">                                    
                                                            <div class="editar_dropdown">
                                                                <button class="nivelUsuario dropdown-toggle" type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <?php echo $estado_conservacao?>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 161px !important;">
                                                                    <?php echo $selectEquip -> selectEstadoEquip();?>  
                                                                </div>
                                                            </div>
                                                            <input type='hidden' name="estado" value='<?php echo $fk_estado?>' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="descricao-K">
                                                <fieldset>
                                                    <legend>Descrição</legend>
                                                    <textarea name="descricao" id="" cols="54" maxlength="255" rows="4"style="resize: none;"><?php echo $descricao; ?></textarea>
                                                </fieldset>
                                            </div>
                                            
                                            <!-- rodape do aviso/botoes -->
                                            <div class="footer_modal_aviso">
                                                <div id="cancelar_btn">
                                                    <a  href="" id="btn_cancelar_equip">Cancelar</a>
                                                </div>
                                                
                                                <div id="salvar_btn">
                                                    <button type="submit"  id="btn_salvar_equip">Enviar</button>                       
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                            }
                        
                        ?>
                    </tbody>                        
                </table>
            </div>

            <!-- modal de novo equipamento -->                
            <div class="modal_equipamentos_novo" id="novo">
                <div class="modal_content_novo">
                    <!-- cabeça do aviso -->
                    <div class="head_modal_aviso">
                        <h2 class="tit_modal">Novo Equipamento</h2>
                        
                    </div>
        
                    <!-- corpo do aviso -->
                    <form class="body_modal_aviso" method="POST" action="../../bd/cadastrarNvEquip.php">
                        <div class="form-input-div-mae">
                            <div class="forms_row">
                                <div class="space_forms">
                                    <div class="form-input">                                    
                                        <input style="text-transform: capitalize;" class="input_qtd" list="equipamentos" name="objEquip" autocomplete="off" maxlength="20" placeholder="Objeto:">
                                        <datalist id="equipamentos">
                                            <?php echo $selectEquip -> selectAllObjetoEquip();?>
                                        </datalist>
                                    </div>                               
                                </div>
                                <div class="space_forms">
                                    <div class="editar_form-input">                                   
                                        <div class="editar_dropdown">
                                            <button class="nivelUsuario dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Status
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 130px !important;">
                                                <li class="status" value="2"><a class="dropdown-item" href="#">Indisponivel</a></li>
                                                <li class="status" value="1"><a class="dropdown-item" href="#">Manutenção</a></li>
                                                <li class="status" value="3"><a class="dropdown-item" href="#">Disponivel</a></li>
                                                <li class="status" value="4"><a class="dropdown-item" href="#">Inativo</a></li>
                                            </div>
                                        </div>
                                        <input type='hidden' name='status' value='' />
                                    </div>
                                </div>
                            </div>
                            <div class="forms_row">
                                <div class="space_forms">
                                    <div class="form-input">                                    
                                        <input class="input_qtd" id="input_patrimonio" onkeypress="SemCaracterEspecial('#input_patrimonio')" type="text"  name="patrimonio" max-lenght="15" placeholder="Patrimônio" autocomplete="off">
                                    </div>
                                </div>
                                <div class="space_forms">
                                    <div class="editar_form-input">                                    
                                        <div class="editar_dropdown">
                                            <button class="nivelUsuario dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Estado de Conservação
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 161px !important;">
                                                <?php echo $selectEquip -> selectEstadoEquip();?>  
                                            </div>
                                        </div>
                                        <input type='hidden' name="estado" value='' />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="descricao-K">
                            <fieldset>
                                <legend>Descrição</legend>
                                <textarea name="descricao" id="" cols="54" maxlength="255" rows="4"style="resize: none;"></textarea>
                            </fieldset>
                        </div>
                        
                        <!-- rodape do aviso/botoes -->
                        <div class="footer_modal_aviso">
                            <div id="cancelar_btn">
                                <a  href="" id="btn_cancelar_equip">Cancelar</a>
                            </div>
                            
                            <div id="salvar_btn">
                                <button type="submit"  id="btn_salvar_equip">Enviar</button>                       
                            </div>
                        </div>
                        
                    </form> 
                </div>
            </div>
        </main>
        
        <div class="btn_equipamento">
            <a href="../Relatorio Equipamentos/equipamentos.php" id="btn-relatorio">Relatorio</a>
            <button id="btn-novo" onclick="abrirAviso('.modal_equipamentos_novo')">Novo</button>
        </div>
        <div id="pe_hist">
            <footer id="pe">
                <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
                <a href="../Tela Sobre nós/index.php" class="fabricaSoftware">Fábrica de Software T.57&#160;</a>
                <a href="https://www.ms.senac.br/" target="_blank" class="fabricaSoftware">Senac MS</a>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous">
    </script>
    <script>
        $(".dropdown-menu li").click(function(){
            $(this).parents(".editar_dropdown").find('.nivelUsuario').text($(this).text());
        });

        $(function(){
            $(".dropdown-menu .status").click(function(){
                var value = $(this).attr("value");

                $("input[name='status']").val(value);
            })
        })

        $(function(){
            $(".dropdown-menu .estado").click(function(){
                var value = $(this).attr("value");

                $("input[name='estado']").val(value);
            })
        })
    </script>
                        
</body>
</html>