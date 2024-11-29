<?php
session_start();
ini_set('display_errors', 1); // Habilita a exibição de erros
error_reporting(E_ALL); // Exibe todos os erros

include 'db.php'; // Verifique se o caminho está correto

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "Email e senha são obrigatórios.";
        exit();
    }

    // Prepara e executa a consulta na tabela de usuários
    $stmt = $conn->prepare("SELECT nome, senha FROM usuarios WHERE email = ?");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome, $hashSenha);
        $stmt->fetch();

        // Comparação direta das senhas, já que estão em texto puro no banco
        if ($senha === $hashSenha) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['nome'] = $nome;

            // Para testar se o código chega aqui:
            echo "Login bem-sucedido. Redirecionando...";

            header("Location: principal.php");
            exit();
        } else {
            echo "Senha inválida.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>
