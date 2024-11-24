<?php
session_start();
include 'header.php';

// Verifica se o carrinho está vazio
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo '<div class="container text-center my-5"><h3>Carrinho Vazio</h3><i class="bi bi-cart" style="font-size: 3rem; color: #ccc;"></i></div>';
    exit();
}

// Produtos no carrinho
$carrinho = $_SESSION['carrinho'];
$total = 0;
?>

<div class="container my-5">
    <h1 class="text-center">Carrinho de Compras</h1>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carrinho as $produto): ?>
                <?php $subtotal = $produto['valor'] * $produto['quantidade']; ?>
                <?php $total += $subtotal; ?>
                <tr>
                    <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                    <td>R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?></td>
                    <td><?php echo $produto['quantidade']; ?></td>
                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                    <td>
                        <form method="POST" action="carrinho_controller.php" style="display: inline;">
                            <input type="hidden" name="remover_do_carrinho" value="1">
                            <input type="hidden" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>">
                            <button class="btn btn-danger btn-sm">Remover</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h3 class="text-right">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>
    <button class="btn btn-success float-right">Finalizar Compra</button>
</div>
