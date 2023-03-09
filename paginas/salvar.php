<?php
	include "conexao.php";
	$nome = $_POST['nome'];
	$usuario = $_POST['usuario'];
	$senha = md5($_POST['senha']);

    if (!$nome || !$usuario || !$senha){
        $msg = 'Campos inválidos';
        $response = array("error" => true);
        
    }else{
	$sql = "INSERT INTO usuarios VALUES ('', '$nome', '$usuario', '$senha')";
	mysqli_query($conect, $sql) or die(error());
	$response = array("success" => true);
	echo json_encode($response);
    }
?>