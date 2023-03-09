<?php
    session_name("erpExata");
    session_start();
    //verifica se os dados da sessões estão instanciados
    if (isset($_SESSION["idUsrS"]) and isset($_SESSION["nomeUsrS"]))
    {

    }else
    {
     session_destroy();
     //Limpa
     unset($_SESSION['idUsrS']);
     unset($_SESSION['nomeUsrS']);
     header("Location:login.php");
     die();
   }
?>
