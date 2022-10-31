<?php
include("../../bd/conexao.php");
include("../../bd/verificacao.php");
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
    <link rel="stylesheet" href="estilo-historico.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="imgs/favicon.svg">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../funções/Function.js"></script>
    <title>Histórico</title>
</head>

<body>

    <body>
        <iframe src="../Barra lateral Gestor/index.php"></iframe>
        <div class="container">
            <!-- mude o e coloque seu id -->
            <div id="titulo_hist">
                <h1>Histórico de Empréstimo</h1>

                <div id="pesquisar">
                    <div id="pesq">
                        <div>
                            <button id="icon" href="#"><img  src="../imgs/pesquisar.svg" alt=""></button>
                        </div>
                        <div>
                            <input id="input-pesq" placeholder="Pesquisar" type="text" onkeyup="searchTableColumns()">
                        </div>
                    </div>
                </div>
            </div>

            <!-- mude o e coloque seu id -->
            <main id="main-historico">
                <div class="scroll-hist">
                    <!-- mude o e coloque seu id com nome de sua tabela-->
                    <table id="historico_tabela">
                        <thead>
                            <tr>
                                <th class="titulo_tabela">Tipo</th>
                                <th class="titulo_tabela_meio">Descrição</th>
                                <th class="titulo_tabela">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="parentRow" onclick="showHideRow('linha1');">
                                <td>Eletrônico</td>
                                <td>Positivo - 2019</td>
                                <td>Devolvido</td>
                            </tr>
                            <tr style="display: none;" class="subRow" id="linha1">
                                <td colspan="3">
                                    <p><strong><span>Descrição do Produto:</span></strong></p>
                                    <p> Intel core i5 4450 2.8 Ghz - 8 Gb de RAM com 512 Gb de HDSSD de 240 GB com leitor de DVD e com um air cooler para oprocessador.</p>
                                    <p class="datas">
                                        <span>• </span>Retirada: 12/05/2021<br><span>• </span>Devolução: 12/02/2022
                                    </p>
                                </td>
                            </tr>
                        
                           
                            
                     

                        </tbody>
                    </table>
                </div>
                <!-- mude o e coloque seu id com nome da sua tela -->

            </main>
           
            <div id="pe_hist">
                <footer id="pe">
                    <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
                    <a href="../Tela Sobre nós/index.php" class="fabricaSoftware">Fábrica de Software T.57&#160;</a>
                    <a href="https://www.ms.senac.br/" target="_blank" class="fabricaSoftware">Senac MS</a>
                </footer>
            </div>
        </div>
    </body>

</html>