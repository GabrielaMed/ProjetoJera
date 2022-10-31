<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
$id_usuario = $_SESSION['id_usuario'];
if (!$_SESSION['perfil'] == 1) {
    header("location: ../../../index.php");
    exit();
}
$maior = 0;
$menor = 1000000000000000000000000;
$query_select_kit = "SELECT * FROM kits";
$result_select_kit = $con->query($query_select_kit);
while ($data = mysqli_fetch_array($result_select_kit)) {
    $id_kit = $data['id_kits'];
    if ($id_kit > $maior) {
        $maior = $id_kit;
    }
    if ($id_kit < $menor) {
        $menor = $id_kit;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../imgs/brinde-kits.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="kits.css">
    <link rel="icon" type="image/x-icon" href="../../imgs/brindeGreen.svg">
    <script src="../../funções/Function.js"></script>
    <title>Kits</title>
</head>

<body>

    <body>
        <iframe src="../Barra lateral Administrador/index.php"></iframe>
        <div class="container">
            <div id="titulo_kits">
                <h1>Kits</h1>

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
            <main id="main-kits">
                <div id="scroll-kits">
                    <table id="kits">
                        <thead>
                            <tr class="titulok">
                                <th class="titulo_tabela_editar"></th>
                                <th class="titulo_tabela">Nome</th>
                                <th class="titulo_tabela_meio">Descrição</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            for ($i = $menor; $i <= $maior; $i++) {
                                $query_Kit_linha_tabela = "SELECT * FROM kits WHERE id_kits = $i;";
                                $result_Kit_linha_tabela = $con->query($query_Kit_linha_tabela);
                                $row = mysqli_num_rows($result_Kit_linha_tabela);
                                if ($row > 0) {
                                    if ($data = mysqli_fetch_array($result_Kit_linha_tabela)) {
                                        $id_kits = $data['id_kits'];
                                        $nome_kit = $data['nome_kit'];
                                        $descricao_kit = $data['descricao_kit'];
                                    $query_ativo = "SELECT ativo_inativo FROM kits WHERE id_kits = $i;";
                                    $result = $con ->query($query_ativo);
                                    while ($data = mysqli_fetch_array($result)){
                                            $ativo = $data['ativo_inativo'];
                                    }
                                    if($ativo == 1){
                                        ?>
                                         <tr class="parentRow" onclick="showHideRow('linha<?php echo strval($i) ?>');">
                                            <td class="colunas">
                                                <div class="conteudo coluna0">
                                                    <button class="btn_editar" onclick="abrirAviso('#editar_list<?php echo $id_kits; ?>')"><img src="../../imgs/editar.svg" alt="editar"></button>
                                                </div>
                                            </td>
                                            <td class="colunas">
                                                <div class="conteudo coluna1">
                                                    <label class="label_objeto"><?php echo $nome_kit; ?></label>
                                                </div>
                                            </td>
                                            <td class="colunas">
                                                <div class="conteudo1 coluna2">
                                                    <label class="label_descricao_conteudo"><?php echo $descricao_kit; ?></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="display: none;" class="subRow" id="linha<?php echo strval($i) ?>">
                                            <td colspan="4">
                                                <div class="contente-itens-kits">
                                                    <div class="iten-kit">
                                                        <?php
                                                        $query_Kit_linha_tabela = "SELECT k.id_kits, k.nome_kit, k.descricao_kit, ob.nome_objeto_brinde, b.descricao, b.quantidade  FROM kits k
                                                                                   JOIN itens_kit ON fk_kits = id_kits
                                                                                   JOIN brinde b ON id_brinde = fk_brinde
                                                                                   JOIN objeto_brinde ob ON id_objeto_brinde = fk_objeto_brinde
                                                                                   WHERE id_kits = $i;";
                                                        $result_Kit_linha_tabela = $con->query($query_Kit_linha_tabela);
                                                        while ($data = mysqli_fetch_array($result_Kit_linha_tabela)) {
                                                            $nome_objeto_brinde = $data['nome_objeto_brinde'];
                                                            $descricao_brinde = $data['descricao'];
                                                            $quantidade_brinde = $data['quantidade'];
                                                        ?>
                                                            <div>
                                                                <p><span class="ponto-kits">•</span><?php echo $nome_objeto_brinde . ' ' . $descricao_brinde ?><span class="qtdd-brinde-kits">(<?php echo strval($quantidade_brinde); ?>)</span></p>
                                                            </div>
                                                      <?php
                                                            }
                                                      ?>
                                                    </div>
                                                    <div class="btn-kit">
                                                        <div class="btn-kit-1">
                                                        <?php
                                                            if($ativo == 1){
                                                                ?>
                                                                    <button class="link_hover" onclick="abrirAviso('#inativar<?php echo strval($i); ?>')">Inativar Item</button>
                                                                    <div class="btn-kit-2" style = "margin-top: 10px;">
                                                                        <button onclick="abrirAviso('#saida-kit<?php echo strval($i); ?>')">Saída</button>
                                                                   </div>    
                                                                <?php
                                                            }
                                                            else if($ativo == 0){
                                                                ?>
                                                                    <button class="link_hover" onclick="abrirAviso('#ativar<?php echo strval($i); ?>')">Ativar Item</button>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        } 
                                    }
                                }
                            }
                            ?>
                            <?php
                            for ($i = $menor; $i <= $maior; $i++) {
                                $query_Kit_linha_tabela = "SELECT * FROM kits WHERE id_kits = $i;";
                                $result_Kit_linha_tabela = $con->query($query_Kit_linha_tabela);
                                $row = mysqli_num_rows($result_Kit_linha_tabela);
                                if ($row > 0) {
                                    if ($data = mysqli_fetch_array($result_Kit_linha_tabela)) {
                                        $id_kits = $data['id_kits'];
                                        $nome_kit = $data['nome_kit'];
                                        $descricao_kit = $data['descricao_kit'];
                                    $query_ativo = "SELECT ativo_inativo FROM kits WHERE id_kits = $i;";
                                    $result = $con ->query($query_ativo);
                                    while ($data = mysqli_fetch_array($result)){
                                            $ativo = $data['ativo_inativo'];
                                    }
                                    if($ativo == 0){
                                        ?>
                                        <tr style = "color: #dcdcdc;" class="parentRow" onclick="showHideRow('linha<?php echo strval($i) ?>');">
                                            <td class="colunas">
                                            </td>
                                            <td class="colunas">
                                                <div class="conteudo coluna1">
                                                    <label class="label_objeto" style = "color: #dcdcdc;"><?php echo $nome_kit; ?></label>
                                                </div>
                                            </td>
                                            <td class="colunas">
                                                <div class="conteudo1 coluna2">
                                                    <label class="label_descricao_conteudo" style = "color: #dcdcdc;"><?php echo $descricao_kit; ?></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="display: none;" class="subRow" id="linha<?php echo strval($i) ?>">
                                            <td colspan="4">
                                                <div class="contente-itens-kits">
                                                    <div class="iten-kit">
                                                        <?php
                                                        $query_Kit_linha_tabela = "SELECT k.id_kits, k.nome_kit, k.descricao_kit, ob.nome_objeto_brinde, b.descricao, b.quantidade  FROM kits k
                                                                                JOIN itens_kit ON fk_kits = id_kits
                                                                                JOIN brinde b ON id_brinde = fk_brinde
                                                                                JOIN objeto_brinde ob ON id_objeto_brinde = fk_objeto_brinde
                                                                                WHERE id_kits = $i;";
                                                        $result_Kit_linha_tabela = $con->query($query_Kit_linha_tabela);
                                                        while ($data = mysqli_fetch_array($result_Kit_linha_tabela)) {
                                                            $nome_objeto_brinde = $data['nome_objeto_brinde'];
                                                            $descricao_brinde = $data['descricao'];
                                                            $quantidade_brinde = $data['quantidade'];
                                                        ?>
                                                            <div>
                                                                <p><span class="ponto-kits">•</span><?php echo $nome_objeto_brinde . ' ' . $descricao_brinde ?><span class="qtdd-brinde-kits">(<?php echo strval($quantidade_brinde); ?>)</span></p>
                                                            </div>
                                                    <?php
                                                            }
                                                    ?>
                                                    </div>
                                                    <div class="btn-kit">
                                                        <div class="btn-kit-1">
                                                        <?php
                                                            if($ativo == 0){
                                                                ?>
                                                                    <button class="link_hover" onclick="abrirAviso('#ativar<?php echo strval($i); ?>')">Ativar Item</button>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                         </tr>
                                    <?php
                                     }
                                    ?>
                                    <div class="modal_inativar_item" id="inativar<?php echo strval($i); ?>">
                                        <div class="modal_content_inativar">
                                            <form action="../../bd/inativarkit.php" method="post">
                                                <input style = "display: none;" name="id_kit" value="<?php echo $i?>">

                                                <div class="head_modal_aviso">
                                                    <h2 class="tit_modal">Tem certeza que deseja inativar esse kit?</h2>
                                                </div>
                                                <div class="footer_modal_estoque">
                                                    <div id="cancelar_btn">
                                                        <a class="btn" id="btn_cancelar" href="">Cancelar</a>
                                                    </div>
                                                    
                                                    <div id="salvar_btn">
                                                        <button type="submit" class="btn" id="btn_salvarColab" onclick="abrirAviso('.modal_confirmar_inativar')">Inativar</button>                       
                                                    </div>
                                                </div>                                
                                            </form>
                                        </div>
                                    </div>

                                    <div class="modal_inativar_item" id="ativar<?php echo strval($i); ?>">
                                        <div class="modal_content_inativar">
                                            <form action="../../bd/ativarkit.php" method="post">
                                                <input style = "display: none;" name="id_kit" value="<?php echo $i?>">

                                                <div class="head_modal_aviso">
                                                    <h2 class="tit_modal">Tem certeza que deseja ativar o kit?</h2>
                                                </div>
                                                <div class="footer_modal_estoque">
                                                    <div id="cancelar_btn">
                                                        <a class="btn" id="btn_cancelar" href="">Cancelar</a>
                                                    </div>
                                                    
                                                    <div id="salvar_btn">
                                                        <button type="submit" class="btn" id="btn_salvarColab" onclick="abrirAviso('.modal_confirmar_inativar')">Ativar</button>                       
                                                    </div>
                                                </div>                                
                                            </form>
                                        </div>
                                    </div>

                                    <div class="modal_saida_kit" id="saida-kit<?php echo strval($i); ?>">
                                        <div class="modal_content_saida">
                                            <div class="titulos-modal-k">
                                                <h2 class="titulok-modal">Saida de Kit</h2>
                                                <p><?php echo $nome_kit . ' ' . $descricao_kit;?></p>
                                            </div>
                                            <form action="../../bd/insertSaidaKit.php" method="post">
                                                <input type="hidden" name="nome_kit" value="<?php echo $nome_kit;?>">
                                                <input style = "display: none;" name="id_kit" value="<?php echo $i?>">
                                                <div class="body_modal_saida">
                                                    <div class="modal_saida">
                                                        <div>
                                                            <label>Quantidade:</label>
                                                            <input type="text" placeholder="00" name="qtd" require>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="botoes-saida-kit">
                                                    <div id="cancelar-saida">
                                                        <a class="btn" id="btn_cancelar" href="">Cancelar</a>
                                                    </div>
                                                    <div id="salvar-saida">
                                                        <button type="submit" onclick="salvarSaida('')">Salvar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>

            <section class="modal-kits">

<div class="modal_criar" id="criar">
    <div class="modal_content_criar">
        <div class="head_modal">
            <h2 class="titulok-modal">Criar Kit</h2>
            <p>Selecione os Brindes que compõe o Kit</p>
        </div>
        <form action="../../bd/insertAddKit.php" method="POST">
            <div class="body_modal">
                <div class="nome-kit"><label for="">Nome do Kit:</label><input onkeypress="SemCaracterEspecial('#nome-kit')" type="text" name="nome-kit" id='nome-kit' maxlength="40"></div>
                <div class="descricao-k">
                    <fieldset>
                        <legend>Descrição:</legend>
                        <textarea name="descricao" maxlength="255" id="" cols="40" rows="3" style="resize: none;"></textarea>
                    </fieldset>
                </div>
                <div class="item-brinde">
                    <div class="scrolllist">
                        <div class="linha-list-brinde">
                            <!-- inserção dinamica linha 392 - 399 -->
                        </div>
                    </div>
                </div>
                <div class="botoes-criar">
                    <input style="display: block; position: absolute; width: 10px; margin-top: 5px" readOnly type="text" name="linha" class="qtdlinhacriada" value="">
                    <div id="cancelark">
                        <a href="" id='btn_cancelar'>Cancelar</a>
                    </div>
                    
                    <div id="criark">
                        <button value="submit">Criar</button>
                    </div>
                </div>
            </div>
    </div>
    </form>

    <div class="botao-adc-brinde">
        <button id="btn" title="Adicionar Item"><label id="btn_mais">Adicionar brinde</label></button>
    </div>
</div>

<div class="modal_criar_list" id="criar-list">
    <div class="modal_content_criar_lits">

        <div class="head_modal_list">
            <div class="titulos-modal-k">
                <h2 class="titulok-modal">Criar Kit</h2>
                <p>Visualize o Kit</p>
            </div>
        </div>

        <div class="body_modal_list">

            <div class="kit-montado">
                <div class="scrooldavisualizacaokit">
                    <div class="nomedokit-montado">
                        <label>Nome do Kit</label>
                    </div>
                    <div class="listdosbrindes">
                        <div class="scrooldalistbrinde">
                            <div class="itembrinde-list">
                                <input type="checkbox" id="lista-kits" name="lista-kits" checked>
                                <label for="lista-kits">BANCO DE DADOS</label>
                            </div>
                        </div>
                    </div>
                    <div class="descricaodokit">
                        <fieldset>
                            <legend>Descrição:</legend>
                            <textarea name="" id="" cols="40" rows="5" style="resize: none;"></textarea>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

        <div class="botoes-criar-list">
            <div id="voltark-list">
                <button onclick="voltarkit('.modal_add_item_3')">Voltar</button>
            </div>
            <div id="salvark-list">
                <button onclick="salvarkit('.modal_criar_list')">Salvar</button>
            </div>
        </div>

    </div>
</div>

<!-- EDITAR KIT -->
<?php
$contador = 0;
for ($i = $menor; $i <= $maior; $i++) {
    $query_editar = "SELECT k.id_kits, k.nome_kit, k.descricao_kit FROM kits k
                     LEFT JOIN itens_kit ON fk_kits = id_kits
                     LEFT JOIN brinde b ON id_brinde = fk_brinde
                     LEFT JOIN objeto_brinde ob ON id_objeto_brinde = fk_objeto_brinde
                     WHERE id_kits = $i;";
    $result_editar = $con->query($query_editar);
    $row = mysqli_num_rows($result_editar);
    
    if ($row > 0) {
        if ($data = mysqli_fetch_array($result_editar)) {
            $id_kits = $data['id_kits'];
            $nome_kit = $data['nome_kit'];
            $descricao_kit = $data['descricao_kit'];
?>
            <div class="modal_editar" id="editar_list<?php echo $id_kits; ?>">
                <div class="modal_content_editar">

                    <div class="head_modal_list">
                        <div class="titulos-modal-k">
                            <h2 class="titulok-modal">Editar Kit</h2>
                        </div>
                    </div>
                    <div class="body_modal_list">
                        <div class="kit-montado">
                            <div class="scrooldavisualizacaokit">
                                <form action="../../bd/editarKits.php" method="POST">
                                    <div class="nome-kit-edit"><label for="">Nome do Kit:</label><input type="text" maxlength="40" id="nome_editar<?php echo $id_kits; ?>" onkeypress="SemCaracterEspecial('#nome_editar<?php echo $id_kits; ?>')" name="nome-kit" value="<?php echo $nome_kit; ?>"></div>

                                    <div class="descricaodokit">
                                        <fieldset> 
                                            <legend>Descrição:</legend>
                                            <textarea name="descricao_kit" id="descricao_editar<?php echo $id_kits; ?>" onkeypress="SemCaracterEspecial('#descricao_editar<?php echo $id_kits; ?>')" maxlength="255" cols="40" rows="3" style="resize: none;"><?php echo $descricao_kit; ?></textarea>
                                            <input type="text" name="idkit" style="display: none;" value="<?php echo $i; ?>">
                                        </fieldset>
                                    </div>
                                    <div class="removeritem">
                                        <p>Remover o Item</p>
                                    </div>
                                    <div class="listdosbrindes">
                                        <div class="scroll-edit-k">
                                            <div class="scroll-edit">
                                            <?php
                                    } 
                                    $query_brinde_kit = "SELECT ob.nome_objeto_brinde, id_itens_kit, b.descricao FROM kits k
                                                         JOIN itens_kit ON fk_kits = id_kits
                                                         JOIN brinde b ON id_brinde = fk_brinde
                                                         JOIN objeto_brinde ob ON id_objeto_brinde = fk_objeto_brinde
                                                         WHERE id_kits = $i;";  
                   
                                    $result_brinde_kit = $con->query($query_brinde_kit);
                                    while ($data = mysqli_fetch_array($result_brinde_kit)){
                                        $brinde = $data['nome_objeto_brinde'];
                                        $descricao = $data['descricao'];
                                        $id_itens_kit = $data['id_itens_kit'];
                                        $contador = $contador + 1;
                                    ?>
                                                <div class="itembrinde-list-edit">
                                                    <div>
                                                        <input type="checkbox" id="lista-kits" name="lista_kits<?php echo strval($contador); ?>" value="<?php echo $id_itens_kit; ?>">
                                                    </div>
                                                    <div>
                                                        <label for="lista-kits"><?php echo $brinde. ' ' .$descricao; ?></label>
                                                    </div>
                                                </div>
                                        <?php 
                                    }
                                    ?>
                                        <input name="contador" style = "display: none;" value = "<?php echo $contador; ?>"></input>
                                            </div>
                                        </div>
                                        <div class="adcitem">
                                            <p>Adicionar Item</p>
                                        </div>
                                        <div class="descricao-k">
                                            <div class="item-brinde">
                                                <div class="scrolllist">
                                                    <div class="edt_list_brinde edt_list_brinde<?php echo $i; ?>">
                                                        <!-- inserção dinamica linha 488 - 506 -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input style="display: block; position: absolute; width: 15px; margin-top: 5px;" readonly type="text" name="linhaedt" class="qtdlinhaAdd qtdlinhaAdd<?php echo strval($i);?>" value="">
                                    <div class="botoes-editar-list">
                                    <div class="botoes-criar">
                                    <div id="cancelark">
                                        <a style="transform: translateY(-9px);" href="" id='btn_cancelar'>Cancelar</a>
                                    </div>
                                    </div>
                                    <div id="salvar-editar">
                                        <button value="submit">Salvar</button>
                                    </div>
                                </div>
                                </form>

                                <div class="botao-adc-brinde-2">
                                    <button id="btnedt" onclick="linha('.edt_list_brinde<?php echo $i;?>', '.qtdlinhaAdd<?php echo strval($i);?>')" title="Adicionar Item"><label id="btn_mais">Adicionar brinde</label></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <script type="text/javascript">
            var cont = 0;
            var btnedt = document.getElementById("btnedt");
            var maiorNum = 0;
            var addvalor = document.getElementById("qtdlinhaAdd");

            function linha(linha, addvalor){
                console.log(linha, addvalor);
                cont++;
                const brinde = document.querySelector(linha);
                const criarlinha =
                    `
                <div class="colunas-list-brinde">
                    <div class="fundo-cinza-k">
                        <div class="brindes-kit">
                            <label for="">Brinde:</label>
                            <input type="text" name = 'edtaddbrinde` + String(cont) + `' list="brindedokit" placeholder="Busque">
                        </div>
                    </div>
                </div>
                `
                brinde.innerHTML += criarlinha;
                if (cont > maiorNum) {
                    maiorNum = cont;
                }
                document.querySelector(addvalor).value = String(maiorNum);
            }
            </script>
<?php
        }
        $contador = 0;
    }
?>

<div class="modal_saida_msg" id="saida-kit">
    <div class="modal_content_saida_msg">
        
        <div class="msg-saida">
            <h2>Saída de kit registrada com sucesso</h2>
        </div>

        <div class="botao-salvar-saida">
            <div id="ok-salvar-saida">
                <button onclick="fecharaviso('')">Ok</button>
            </div>
        </div>
    </div>
</div>


</section>
<!-- mude o e coloque seu id com nome da sua tela -->
<div class="btn">
<button id="btn-novo" onclick="abrirAviso('.modal_criar')">Novo</button>
</div>

<!-- footer da pagina -->
<div id="pe_kits">
<footer id="pe">
    <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
    <a href="../Tela Sobre nós/index.php" class="fabricaSoftware">Fábrica de Software T.57&#160;</a>
    <a href="https://www.ms.senac.br/" target="_blank" class="fabricaSoftware">Senac MS</a>
</footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- funcao para adicionar linha modal -->
<script type="text/javascript">
var count = 0;
var btn = document.getElementById("btn");
var maiorNum = 0;
var cont = 0;
var btnedt = document.getElementById("btnedt");
var maiorNum = 0;
btn.onclick = function() {
    count++;
    const brinde_k = document.querySelector('.linha-list-brinde');
    const criarlinha =
        `
    <div class="colunas-list-brinde">
        <div class="fundo-cinza-k">
            <div class="brindes-kit">
                <label for="">Brinde:</label>
                <input type="text" name = 'brindeSelecao` + String(count) + `' list="brindedokit" placeholder="Busque">
            </div>
        </div>
    </div>
    `
    brinde_k.innerHTML += criarlinha;
    if (count > maiorNum) {
        maiorNum = count;

    }
    document.querySelector('.qtdlinhacriada').value = String(maiorNum);
}
btnedt.onclick = function(){
    cont++;
    const brinde = document.querySelector('.edt_list_brinde');
    const criarlinha =
        `
    <div class="colunas-list-brinde">
        <div class="fundo-cinza-k">
            <div class="brindes-kit">
                <label for="">Brinde:</label>
                <input type="text" name = 'edtaddbrinde` + String(cont) + `' list="brindedokit" placeholder="Busque">
            </div>
        </div>
    </div>
    `
    brinde.innerHTML += criarlinha;
    if (cont > maiorNum) {
        maiorNum = cont;
    }
    document.querySelector('.qtdlinhaAdd').value = String(maiorNum);
}
</script>
<datalist id="brindedokit">
<?php
$query = "SELECT nome_objeto_brinde, descricao, ativo_inativo FROM brinde
              JOIN objeto_brinde on id_objeto_brinde = fk_objeto_brinde";
$result = mysqli_query($con, $query);
while ($data = mysqli_fetch_array($result)) {
    $idBrinde = $data[''];
    $nome_objeto = $data['nome_objeto_brinde'];
    $descricao = $data['descricao']
?>
    <option value="<?php echo ''.$nome_objeto . ' | ' . $descricao.'' ?>"></option>
<?php
}
?>
</datalist>
</body>
</html>