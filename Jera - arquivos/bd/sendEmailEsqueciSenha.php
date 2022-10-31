<?php
    include("conexao.php");
    include("PHPMailer/src/PHPMailer.php"); 
    include("PHPMailer/src/SMTP.php"); 
    use PHPMailer\PHPMailer\PHPMailer;
    require_once 'PHPMailer/src/Exception.php';
    

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $query = "SELECT nome, sobrenome, email, senha FROM usuario WHERE email = '$email';";
    $result = mysqli_query($con, $query);
    $row = mysqli_num_rows($result);

    if($row == ""){
        echo "<h2>Não existem dados cadastrados</h2>";

    }
    else{

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
        $mail->Username = 'gestao@jera.com.br';
        $mail->Password = 'mrdfbcyyfsbvqehi';
        $mail->Port = 587;
        

        $mail->setFrom('gestao@jera.com.br'); // email do remetente
        $mail->addReplyTo('gestao@jera.com.br'); // email do remetente
        $mail->addAddress($email, $nome_sobrenome);

        $mail->WordWrap = 50; // Definir quebra de linha
        $mail->IsHTML(true) ; // Enviar como HTML
        
        $mensagem = "<div style='text-align:center;'>
        <img src='cid:logo_jera'>
        <h1 style='display'>Sua senha está aqui!</h1>
        <p>Olá $nome_sobrenome ! Sua senha é: $senha</p>
        </div>";
        $assunto = "Recuperação de senha";
        $mail->AddEmbeddedImage('../imgs/logo_jera.png','logo_jera','logo_jera.png');
        
        $mail->Subject = $assunto ; // Assunto
        $mail->Body = '<br/>' . $mensagem . '<br/>' ; //Corpo da mensagem caso seja HTML
        $mail->AltBody = "$mensagem" ; //PlainText, para caso quem receber o email não aceite o corpo HTML

        if(!$mail->send()) {
        echo 'Não foi possível enviar a mensagem.<br>';
        echo 'Erro: ' . $mail->ErrorInfo;
        } else {
            header("location: ../Tela Login/telaEnvioCodigo/codigo.html");
        }

    }
?>