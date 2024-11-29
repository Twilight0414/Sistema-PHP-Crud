<?php
// Não há necessidade de chamar session_start() aqui, pois a sessão já foi iniciada no header.php

session_unset();  // Limpa as variáveis da sessão
session_destroy(); // Destroi a sessão
header("Location: index.php"); // Redireciona para a página inicial
exit();
?>
