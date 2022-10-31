<?php
    include ("conexao.php");
    include("verificacao.php");
    $id_usuario = $_SESSION['id_usuario'];

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if(!empty($dados['editarCampos'])){
        $image = $_FILES['foto_usuario'];
        if(!empty($_FILES["foto_usuario"]["name"])){
            $fileName = basename($_FILES["foto_usuario"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg');
            if(in_array($fileType, $allowTypes)){

                $query_get_nome = "SELECT nome, sobrenome FROM usuario where id_usuario = $id_usuario";
                $resultado = mysqli_query($con, $query_get_nome);
                
                $row = mysqli_num_rows($resultado);
                while($data  = mysqli_fetch_array($resultado)){
                    $nome = $data['nome'];
                    $sobrenome = $data['sobrenome'];
                }


                $telefone = mysqli_real_escape_string($con, $_POST['telefone']);
                $nome_sobrenome = $nome.$sobrenome;
                $nomeImage = $nome_sobrenome. "." .$fileType;

                //sql para fazer a modificação no banco de dados
                $query = "UPDATE usuario SET telefone = '$telefone', foto = '$nomeImage' where id_usuario= '$id_usuario'";
                $result = mysqli_query($con, $query);
                
                //verifica se editou
                if($result = mysqli_query($con, $query)){
                    //diretorio onde a imagem vai ser salva
                    $directory = "../fotos/$id_usuario/";
                    

                    //verifica se o diretorio existe
                    if((!file_exists($directory)) and (!is_dir($directory))){
                        //cria o diretorio
                        mkdir($directory, 0755); //0755 é o tipo de permissão
                    }

                    
                    //faz upload do arquivo
                    if(move_uploaded_file($image['tmp_name'], $directory.$nomeImage)){
                        /* //verifica se o nome da imagem já existe no banco e se o nome da imagem é diferente da imagem que o usuário está enviando
                        if(((!empty($data['foto'])) or ($data['foto'] != null)) and ($data['foto'] != $nomeImage)){
                            if(file_exists($endereco_image)){
                            }
                        } 
                        $endereco_image = "ConfigUsuario/fotos/6/".$foto;
                        unlink($endereco_image); */
                        
                        if ($_SESSION['perfil'] == 1){
                            header("Location: ../Administrador/Tela Configurações do Usuário/index.php");
                        } elseif($_SESSION['perfil'] == 2){
                            header("Location: ../Gestor/Tela Configurações do Usuário/index.php");
                        } else{
                            header("Location: ../Colaborador/Tela Configurações do Usuário/index.php");
                        }
                        
                    }
                    else{
                        echo "<p style='color:red;'>ERROR</p>";
                    }
                } 
                else{
                    echo "<p style='color:red;'>ERROR</p>";
                }
            }
            else{
                echo "<script language:'javascript'>window.alert('Você inseriu um formato inválido. Formatos permitidos: JPG, PNG ou JPEG');</script>";
            }
        }
    }
    
    if ($_SESSION['perfil'] == 1){
        header("Location: ../Administrador/Tela Configurações do Usuário/index.php");
    } elseif($_SESSION['perfil'] == 2){
        header("Location: ../Gestor/Tela Configurações do Usuário/index.php");
    } else{
        header("Location: ../Colaborador/Tela Configurações do Usuário/index.php");
    }

?>