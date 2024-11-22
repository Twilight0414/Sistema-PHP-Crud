<?php
include 'db.php';

// Função para salvar um produto
function saveProduto($nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, marca, modelo, valorunitario, categoria, url_img, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssisi", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo);
    return $stmt->execute();
}

// Função para obter todos os produtos
function getProdutos() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Função para obter um produto específico
function getProduto($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Função para atualizar um produto
function updateProduto($id, $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo) {
    global $conn;
    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, marca = ?, modelo = ?, valorunitario = ?, categoria = ?, url_img = ?, ativo = ? WHERE id = ?");
    $stmt->bind_param("sssssisii", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo, $id);
    return $stmt->execute();
}

// Função para atualizar um campo específico de um produto
function updateField($id, $field, $value) {
    global $conn;
    $stmt = $conn->prepare("UPDATE produtos SET $field = ? WHERE id = ?");
    $stmt->bind_param("si", $value, $id);
    return $stmt->execute();
}

// Função para excluir um produto
function deleteProduto($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Processamento do formulário de cadastro/atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save']) || isset($_POST['update'])) {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $valorunitario = $_POST['valorunitario'];
        $categoria = $_POST['categoria'];
        $ativo = isset($_POST['ativo']) ? 1 : 0;

        // Verifica se há imagem e, se houver, pega o nome do arquivo
        if (isset($_FILES['url_img']) && $_FILES['url_img']['error'] == 0) {
            $nomeImagem = $_FILES['url_img']['name'];
            $caminhoImagem = "img/" . $nomeImagem;
            move_uploaded_file($_FILES['url_img']['tmp_name'], $caminhoImagem);
        } else {
            // Se não houver imagem, usa a imagem existente (caso esteja editando)
            $nomeImagem = $_POST['url_img'];
        }

        if (isset($_POST['save'])) {
            saveProduto($nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $nomeImagem, $ativo);
        } elseif (isset($_POST['update'])) {
            $id = $_POST['id'];
            updateProduto($id, $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $nomeImagem, $ativo);
        }
    }
}

// Processamento da exclusão de produto
if (isset($_GET['delete'])) {
    deleteProduto($_GET['delete']);
}

// Processamento de atualização de campo via AJAX
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];
    updateField($id, $field, $value);
    echo 'Produto atualizado com sucesso';
    exit;
}
?>
