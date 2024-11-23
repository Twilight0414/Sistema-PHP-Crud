<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Redireciona para a página de login caso o usuário não esteja autenticado
    header('Location: login.php');
    exit(); // Garante que o restante do código não será executado
}

include 'usuarios_controller.php';
include 'header.php';

// Pega todos os usuários para preencher os dados da tabela
$users = getUsers();

// Variável que guarda o ID do usuário que será editado
$userToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
if (isset($_GET['edit'])) {
    $userToEdit = getUser($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários - Sistema e-Commerce</title>

    <!-- FontAwesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Link para o Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script>
        // Função para limpar o formulário
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('telefone').value = '';
            document.getElementById('email').value = '';
            document.getElementById('senha').value = '';
            document.getElementById('id').value = '';
        }

        // Função para editar as informações diretamente na tabela
        function editUser(id) {
            // Aqui você pode colocar lógica para carregar as informações do usuário
            // Para este exemplo, vamos apenas preencher o formulário com dados fictícios
            document.getElementById('id').value = id;
            document.getElementById('nome').value = 'Nome ' + id;
            document.getElementById('telefone').value = 'Telefone ' + id;
            document.getElementById('email').value = 'email' + id + '@example.com';
            document.getElementById('senha').value = 'senha' + id;
        }
    </script>
</head>
<body style="background-color: #f8f9fa;">

    <!-- Container principal -->
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Cadastro de Usuários</h2>

        <!-- Formulário de Cadastro/Atualização de Usuário -->
        <form method="POST" action="" class="bg-white p-4 rounded shadow-sm">
            <input type="hidden" id="id" name="id" value="<?php echo $userToEdit['id'] ?? ''; ?>">

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $userToEdit['nome'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" class="form-control" value="<?php echo $userToEdit['telefone'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $userToEdit['email'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>

            <!-- Botões de ação -->
            <div class="form-group text-center">
                <button type="submit" name="save" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Salvar</button>
                <button type="submit" name="update" class="btn btn-warning btn-lg"><i class="fas fa-pen"></i> Atualizar</button>
                <button type="button" onclick="clearForm()" class="btn btn-secondary btn-lg"><i class="fas fa-plus-circle"></i> Novo</button>
            </div>
        </form>

        <!-- Tabela de Usuários -->
        <h2 class="text-center text-primary mt-5 mb-4">Usuários Cadastrados</h2>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Preenche a tabela com os usuários -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td contenteditable="true" onblur="saveEdit(<?php echo $user['id']; ?>, 'nome', this.innerText)"><?php echo $user['nome']; ?></td>
                        <td contenteditable="true" onblur="saveEdit(<?php echo $user['id']; ?>, 'telefone', this.innerText)"><?php echo $user['telefone']; ?></td>
                        <td contenteditable="true" onblur="saveEdit(<?php echo $user['id']; ?>, 'email', this.innerText)"><?php echo $user['email']; ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editUser(<?php echo $user['id']; ?>)"><i class="fas fa-edit"></i> Editar</button>
                            <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Função para salvar edição in-line
        function saveEdit(id, field, value) {
            // Aqui você pode usar AJAX ou fazer uma requisição para salvar as mudanças
            alert('Salvando ' + field + ' para o usuário ' + id + ': ' + value);
        }
    </script>

</body>
</html>
