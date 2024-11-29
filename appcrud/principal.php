<?php 
include 'principal_controller.php'; 

// Pega todos os produtos para preencher os dados da tabela 
$produtos = getProdutos();
?>

<?php include 'header.php'; ?>
<div class="container my-5">
    <!-- Saudação ao usuário -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="text-primary">Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
            <p class="lead text-muted">Veja suas informações e aproveite os recursos do sistema.</p>
        </div>
    </div>


<div class="container p-2">
    <div class="row">
        <?php foreach ($produtos as $produto): ?>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card border-light shadow-sm rounded-4 overflow-hidden h-100">
                    <!-- Ajustando a imagem para não ser cortada -->
                    <div class="card-img-container" style="height: 200px; overflow: hidden;">
                        <?php 
                        // Caminho da imagem
                        $imgPath = 'img/' . htmlspecialchars($produto['url_img']); 
                        ?>
                        <img src="<?php echo $imgPath; ?>" class="card-img-top img-fluid" alt="Imagem de <?php echo htmlspecialchars($produto['nome']); ?>" style="object-fit: contain; width: 100%; height: 100%;">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-dark mb-3" style="font-size: 1.2rem; font-weight: 600;"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                        <p class="card-text text-muted" style="font-size: 0.9rem; margin-bottom: 1rem;"><strong>Marca:</strong> <?php echo htmlspecialchars($produto['marca']); ?></p>
                        <p class="card-text text-muted" style="font-size: 0.9rem; margin-bottom: 1rem;"><strong>Modelo:</strong> <?php echo htmlspecialchars($produto['modelo']); ?></p>
                        <p class="card-text" style="font-size: 0.9rem; flex-grow: 1;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        <p class="card-text text-primary" style="font-size: 1.1rem; font-weight: 600;">R$ <?php echo number_format($produto['valorunitario'], 2, ',', '.'); ?></p>
                        <!-- Formulário para adicionar ao carrinho -->
                        <form method="POST" action="principal.php">
                            <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>">
                            <button type="submit" name="adicionar_produto" class="btn btn-primary btn-block">Comprar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
