<?php
    include("../../bd/conexao.php");
    include("../../bd/verificacao.php");
    if(!$_SESSION['perfil'] == 3){
        header("location: ../../../index.php");
            exit();
        }
    $id_usuario = $_SESSION['id_usuario'];
    $query = "SELECT usuario.foto, usuario.nome, usuario.sobrenome, perfil_usuario.nivel_usuario
            FROM usuario INNER JOIN perfil_usuario ON usuario.fk_perfil = perfil_usuario.id_perfil_usuario
            where id_usuario = $id_usuario;";

    $result = mysqli_query($con, $query);

    $row = mysqli_num_rows($result);
    while($data  = mysqli_fetch_array($result)){
        //pedid_equipamento data
        $foto = $data['foto'];
        $nome = $data['nome'];
        $sobrenome = $data['sobrenome'];
        $nivel_usuario = $data['nivel_usuario'];
        $nome_sobrenome = $nome . " " . $sobrenome;
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jera Sidebar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
</head>
<body>
    <aside class="sidebar">
        <div class="logoJera">
            <img src="../../imgs/logo.svg" alt="Logo Jera" id="logoJera">
        </div>
        <nav class="navigation">
            <div class="contain-perfil-menu">
                <div class="perfil">
                    <a href="../Tela Configurações do Usuário/index.php" target="_top">
                    <?php
                        if($foto != " "){
                            echo "<img class='foto' src='../../fotos/$id_usuario/$foto' alt='Foto usuário'>";
                        }
                        else{
                            echo "<img class='foto' src='../../fotos/foto_padrao.svg' alt='Foto usuário'>";
                        }
                    ?>
                    </a>
                    <div class="user-sino">
                        <a href="../Tela Configurações do Usuário/index.php" id="userName" target="_top"><?php echo $nome_sobrenome?></a>
                        
                    </div>
                    <div class="nivel-engrenagem">
                        <p id="userLevel"><?php echo $nivel_usuario?></p>
                        <div class="engrenagem">
                            <a href="../Tela Configurações do Usuário/index.php" target="_top"><img src="../../imgs/engrenagem.svg" alt="Engrenagem" id="iconEngrenagem"></a>
                        </div>
                    </div>
                </div>
                <div class="menu">
                    <ul>
                        <li>
                            <a href="../Tela Inicio/index.php" target="_top" class="menu-a">
                                <img class="icons" src="../../imgs/home.svg" alt="Icone Início">
                                Início
                            </a>
                        </li>
                        <li>
                            <a href="../Tela Solicitar Equipamento/SolicitarEquipamento.php" target="_top" class="menu-a">
                                <img class="icons" src="../../imgs/equipamento.svg" alt="Icone Equipamentos">
                                Equipamentos
                            </a>
                            <div class="submenu">
                                <a href="../Meu historico/meuHistorico.php" target="_top">Meu Histórico</a>
                                <a href="../Tela Solicitar Equipamento/SolicitarEquipamento.php" target="_top">Solicitar Equipamento</a>
                            </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="logout">
                <a href="../../bd/logout.php" class="menu-a" target="_top">
                    <img src="../../imgs/sair.svg" alt="Icone Sair">
                    Sair
                </a>
            </div>
        </nav>        
    </aside>
</body>
</html>