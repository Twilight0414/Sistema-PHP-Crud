<?php
include 'db.php';

// Verifica se a sessão já foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Função para lidar com o logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Armazena informações do usuário
$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Função para obter os produtos do banco de dados de maneira segura
function getProdutos() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Função para obter um produto por ID, utilizando prepared statements
function getProdutoPorId($id_produto) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Remover um produto do carrinho
if (isset($_GET['action']) && $_GET['action'] == 'remover' && isset($_GET['id_produto'])) {
    $id_produto = (int)$_GET['id_produto'];
    if (isset($_SESSION['carrinho'][$id_produto])) {
        unset($_SESSION['carrinho'][$id_produto]);
    }
    header("Location: shopcart.php");
    exit();
}

// Alterar a quantidade de um produto no carrinho
if (isset($_POST['action']) && $_POST['action'] == 'alterar' && isset($_POST['id_produto']) && isset($_POST['quantidade'])) {
    $id_produto = (int)$_POST['id_produto'];
    $quantidade = (int)$_POST['quantidade'];

    // Verifica se a quantidade é válida
    if ($quantidade <= 0) {
        unset($_SESSION['carrinho'][$id_produto]);  // Se a quantidade for 0 ou negativa, remove o item
    } else {
        $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
        $_SESSION['carrinho'][$id_produto]['subtotal'] = $quantidade * $_SESSION['carrinho'][$id_produto]['preco'];
    }
    header("Location: shopcart.php");
    exit();
}

// Função para adicionar um produto ao carrinho
if (isset($_GET['action']) && $_GET['action'] == 'adicionar' && isset($_GET['id_produto'])) {
    $id_produto = (int)$_GET['id_produto'];

    // Busca o produto no banco de dados
    $produto = getProdutoPorId($id_produto);

    if ($produto) {
        // Se o carrinho não existir, cria um array vazio para o carrinho
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Se o produto já está no carrinho, aumenta a quantidade
        if (isset($_SESSION['carrinho'][$id_produto])) {
            $_SESSION['carrinho'][$id_produto]['quantidade']++;
        } else {
            // Caso o produto não esteja no carrinho, adiciona o produto com quantidade 1
            $_SESSION['carrinho'][$id_produto] = [
                'nome_produto' => $produto['nome'],
                'preco' => $produto['valorunitario'],
                'quantidade' => 1,
                'subtotal' => $produto['valorunitario'], // Subtotal inicial (quantidade * preço)
                'url_img' => $produto['url_img'] // URL da imagem
            ];
        }

        // Redireciona para a página do carrinho
        header("Location: shopcart.php");
        exit();
    } else {
        // Produto não encontrado no banco de dados
        echo "Produto não encontrado!";
        exit();
    }
}

// Calcular o total do carrinho
function calcularTotalCarrinho() {
    $total = 0;
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['subtotal'];
        }
    }
    return $total;
}
?>
