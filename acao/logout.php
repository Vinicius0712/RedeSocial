<?php
session_start();

// Encerra todas as sessões
session_unset();
session_destroy();

// Redireciona para a página de login
header("Location: ../login/index.php");
exit();
?>