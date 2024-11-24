<?php
session_start();

// Inicializa o carrinho na sessão, se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona produtos ao carrinho
if (isset($_POST['adicionar_ao_carrinho'])) {
    $produto = [
        'nome' => $_POST['nome'],
        'valor' => $_POST['valor'],
        'quantidade' => 1, // Começa com 1 unidade
    ];

    $nomeProduto = $produto['nome'];
    $carrinho = &$_SESSION['carrinho'];

    // Verifica se o produto já está no carrinho
    if (isset($carrinho[$nomeProduto])) {
        $carrinho[$nomeProduto]['quantidade'] += 1; // Incrementa a quantidade
    } else {
        $carrinho[$nomeProduto] = $produto;
    }

    echo json_encode(['success' => true, 'mensagem' => 'Produto adicionado ao carrinho!']);
    exit();
}

// Remove um produto do carrinho
if (isset($_POST['remover_do_carrinho'])) {
    $nomeProduto = $_POST['nome'];
    unset($_SESSION['carrinho'][$nomeProduto]);

    echo json_encode(['success' => true, 'mensagem' => 'Produto removido do carrinho!']);
    exit();
}

// Atualiza a quantidade de um produto
if (isset($_POST['atualizar_quantidade'])) {
    $nomeProduto = $_POST['nome'];
    $novaQuantidade = (int)$_POST['quantidade'];

    if ($novaQuantidade <= 0) {
        unset($_SESSION['carrinho'][$nomeProduto]); // Remove o produto se a quantidade for 0
    } else {
        $_SESSION['carrinho'][$nomeProduto]['quantidade'] = $novaQuantidade;
    }

    echo json_encode(['success' => true, 'mensagem' => 'Quantidade atualizada!']);
    exit();
}
?>
