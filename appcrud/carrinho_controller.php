<?php
session_start();
include 'db.php'; // Conexão com o banco de dados

// Inicializa o carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Função para adicionar produto ao carrinho
function adicionarAoCarrinho($idProduto, $quantidade) {
    global $conn;

    // Verificar se o produto já está no carrinho
    if (isset($_SESSION['carrinho'][$idProduto])) {
        // Se o produto já estiver no carrinho, apenas aumenta a quantidade
        $_SESSION['carrinho'][$idProduto]['quantidade'] += $quantidade;
    } else {
        // Se o produto não estiver no carrinho, adiciona-o
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idProduto);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $produto = $resultado->fetch_assoc();
            $_SESSION['carrinho'][$idProduto] = [
                'nome' => $produto['nome'],
                'quantidade' => $quantidade,
                'valorUnitario' => $produto['valorunitario'],
                'url_img' => $produto['url_img']
            ];
        }
    }
}

// Adicionar um produto ao carrinho via POST
if (isset($_POST['adicionar'])) {
    $idProduto = $_POST['idProduto'];
    $quantidade = $_POST['quantidade'];

    adicionarAoCarrinho($idProduto, $quantidade);

    // Redireciona para a página de carrinho
    header('Location: carrinho_cadastro.php');
    exit();
}

// Remover um produto do carrinho
if (isset($_GET['remover'])) {
    $idProduto = $_GET['remover'];

    // Remove o produto do carrinho
    unset($_SESSION['carrinho'][$idProduto]);

    // Redireciona de volta para a página de carrinho
    header('Location: carrinho_cadastro.php');
    exit();
}

// Calcula o total do carrinho
function calcularTotalCarrinho() {
    $total = 0;
    foreach ($_SESSION['carrinho'] as $produto) {
        $total += $produto['quantidade'] * $produto['valorUnitario'];
    }
    return $total;
}
?>
