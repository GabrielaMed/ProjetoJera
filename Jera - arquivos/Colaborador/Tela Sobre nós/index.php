<?php
include("../../bd/verificacao.php");
include("../../bd/conexao.php");

if(!$_SESSION['perfil'] == 1){
    header("location: ../../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fábrica de Software T. 57</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="imgs/favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
</head>
<body>
    <iframe src="../Barra lateral Colaborador/index.php"></iframe>
    <header>
        <h1>Fábrica de Software T. 57</h1>
    </header>
    <section>
        <div class="main-content">
    
            <div class="logo-sobreNos">
                <img src="../../imgs/logoFabrica.png" alt="Logo Fábrica de Software" id="logo-fabrica">
                <div class="paragrafo">
                    <p>Somos estudantes da Fábrica de Software, que é um projeto que simula o ambiente de uma empresa de desenvolvimento de software, criando soluções tecnológicas 
                        para micro e pequenas empresas e instituições parceiras, preparando mão de obra especializada para o mercado de trabalho ao longo da execução do curso Técnico 
                        em Desenvolvimento de Sistemas.
                    </p>
                    <p>Nossa equipe abrange uma grande diversidade em faixa etária, temos adolescentes de 17 anos e adultos de até 53 anos. Esse contraste de idades traz um grande benefício, 
                        diferentes experiências, o que agrega muito em nosso convívio social. 
                    </p>
                </div>
            </div>
            <div class="container-nos">
                <div class="nossasFotos">
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/Bruna1.jpeg" alt="Foto Bruna">
                            <img id="imgHover" src="../../imgs/Bruna1.jpeg" alt="Foto Bruna">
                        </div>
                        <div class="media-icons">
                            <a href="https://github.com/Bruna-Costta" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/bruna-rodrigues-200873232/" target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                            <a href="https://www.instagram.com/brunacostta.rc/" target="_blank">
                                <i class="fa-brands fa-github-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/debora1.jpeg" alt="Foto Débora">
                            <img id="imgHover" src="../../imgs/debora2.jpeg" alt="Foto Débora">
                        </div>
                        <div class="media-icons">
                            <a href="https://www.instagram.com/debooramaral/" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/debooramaral/?originalSubdomain=br" target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                            <a href="http://https://github.com/debooramaral" target="_blank">
                                <i class="fa-brands fa-github-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/eli1.jpeg" alt="Foto Eli">
                            <img id="imgHover" src="../../imgs/eli2.jpeg" alt="Foto Eli">
                        </div>
                        <div class="media-icons">
                            <a href="https://www.instagram.com/eli_schuindt/" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/esther1.jpeg" alt="Foto Esther">
                            <img id="imgHover" src="../../imgs/esther1.jpeg" alt="Foto Esther">
                        </div>
                        <div class="media-icons">
                            <a href="https://www.instagram.com/esthermaria_rosa/" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/esther-maria-rosa-776975206/" target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                            <a href="https://github.com/Esther-Maria" target="_blank">
                                <i class="fa-brands fa-github-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/gabriela1.jpeg" alt="Foto Gabriela">
                            <img id="imgHover" src="../../imgs/gabriela2.jpeg" alt="Foto Gabriela">
                        </div>
                        <div class="media-icons">
                            <a href="https://instagram.com/gabrielasmed" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                            <a href="http://linkedin.com/in/gabrielamed" target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                            <a href="http://github.com/gabrielamed" target="_blank">
                                <i class="fa-brands fa-github-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/haroldo1.jpeg" alt="Foto Haroldo">
                            <img id="imgHover" src="../../imgs/haroldo2.jpeg" alt="Foto Haroldo">
                        </div>
                        <div class="media-icons">
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/irineu1.jpeg" alt="Foto Irineu">
                            <img id="imgHover" src="../../imgs/irineu2.jpeg" alt="Foto Irineu">
                        </div>
                        <div class="media-icons">
                            <a href="https://www.instagram.com/iri_18_1103/" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/irineu-rosa-9b5705207/" target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                            <a href="http://github.com/Irineu-rosa" target="_blank">
                                <i class="fa-brands fa-github-square"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>
                <div class="nossasFotos">
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/mariana1.jpeg" alt="Foto Mariana">
                            <img id="imgHover" src="../../imgs/mariana2.jpeg" alt="Foto Mariana">
                        </div>
                        <div class="media-icons">
                            <a href="https://www.instagram.com/amaribarros_/" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/marianabarros7/" target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                            <a href="https://github.com/mari-barros" target="_blank">
                                <i class="fa-brands fa-github-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/patrik1.jpeg" alt="Foto Patrik">
                            <img id="imgHover" src="../../imgs/patrik2.jpeg" alt="Foto Patrik">
                        </div>
                        <div class="media-icons">
                            <a href="https://www.instagram.com/mohamadff_ofc/" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                            <a href="https://github.com/PatrikMuhammad" target="_blank">
                                <i class="fa-brands fa-github-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="foto-aluno">
                            <img src="../../imgs/robson1.jpeg" alt="Foto Robson">
                            <img id="imgHover" src="../../imgs/robson2.jpeg" alt="Foto Robson">
                        </div>
                        <div class="media-icons">
                            <a href="https://www.instagram.com/robson.chaves.3939/" target="_blank">
                                <i class="fa-brands fa-instagram-square"></i>
                            </a>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
    <footer>
        <p id="ano-designedBy"> 2022 | Designed By&nbsp;</p>
        <a href="" target="_top" id="fabricaSoftware">Fábrica de Software T.57&#160;</a>
        <a href="https://www.ms.senac.br/" target="_blank" id="fabricaSoftware">Senac MS</a>
    </footer>
</body>
</html>