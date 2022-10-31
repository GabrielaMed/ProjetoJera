<?php
//Página de Encerramento de Sessão
session_start();
session_destroy();
header("location: ../../index.php");
exit();
?>