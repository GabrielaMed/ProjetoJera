<?php
    include ("conexao.php");
    include("PHPMailer/src/PHPMailer.php"); 
    include("PHPMailer/src/SMTP.php"); 
    include("verificacao.php");
    use PHPMailer\PHPMailer\PHPMailer;

    require_once 'PHPMailer/src/Exception.php';
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';

    $nome = mysqli_real_escape_string($con, $_POST["nome"]);
    $sobrenome = mysqli_real_escape_string($con, $_POST['sobrenome']);
    $telefone = mysqli_real_escape_string($con, $_POST['telefone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $senha = md5('novasenha');
    $foto = ' ';
    $inativo = 1;
    $fk_id_perfil_usuario = mysqli_real_escape_string($con, $_POST['valueDropdown']);
    $id_usuario = $_SESSION['id_usuario'];

    if(empty($nome) || empty($sobrenome) || empty($telefone) || empty($email)){
        if ($_SESSION['perfil'] == 1){
            header("location: ../Administrador/Tela Usuario/usuario.php");
        } else{
            header("location: ../Gestor/Tela Usuario/usuario.php");
        }
    }
    else{
        $query = "SELECT id_usuario FROM usuario WHERE email = '{$email}'";
        $result = mysqli_query($con, $query);

        if($result->fetch_row()>0){
            echo "<script language:'javascript'> window.alert('Email já cadastrado!');</script>";
            if ($_SESSION['perfil'] == 1){
                header("location: ../Administrador/Tela Usuario/usuario.php");
            } else{
                header("location: ../Gestor/Tela Usuario/usuario.php");
            }
            
        }
        else{
            $query = "INSERT INTO usuario value(null, '{$nome}', '{$sobrenome}', '{$telefone}', '{$email}', '{$senha}', '{$foto}', '{$inativo}', '{$fk_id_perfil_usuario}')";
            $result = mysqli_query($con, $query);
            
            if ($result == ''){
                echo "<script language:'javascript'> window.alert('Não foi possivel efetuar o cadastro!');";
                if ($_SESSION['perfil'] == 1){
                    header("location: ../Administrador/Tela Usuario/usuario.php");
                } else{
                    header("location: ../Gestor/Tela Usuario/usuario.php");
                }
            }else{
                //envia email com a senha padrão
                $query = "SELECT nome, sobrenome, email, senha FROM usuario WHERE email = '$email';";
                $result = mysqli_query($con, $query);
                $row = mysqli_num_rows($result);

                while($data  = mysqli_fetch_array($result)){
                    $nome = $data['nome'];
                    $sobrenome = $data['sobrenome'];
                    $nome_sobrenome = $nome . " " . $sobrenome;
                    $email = $data['email'];
                    $senha = $data['senha'];
                    
                }
        
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Username = ''; //email remetente
                $mail->Password = ''; //senha do email do remetente
                $mail->Port = 587;
                
        
                $mail->setFrom(''); //email remetente
                $mail->addReplyTo(''); //email remetente
                $mail->addAddress($email, $nome_sobrenome);
        
                $mail->WordWrap = 50; // Definir quebra de linha
                $mail->IsHTML(true) ; // Enviar como HTML
                
                $mensagem = "<div style='text-align:center;'>
                <img src='cid:logo_jera'>
                <h1 style='display'>Sua senha está aqui!</h1>
                <p>Olá $nome_sobrenome ! Sua senha é: $senha</p>
                </div>";
                $assunto = "Senha padrão";
                $mail->AddEmbeddedImage('../imgs/logo_jera.png','logo_jera','logo_jera.png');
        
                $mail->Subject = $assunto ; // Assunto
                $mail->Body = '<br/>' . $mensagem . '<br/>' ; //Corpo da mensagem caso seja HTML
                $mail->AltBody = "$mensagem" ; //PlainText, para caso quem receber o email não aceite o corpo HTML
        
                if(!$mail->send()) {
                echo 'Não foi possível enviar a mensagem.<br>';
                echo 'Erro: ' . $mail->ErrorInfo;
                } else {
                    echo "<script language:'javascript'> window.alert('Cadastrado com sucesso!');";
                    if($nivel_usuario == 1){
                        header("location: ../Administrador/Tela Usuario/usuario.php");
                    } else{
                        header("location: ../Gestor/Tela Usuario/usuario.php");
                    }
                    
                }
            } 
        }
    }
?>