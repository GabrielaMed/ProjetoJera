<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
$id_usuario = $_SESSION['id_usuario'];
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
    <iframe src="../Barra lateral Gestor/index.php"></iframe>
    <div class="container-fluid">
        <div id="pe_usuario">

            <footer id="pe">
                <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
                <a href="../Tela Sobre nós/index.php" class="fabricaSoftware">Fábrica de Software T.57&#160;</a>
                <a href="https://www.ms.senac.br/" target="_blank" class="fabricaSoftware">Senac MS</a>
            </footer>
        </div>
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
                                            </div>
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
    
            
        </main>
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