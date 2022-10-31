<?php
    include("../../bd/verificacao.php");
    $id_usuario = $_SESSION['id_usuario'];
    if(!$_SESSION['perfil'] == 3){
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
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.svg">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="../funções/Function.js"></script>
    <link rel="stylesheet" href="notificacao.css">
    <title>Histórico</title>
</head>
<body>
    <body>
        <iframe src="../Barra lateral Colaborador/index.php"></iframe>
        <div class="container">
           <!-- mude o e coloque seu id --> 
            <div id="titulo_Notificacao">
                <h1>Notificação</h1>
           
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
           
                <main id="main-Notificacao">
                    <div id="scroll_notificacao">
                        <div class="pesquisar">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                <div class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <img class="icone_acordeon" src="../../imgs/Equipamentos black.svg" alt="">
                                            
                                            <div class="accordion-content">
                                                <div class="accordion-info">
                                                <strong><p>Solicitação de Equipamento</p></strong>
                                                </div>
                                                <div class="accordion-dados">
                                                    <p>11/08/2000</p>
                                                </div>
                                            </div>
                                        </button>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">                            
                                        <div  class="accordion-body" >
                                            <div class="form_row">
                                                <div class="form-input"> 
                                                    <strong><label>Equipamento Solicitado:</label></strong>                              
                                                    <label>Notebook hd2</label>
                                                </div>
                                            </div>
                                            <div class="form_row">
                                                <div class="form-input"> 
                                                    <div class="icons">
                                                        <img src="../../imgs/email.svg" class="icon">
                                                    </div>
                                                    <label class="email">irineuRosa@hotmail.com</label>                                        
                                                </div>
                                                <div class="form-input">
                                                    <div class="icons">
                                                        <img src="../../imgs/telefone.svg" class="icon">
                                                    </div>
                                                    <label class="email">(67) 99879 - 9422</label>
                                                </div>
                                            </div>
                                            <div class="equip">
                                                <strong><label>Observações:</label></strong>
                                            </div>
                                            <div class="form-input_descricao">                                                
                                                <label class="descricao">Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae ipsa rerum asperiores quos eligendi! Voluptatem consequuntur, quia nihil optio repellat minus minima ducimus inventore reiciendis fugiat accusantium libero aliquam assumenda! adipisicing elit. Dolor vitae corrupti fuga, quia delectus pariatur autem, vero, doloremque vel optio quas quaerat nisi nihil facere incidunt eos non ad omnis.</label>
                                            </div>
                                            <div class="botoes">
                                                <div class="botoes">
                                                    <div>
                                                        <a  href="../Meu Historico/meuHistorico.php" class="btn_recusar">Visualizar</a>
                                                    </div>
                                                
                                                </div>    
                                            </div>                                     
                                        </div>
                                </div>
                                </div>                        
                            </div>
                        </div>
                </div>
                </main>
                    <div id="pe_Notificacao">
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