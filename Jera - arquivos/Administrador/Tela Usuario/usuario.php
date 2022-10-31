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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="../../funções/Function.js"></script>
    <link rel="icon" type="image/x-icon" href="../../imgs/usuariosGreen.svg">
    <link rel="stylesheet" href="estilo_usuario.css">
    <title>Usuarios</title>
</head>


<body>
    <!-- CHAMANDO BARRA LATERAL DE MENU PADRAO EM TODAS AS TELAS  -->
    <iframe src="../Barra lateral Administrador/index.php"></iframe>
    <!-- Aqui Começa seu codigo -->
    <div class="container-fluid">
        <!-- FOOTER - RODAPE -->
        <div id="pe_usuario">

            <footer id="pe">
                <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
                <a href="../Tela Sobre nós/index.php" class="fabricaSoftware">Fábrica de Software T.57&#160;</a>
                <a href="https://www.ms.senac.br/" target="_blank" class="fabricaSoftware">Senac MS</a>
            </footer>
        </div>
        <!--INICIO DA TELA - TITULO PRINCIPAL|| mude o e coloque seu id -->

        <div id="tituloUsuario">
            <h1>Usuários</h1>

            <div id="pesquisar">
                <div id="pesq">
                        <div>
                            <button id="icon" ><img src="../../imgs/pesquisar.svg" alt=""></button>
                        </div>
                        <div>
                            <input id="input-pesq" placeholder="Pesquisar" type="text" onkeyup="searchTableColumns()">
                        </div>
                </div>
            </div>
        </div>

        <!-- mude o e coloque seu id -->
        <main id="main-usuario">
            <div class="scroll-usuario">
                <table id="tabela_usuario">                    
                    <thead>
                        <tr>
                            <th class="titulo_tabela_icon"></th>
                            <th class="titulo_tabela_meio">Nome</th>
                            <th class="titulo_tabela_perfil" >Perfil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--2.A PRIMEIRA LINHA DE DADOS DA TABELA -->
                        <?php
                        $query = "SELECT u.id_usuario, u.nome, u.sobrenome, u.telefone, u.email, u.fk_perfil, pu.nivel_usuario, u.ativo_inativo 
                        FROM usuario u 
                        JOIN perfil_usuario pu ON pu.id_perfil_usuario = u.fk_perfil
                        ORDER BY u.ativo_inativo DESC, id_usuario ASC;";
                        $result = mysqli_query($con, $query);
                        while ($data = mysqli_fetch_array($result)) {
                            $id_usuario = $data['id_usuario'];
                            $inativo = $data['ativo_inativo'];
                            $nome = $data['nome'];
                            $sobrenome = $data['sobrenome'];
                            $telefone = $data['telefone'];
                            $email = $data['email'];
                            $fk_nivel_usuario = $data['fk_perfil'];
                            $nivel_usuario = $data['nivel_usuario'];
                            $strid = strval($id_usuario);
                            if($inativo == 0){
                        ?>
                            <tr class="parentRow">
                                <td>
                                </td>
                                <td style = "color: #dcdcdc;" onclick="showHideRow('linha<?php echo $strid ?>')"><?php echo $nome . ' ' . $sobrenome; ?></td>
                                <td style = "color: #dcdcdc;" onclick="showHideRow('linha<?php echo $strid ?>')"><?php echo $nivel_usuario; ?>(a)</td>
                            </tr>

                            <tr style="display: none;" class="subRow" id="linha<?php echo $strid ?>">
                                <td colspan="3">

                                    <div class="div_nome">
                                        <div id="div_nome_mae">
                                            <div class="infos">
                                                <span>•</span><strong>E-mail:</strong><?php echo $email; ?>
                                            </div>
                                            <div class="infos">
                                                <span>•</span><strong>Telefone:</strong><?php echo $telefone; ?>
                                            </div>
                                        </div>

                                        <div class="container_mae">
                                            
                                            <div class="div_perfil">
                                                <?php
                                                    if($inativo == 1){
                                                        ?>
                                                        <button  id="perfil" onclick="abrirAviso('#modal_inativar<?php echo $strid; ?>')">Inativar</button>
                                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                        <button id="perfil" onclick="abrirAviso('#modal_ativar<?php echo $strid; ?>')">Ativar</button>
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
                            else{
                            ?>
                            <tr class="parentRow">
                                <td>
                                    <button class="botao_editar">
                                        <img class="img_editar" onclick="abrirAviso('#editar<?php echo $strid; ?>')" src="../../imgs/editar.svg">
                                    </button>
                                </td>
                                <td onclick="showHideRow('linha<?php echo $strid ?>')"><?php echo $nome . ' ' . $sobrenome; ?></td>
                                <td onclick="showHideRow('linha<?php echo $strid ?>')"><?php echo $nivel_usuario; ?>(a)</td>
                            </tr>

                            <tr style="display: none;" class="subRow" id="linha<?php echo $strid ?>">
                                <td colspan="3">

                                    <div class="div_nome">
                                        <div id="div_nome_mae">
                                            <div class="infos">
                                                <span>•</span><strong>E-mail:</strong><?php echo $email; ?>
                                            </div>
                                            <div class="infos">
                                                <span>•</span><strong>Telefone:</strong><?php echo $telefone; ?>
                                            </div>
                                        </div>

                                        <div class="container_mae">
                                            
                                            <div class="div_perfil">
                                                <?php
                                                    if($inativo == 1){
                                                        ?>
                                                        <button  id="perfil" onclick="abrirAviso('#modal_inativar<?php echo $strid; ?>')">Inativar</button>
                                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                        <button id="perfil" onclick="abrirAviso('#modal_ativar<?php echo $strid; ?>')">Ativar</button>
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
                            <div class="modal_editar" id="editar<?php echo $strid; ?>">
                                <div class="modal-content-newUser">
                                    <div class="head-modal-newUser">
                                        <h2 class="title-modal-newUser">Editar Usuário</h2>
                                    </div>
                                    <!-- corpo do modal  -->
                                    <div class="body-modal-editUser">
                                        <form method="post" action="../../bd/updateUsuario.php">
                                            <input type="hidden" name="id_usuario_update" value="<?php echo $id_usuario?>">
                                            <div class="form-input">
                                                <div class="icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                                        class="bi bi-person" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                                    </svg>
                                                </div>
                                                <input class="input-newUser" type="text" id="nome" name="nome" value="<?php echo $nome?>"
                                                    autocomplete="off" required>
                                            </div>
                                            <div class="form-input">
                                                <div class="icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                                        class="bi bi-person" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                                    </svg>
                                                </div>
                                                <input class="input-newUser" type="text" id="sobrenome" name="sobrenome"
                                                    value="<?php echo $sobrenome?>" autocomplete="off" required>
                                            </div>
                                            <div class="form-input">
                                                <div class="icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                        class="bi bi-telephone" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                                    </svg>
                                                </div>
                                                <input class="input-newUser" onkeypress="return mask(event, this, '(##) # ####-####')" maxlength="16" value="<?php echo $telefone?>" type="tel" id="telefone" name="telefone"
                                                    autocomplete="off" required>
                                            </div>
                                            <div class="form-input">
                                                <div class="icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                        class="bi bi-envelope" viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                                    </svg>
                                                </div>
                                                <input class="input-newUser" type="email" id="email" name="email" value="<?php echo $email?>"
                                                    autocomplete="off" required>
                                            </div>
                                            <div class="form-input">
                                                <div class="icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                                        class="bi bi-person-plus" viewBox="0 0 16 16">
                                                        <path
                                                            d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                                        <path fill-rule="evenodd"
                                                            d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                                    </svg>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="nivelUsuario dropdown-toggle" type="button" id="dropdownMenuButton"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        aria-checked="undefined">
                                                        <?php echo $nivel_usuario?>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li value="1"><a class="dropdown-item" href="#">Administrador</a></li>
                                                        <li value="2"><a class="dropdown-item" href="#">Gestor</a></li>
                                                        <li value="3"><a class="dropdown-item" href="#">Colaborador</a></li>
                                                    </div>
                                                </div>
                                                <input type='hidden' name='valueDropdown' value="<?php echo $fk_nivel_usuario?>" />
                                                
                                            </div>
                                            <p id="aviso">A senha padrão será gerada automaticamente e enviada por e-mail ao usuário.
                                                Durante o primeiro acesso, o mesmo poderá alterar sua senha.</p>

                                            <div class="footer-modal-newUser">
                                                <a type="cancel" class="btn_cancelar" href="">Cancelar</a>
                                                <button class="btn_confirmar" type="submit" onclick="open_novo_ok()">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal_inativar" id="modal_inativar<?php echo $strid; ?>">
                                <div class="modal_confirma_aviso">
                                    <form method="POST" action="../../bd/inativarUsuario.php">
                                        <input type="hidden" name="id_usuario_update" value="<?php echo $id_usuario?>">
                                        <div class="head_modal_confirma">
                                            <h2 class="tit_modal_conf">Tem certeza que deseja inativar o(a) <?php echo $nome . ' ' . $sobrenome; ?>?</h2>
                                        </div>
                                        <!-- rodape do aviso/botoes -->
                                        <div class="footer_modal_confirma">
                                            <!-- botao de canelar -->
                                            <div>
                                                <a type="cancel" class="btn_cancelar" href="" >Cancelar</a>
                                            </div>
                                            <!-- botao de confirmar inativaçao -->
                                            <div>
                                                <button type="submit" class="btn_confirmar">Inativar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="modal_inativar" id="modal_ativar<?php echo $strid; ?>">
                                <div class="modal_confirma_aviso">
                                    <form method="POST" action="../../bd/ativarUsuario.php">
                                        <input type="hidden" name="id_usuario_update" value="<?php echo $id_usuario?>">
                                        <div class="head_modal_confirma">
                                            <h2 class="tit_modal_conf">Tem certeza que deseja ativar o(a) <?php echo $nome . ' ' . $sobrenome; ?>?</h2>
                                        </div>
                                        <!-- rodape do aviso/botoes -->
                                        <div class="footer_modal_confirma">
                                            <!-- botao de canelar -->
                                            <div>
                                                <a type="cancel" class="btn_cancelar" href="">Cancelar</a>
                                            </div>
                                            <!-- botao de confirmar inativaçao -->
                                            <div>
                                                <button type="submit" class="btn_confirmar">Ativar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
    
            
        </main>
        <div id="botaoUsuario">
            <button id="btn_usuario_novo" onclick="abrirAviso('.modal_novo_usuario')">Novo</button>
        </div>
    </div>


        <!-- AVISO DE CONFIRMAÇÃO APÓS INATIVAÇÃO -->
        <div class="modal_aviso_ok">
            <div class="aviso_ok">
                <div class="ok_cabecario">
                    <h2 class="ok_titulo">Perfil inativado com sucesso!</h2>
                </div>
                <div class="ok_corpo">
                    <div class="ok_botao" id="">
                        <button  class="botao_ok" onclick="close_aviso_ok()">Ok</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- MODAL DO NOVO USUARIO -->
        <div class="modal_novo_usuario" id="aviso">
            <div class="modal-content-newUser">
                <div class="head-modal-newUser">
                    <h2 class="title-modal-newUser">Novo Usuário</h2>
                </div>
                <!-- corpo do modal  -->
                <div class="body-modal-newUser">
                    <form method="post" action="../../bd/createUser.php">
                        <!-- nome  -->
                        <div class="form-input">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                </svg>
                            </div>
                            <input class="input-newUser" type="text" id="nome" name="nome" placeholder="Nome"
                                autocomplete="off" required>
                        </div>
                        <div class="form-input">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                </svg>
                            </div>
                            <input class="input-newUser" type="text" id="sobrenome" name="sobrenome"
                                placeholder="Sobrenome" autocomplete="off" required>
                        </div>
                        <div class="form-input">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                            </div>
                            <input class="input-newUser" onkeypress="return mask(event, this, '(##) # ####-####')" maxlength="16" placeholder=" (DD) 0 0000-0000" type="tel" id="telefone" name="telefone" placeholder="Telefone"
                                autocomplete="off" required>
                        </div>
                        <div class="form-input">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                </svg>
                            </div>
                            <input class="input-newUser" type="email" id="email" name="email" placeholder="E-mail"
                                autocomplete="off" required>
                        </div>
                        <div class="form-input">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-person-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                    <path fill-rule="evenodd"
                                        d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                </svg>
                            </div>
                            <div class="dropdown">
                                <button class="nivelUsuario dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    aria-checked="undefined">
                                    Perfil de Usuário
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li value="1"><a class="dropdown-item" href="#">Administrador</a></li>
                                    <li value="2"><a class="dropdown-item" href="#">Gestor</a></li>
                                    <li value="3"><a class="dropdown-item" href="#">Colaborador</a></li>
                                </div>
                            </div>
                            <input type='hidden' name='valueDropdown' value='' />
                            <input type="hidden" name="id_usuario_logged" value="<?php echo $id_usuario?>">
                        </div>
                        <p id="aviso">A senha padrão será gerada automaticamente e enviada por e-mail ao usuário.
                            Durante o primeiro acesso, o mesmo poderá alterar sua senha.</p>

                        <div class="footer-modal-newUser">
                            <a type="cancel" class="btn_cancelar" href="" >Cancelar</a>
                            <button class="btn_confirmar" type="submit" onclick="open_novo_ok()">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal_novo_ok">
            <div class="novo_aviso_ok">
                <!-- cabeça do aviso -->
                <div class="novo_ok_cabecario">
                    <h1 class="novo_ok_titulo">Perfil criado com sucesso!</h1>
                </div>
                <!-- corpo do aviso / ou botoes -->
                <div class="novo_ok_corpo">

                    <div class="novo_ok_botao">
                        <button type="submit" class="botao_ok" onclick="close_novo_ok()">Ok</button>
                    </div>

                </div>
            </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script>
        // change dropdown placeholder
        $(".dropdown-menu li").click(function(){
            $(this).parents(".dropdown").find('.nivelUsuario').text($(this).text());
        });

        //pass li value with user_level
        $(function(){
            $(".dropdown-menu li").click(function(){
                var value = $(this).attr("value");

                $("input[name='valueDropdown']").val(value);
            })
        })
    </script>
</body>

</html>