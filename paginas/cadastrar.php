<?php
	include_once("../classes/database.php");

	$nome = $_POST['nome'];
	$usuario = $_POST['usuario'];
	$senha = md5($_POST['senha']);
    $acao = $_GET['action'];

    // $nome = "Teste";
	// $usuario = "A";
	// $senha = md5("a");
    // $acao = "gravar";

    if ($acao == 'gravar'){
        if (($nome =='') || ($usuario == '') || ($senha == '')){
            $response = array("error" => true);   
        }else{
            $banco = new BancoDeDados;
            $banco->query("INSERT INTO usuarios VALUES ('', '$nome', '$usuario', '$senha')");
            $response = array("success" => true);
            echo json_encode($response);
        }
    }
?>