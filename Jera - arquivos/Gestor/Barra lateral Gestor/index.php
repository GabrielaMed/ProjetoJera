<?php
    include("../../bd/conexao.php");
    include("../../bd/verificacao.php");
    if(!$_SESSION['perfil'] == 2){
        return $_SESSION['id_usuario'];
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
                        <?php 
                            $cont = 0;
                            $cont_brinde = 0;
                            $query_alerta_equipamento = "SELECT u.nome, oe.nome_objeto_equipamento, u.email, u.telefone, pe.descricao_pedido,
                                                         DATE_FORMAT(pe.datahora, '%d/%m/%y %H:%i'), pe.id_pedido, e.id_equipamento
                                                         FROM objeto_equipamento oe
                                                         JOIN equipamento e ON e.fk_objeto_equipamento = oe.id_objeto_equipamento
                                                         JOIN usuario u ON e.fk_usuario_equip = u.id_usuario
                                                         JOIN pedido_equipamento pe ON pe.fk_equipamento = e.id_equipamento
                                                         WHERE pe.fk_validacao = 1;";
                            
                            $result_pedido_equipamento = mysqli_query($con, $query_alerta_equipamento); 
                            $row_pedido_equipamento = mysqli_num_rows($result_pedido_equipamento);

                            $query_alerta_brinde = "SELECT ob.nome_objeto_brinde,b.quantidade
                                                    FROM objeto_brinde ob
                                                    JOIN brinde b ON  b.fk_objeto_brinde = ob.id_objeto_brinde
                                                    WHERE b.quantidade <= 10 AND ativo_inativo = 1;";

                            $resul_alerta_brinde = mysqli_query($con, $query_alerta_brinde);
                            $row_alerta_brinde = mysqli_num_rows($resul_alerta_brinde);
                            if (($row_pedido_equipamento > 0) || ($row_alerta_brinde > 0)){
                                ?>
                                    <a href="../Notificação/Notificacao.php" target="_top"><img src="../../imgs/Alerta e notificacoes.svg" alt="Sino de Notificação" id="iconSino2"></a>
                                <?php
                            }
                            else{
                                ?>
                                    <a href="../Notificação/Notificacao.php" target="_top"><img src="../../imgs/notificacao.svg" alt="Sino de Notificação" id="iconSino"></a>
                                <?php
                            }
                        ?>

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
                            <a href="../Equipamentos/index.php" target="_top" class="menu-a">
                                <img class="icons" src="../../imgs/equipamento.svg" alt="Icone Equipamentos">
                                Equipamentos
                            </a>
                            <div class="submenu">
                                <a href="../Meu historico/meuHistorico.php" target="_top">Meu Histórico</a>
                            </div>
                            <div class="submenu">
                                <a href="../Tela Solicitar Equipamento/SolicitarEquipamento.php" target="_top">Solicitar Equipamento</a>
                            </div>
                        </li>
                        <li>
                            <a href="../Tela Brinde/brindes.php" target="_top" class="menu-a" >
                                <img class="icons" src="../../imgs/brindeWhite.svg" alt="Icone Brindes">
                                Brindes
                            </a>
                            <div class="submenu">
                                <a href="../Tela Kits/kits.php" target="_top">Kits</a>
                            </div>
                        </li>
                        <li>
                            <a href="../Tela Usuario/usuario.php" target="_top" class="menu-a">
                                <img class="icons" src="../../imgs/usuarios.svg" alt="Icone Usuários">
                                Usuários
                            </a>
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