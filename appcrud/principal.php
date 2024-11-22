<?php include 'principal_controller.php'; ?>
<?php include 'header.php'; ?>

<div class="container my-5">
    <!-- Saudação ao usuário -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="text-primary">Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</h1>
            <p class="lead text-muted">Veja suas informações e aproveite os recursos do sistema.</p>
        </div>
    </div>

    <!-- Seção de cartões -->
    <div class="row">
        <!-- Card de informações do usuário -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-person-circle me-2"></i>
                    <h5 class="mb-0">Perfil de Usuário</h5>
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <p><strong>Último login:</strong> <?php echo date("d/m/Y H:i:s"); ?></p>
                </div>
            </div>
        </div>

        <!-- Card de ações -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-success">
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

    <!-- Botão de Logout -->
    <div class="row justify-content-center mt-4">
        <div class="col-12 text-center">
            <form method="POST" action="">
                <button type="submit" name="logout" class="btn btn-danger btn-lg">
                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                </button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
