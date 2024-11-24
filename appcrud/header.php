<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Estilo do header */
        header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            padding: 20px 0;
        }

        header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        header p {
            font-size: 1rem;
            margin: 5px 0 0;
            font-style: italic;
        }

        /* Estilo da navbar */
        .navbar {
            font-size: 1rem;
        }

        .navbar-brand, .nav-link {
            font-weight: bold;
            text-transform: uppercase; /* Todos os itens em capslock */
            letter-spacing: 1px;
            transition: color 0.3s ease;
        }

        .navbar-brand {
            color: #fff;
        }

        .nav-link {
            color: #fff;
        }

        .nav-link:hover {
            color: #007bff; /* Cor de hover igual ao header */
        }

        .nav-item .btn-link {
            color: #fff;
        }

        .nav-item .btn-link:hover {
            color: #007bff; /* Cor de hover igual ao header */
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="d-flex align-items-center">
        <div class="container text-center">
            <h1>Sistema e-Commerce</h1>
            <p>Gerencie seu negócio de forma eficiente</p>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="principal.php">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="usuarios_cadastro.php">
                        <i class="bi bi-person"></i> Usuários
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produtos_cadastro.php">
                        <i class="bi bi-box-seam"></i> Produtos
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <!-- Navbar com contagem de itens no carrinho -->
                <li class="nav-item">
                    <a class="navbar-brand" href="carrinho_cadastro.php">
                        <i class="bi bi-cart" style="font-size: 1.5rem; position: relative;">
                            <span style="position: absolute; top: -5px; right: -10px; background: #ff0000; color: #fff; font-size: 0.8rem; border-radius: 50%; padding: 2px 5px;">
                                <?php echo isset($_SESSION['carrinho']) ? array_sum(array_column($_SESSION['carrinho'], 'quantidade')) : 0; ?>
                            </span>
                        </i> Carrinho
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="" class="d-inline">
                        <button class="btn btn-link nav-link text-white" name="logout" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <?php
    // Verificação e destruição da sessão para logout
    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header("Location: principal.php"); // Redireciona para a página principal após o logout
        exit();
    }
    ?>
</body>
</html>
