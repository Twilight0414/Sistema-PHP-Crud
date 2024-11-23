<?php
session_start();
include 'db.php'; // Conexão com o banco de dados
include 'header.php';

// Consulta para buscar produtos ativos
$sql = "SELECT nome, descricao, marca, modelo, valorunitario, categoria, url_img FROM produtos WHERE ativo = 1";
$result = $conn->query($sql);
?>

<div class="container my-5">
    <!-- Saudação ao usuário -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="text-primary">Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
            <p class="lead text-muted">Veja suas informações e aproveite os recursos do sistema.</p>
        </div>
    </div>

    <!-- Exibição de produtos -->
    <div class="row g-4">
        <?php
        if ($result->num_rows > 0) {
            while ($produto = $result->fetch_assoc()) {
                // Caminho da imagem local
                $imgPath = 'img/' . htmlspecialchars($produto['url_img']);
                ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card border-light shadow-sm rounded-4 overflow-hidden h-100">
                        <!-- Ajustando a imagem para não ser cortada -->
                        <div class="card-img-container" style="height: 200px; overflow: hidden;">
                            <img src="<?php echo $imgPath; ?>" class="card-img-top img-fluid" alt="Imagem de <?php echo htmlspecialchars($produto['nome']); ?>" style="object-fit: contain; width: 100%; height: 100%;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-dark mb-3" style="font-size: 1.2rem; font-weight: 600;"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                            <p class="card-text text-muted" style="font-size: 0.9rem; margin-bottom: 1rem;"><strong>Marca:</strong> <?php echo htmlspecialchars($produto['marca']); ?></p>
                            <p class="card-text" style="font-size: 0.9rem; flex-grow: 1;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                            <p class="card-text text-primary" style="font-size: 1.1rem; font-weight: 600;">R$ <?php echo number_format($produto['valorunitario'], 2, ',', '.'); ?></p>
                            <a href="#" class="btn btn-primary mt-3">Comprar</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="col-12 text-center"><p class="text-muted">Nenhum produto disponível no momento.</p></div>';
        }
        ?>

        <!-- Seção de cartões -->
    <div class="row">
        <!-- Card de informações do usuário -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-primary rounded-3">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-person-circle me-2"></i>
                    <h5 class="mb-0">Perfil de Usuário</h5>
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    <p><strong>Último login:</strong> <?php echo date("d/m/Y H:i:s"); ?></p>
                </div>
            </div>
        </div>

        <!-- Card de ações -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-success rounded-3">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-list-task me-2"></i>
                    <h5 class="mb-0">Ações Disponíveis</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-person-plus-fill text-success me-2"></i>
                            <a href="usuarios_cadastro.php" class="text-success">Cadastrar Novo Usuário</a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-box-seam text-success me-2"></i>
                            <a href="gerenciar_produtos.php" class="text-success">Gerenciar Produtos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>

<?php
$conn->close();
include 'footer.php';
?>
