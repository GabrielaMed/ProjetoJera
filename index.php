<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilo_login.css">
    <link rel="shortcut icon" href="Jera - arquivos/imgs/favicon.svg" type="image/x-icon">
</head>
<body class="tela-login">
    <div class="container">
        <div class="container-login">
            <div class="wrap-login">

                <div class="login-form-title">
                    <img src="Jera - arquivos/imgs/logo_Jera.svg" class="logo">
                </div>

                <div class="formulario_de_login">
                    <form action="Jera - arquivos/bd/Login.php" method="post" class="forms">
                        <div class="input_login">
                            <input type="email" name="email" class="email_login" placeholder="E-mail" required="required">
                        </div>
                        <div class="input_login">
                            <input type="password" name="senha" class="senha_login" placeholder="Senha" required="required">
                        </div>
                        <div class="teste-lembrasenha"> 
                            <a href="Jera - arquivos/Tela Login/telaRestaurarSenha/restaurarSenha.html" class="esqueci_senha">
                            Esqueci minha senha
                            </a>
                        </div>
                        <button class="container-login-form-btn">Entrar</button>
                    </form>
                </div>

                <!-- container-login-form-btn -->
            </div>
        </div>
    </div>   
</body>

</html>