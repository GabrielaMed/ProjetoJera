<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
$id_usuario = $_SESSION['id_usuario'];
if(!$_SESSION['perfil'] == 3){
    header("location: ../../../index.php");
    exit();
}
$query = "SELECT id_usuario, foto, nome, sobrenome, email, telefone 
            FROM usuario 
            WHERE id_usuario = $id_usuario";
    $result = mysqli_query($con, $query);

    $row = mysqli_num_rows($result);
    while($data  = mysqli_fetch_array($result)){
        //pedid_equipamento data
        $foto = $data['foto'];
        $nome = $data['nome'];
        $sobrenome = $data['sobrenome'];
        $email = $data['email'];
        $telefone = $data['telefone'];
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="../../funções/Function.js" ></script>
    <link rel="icon" type="image/x-icon" href="../../imgs/favicon.svg">
</head>
<body> 
    <iframe src="../Barra lateral Colaborador/index.php"></iframe>
    <div class="container-content">
        <h1 id="titulo_config">Configurações do Usuário</h1>
        <main class="content">
            <!-- COLA SEU CÓDIGO AQUI -->
            <div id="corpo_config_usuario">
                <div id="form">
                    <form id="formulario-confgUsuario" method="post" action="../../bd/updateConfigUsuario.php" enctype="multipart/form-data">
                        <div class="container-foto">
                        <?php
                            if($foto != " "){
                                echo "<img class='foto' src='../../fotos/$id_usuario/$foto' alt='Foto usuário'>";
                            }
                            else{
                                echo "<img class='foto' src='../../fotos/foto_padrao.svg' alt='Foto usuário'>";
                            }
                        ?>
                            <div id="camera">
                                <label for="arquivo" id="arquivoLabel"><img id="camerazinha" src="../../imgs/addfoto_icon.svg"></label>
                                <input type="file" name="foto_usuario" id="arquivo" value="<?php echo $foto?>">
                            </div>
                        </div>
                        
                        <div class="campos">
                            <div class="campo">
                                <div class="icons">
                                    <img id="icon" src="../../imgs/colaborador_icon.svg" alt="icone do colaborador">
                                </div>
                                <input class="input_campos" type="text"  name="nome" placeholder="<?php echo $nome?>" readonly>
                            </div>
                                
                            <div class="campo" >
                                <div class="icons">
                                    <img id="icon" src="../../imgs/colaborador_icon.svg" alt="icone do colaborador">
                                </div>
                                <input class="input_campos" type="text" name="sobrenome" placeholder="<?php echo $sobrenome?>" readonly>
                            </div>
            
                            <div class="campo" >
                                <div class="icons">
                                    <img id="icon" src="../../imgs/telefone_icon.svg" alt="telefone icone">
                                </div>
                                <input class="input_campos" type="tel" name="telefone" onkeypress="return mask(event, this, '(##) # ####-####')" maxlength="16" value="<?php echo $telefone?>">
                            </div>
            
                            <div class="campo" >
                                <div class="icons">
                                    <img id="icon_email" src="../../imgs/email_icon.svg" alt="email icone">
                                </div>
                                <input class="input_campos" type="email" name="email" placeholder="<?php echo $email?>" readonly>
                            </div>
                            
                            <div class="campo_nova_senha">
                                <a class="nova_senha" onclick="abrirAviso('.modal-nova-senha')">Nova senha</a>
                            </div>
                        </div>


                        <div class="btns_cancel_salvar">
                            <a class="btn_cancelar" href="index.php">Cancelar</a>
                            <input class="btn_salvar" type="submit" value="Salvar" name="editarCampos">
                        </div>            
                    </form>            
                </div>
            </div>     

            <div class="modal-nova-senha">
                <div class="modal-content-senha">
                    <div class="head-modal-senha">
                        <h2 class="title-modal-senha">Nova Senha</h2>
                    </div>
                    <div class="body-modal-senha">
                        <form method="post" action="../../bd/updatePassword.php">
                            <div class="hold_input">
                                <div class="form-input">
                                    <input class="input-senha" type="password" id="senha" name="senha" placeholder="Senha" autocomplete="off" required>
                                    <span class="material-symbols-outlined" id="eyePassword">visibility</span>
                                </div>
                                <div class="form-input">
                                    <input class="input-senha" type="password" id="conf_senha" name="conf_senha" placeholder="Confirmar senha" autocomplete="off" required>
                                    <span class="material-symbols-outlined" id="eyeConfPassword">visibility</span>
                                </div>
                            </div>
            
                            <div class="footer-modal-senha">
                                <a class="btn_cancelar" href="index.php">Cancelar</a>
                                <button class="btn_salvar" type="submit">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
            <a href="../Tela Sobre Nós/index.php" id="fabricaSoftware">Fábrica de Software T.57&#160;</a>
            <a href="https://www.ms.senac.br/" target="_blank" id="fabricaSoftware">Senac MS</a>
        </footer>
    </div>

    <script>
        //ver senha
        document.getElementById('eyePassword').addEventListener('mousedown', function() {
            document.getElementById('senha').type = 'text';
        });
        
        document.getElementById('eyePassword').addEventListener('mouseup', function() {
            document.getElementById('senha').type = 'password';
        });
        
        // Para que o password não fique exposto apos mover a imagem.
        document.getElementById('eyePassword').addEventListener('mousemove', function() {
            document.getElementById('senha').type = 'password';
        });

        //ver confirmar senha
        document.getElementById('eyeConfPassword').addEventListener('mousedown', function() {
            document.getElementById('conf_senha').type = 'text';
        });
        
        document.getElementById('eyeConfPassword').addEventListener('mouseup', function() {
            document.getElementById('conf_senha').type = 'password';
        });
        
        // Para que o password não fique exposto apos mover a imagem.
        document.getElementById('eyeConfPassword').addEventListener('mousemove', function() {
            document.getElementById('conf_senha').type = 'password';
        });

    </script>
</body>
</html>