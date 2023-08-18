<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/guia_brecho/models/usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $senha = password_hash($_POST["senha"],PASSWORD_DEFAULT); 
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];

    try {
        $usuario = new Usuario();
        $usuario->nome = $nome;
        $usuario->senha = $senha;
        $usuario->email = $email;
        $usuario->cpf_cnpj = $cpf;
     
        

        if (!empty($_FILES["imagem_produto"])) {
            
            $img = file_get_contents($_FILES["imagem_produto"]["tmp_name"]);
            $produto->imagem_produto = $img;
        }

        $usuario->criar();

        header("Location: /guia_brecho/views/admin/cadastrar_usuario.php");        
        exit();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}



?>