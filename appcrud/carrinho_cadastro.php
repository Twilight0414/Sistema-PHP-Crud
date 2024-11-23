<?php
session_start();
include 'db.php'; // Conexão com o banco de dados
include 'carrinho_controller.php'; // Incluir lógica do carrinho

// Se o carrinho estiver vazio
if (empty($_SESSION['carrinho'])) {
    echo "<p>Seu carrinho está vazio!</p>";
} else {
    echo "<h3>Produtos no Carrinho</h3>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>Produto</th><th>Quantidade</th><th>Valor Unitário</th><th>Total</th><th>Remover</th></tr></thead><tbody>";

    foreach ($_SESSION['carrinho'] as $idProduto => $produto) {
        $totalProduto = $produto['quantidade'] * $produto['valorUnitario'];
        echo "<tr>";
        echo "<td><img src='img/{$produto['url_img']}' alt='{$produto['nome']}' class='img-thumbnail' style='width: 100px;'> {$produto['nome']}</td>";
        echo "<td>{$produto['quantidade']}</td>";
        echo "<td>R$ " . number_format($produto['valorUnitario'], 2, ',', '.') . "</td>";
        echo "<td>R$ " . number_format($totalProduto, 2, ',', '.') . "</td>";
        echo "<td><a href='?remover={$idProduto}' class='btn btn-danger'>Remover</a></td>";
        echo "</tr>";
    }

    echo "</tbody></table>";

    // Exibir o total geral
    $totalCarrinho = calcularTotalCarrinho();
    echo "<h4>Total: R$ " . number_format($totalCarrinho, 2, ',', '.') . "</h4>";

    // Formulário de checkout
    echo "<a href='checkout.php' class='btn btn-success'>Finalizar Compra</a>";
}
?>

<!-- Formulário para adicionar mais produtos ao carrinho -->
<h3>Adicionar Produtos</h3>
<form method="POST" action="carrinho_controller.php">
    <div class="form-group">
        <label for="idProduto">Escolha um produto:</label>
        <select name="idProduto" id="idProduto" class="form-control" required>
            <?php
            // Buscar todos os produtos disponíveis
            $sql = "SELECT id, nome FROM produtos WHERE ativo = 1";
            $result = $conn->query($sql);
            while ($produto = $result->fetch_assoc()) {
                echo "<option value='{$produto['id']}'>{$produto['nome']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" value="1" required>
    </div>
    <button type="submit" name="adicionar" class="btn btn-primary">Adicionar ao Carrinho</button>
</form>
