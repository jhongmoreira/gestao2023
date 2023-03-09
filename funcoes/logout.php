<?php
    session_name("erpExata");
    session_start();
    session_destroy();

    header("Location: ../index.php");
?>
