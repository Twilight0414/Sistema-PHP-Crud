<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        .navbar-brand {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-link {
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffc107;
        }

        .nav-item .btn-link {
            color: #fff;
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
    <nav class="navbar navbar-expand-lg p-0 navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="principal.php">Home</a>
            <a class="navbar-brand" href="usuarios_cadastro.php">Usuários</a>
            <a class="navbar-brand" href="produtos_cadastro.php">Produtos</a>
            <a class="navbar-brand" href="carrinho_cadastro.php">
                <i class="bi bi-cart" style="font-size: 1.5rem;"></i> Carrinho
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <form method="POST" action="">
                            <button class="btn btn-link nav-link text-white" name="logout" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
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
