<?php
session_start(); // Inicia a sessão



include 'produtos_controller.php';
include 'header.php';

// Pega todos os produtos para preencher a tabela
$produtos = getProdutos();

// Variável que guarda o ID do produto que será editado
$produtoToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
if (isset($_GET['edit'])) {
    $produtoToEdit = getProduto($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos - Sistema e-Commerce</title>

    <!-- FontAwesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Link para o Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // Função para limpar o formulário
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('descricao').value = '';
            document.getElementById('marca').value = '';
            document.getElementById('modelo').value = '';
            document.getElementById('valorunitario').value = '';
            document.getElementById('categoria').value = '';
            document.getElementById('url_img').value = '';
            document.getElementById('ativo').checked = true;
            document.getElementById('id').value = '';
        }

        // Função para editar as informações diretamente na tabela
        function editProduto(id) {
            // Aqui você pode colocar lógica para carregar as informações do produto
            document.getElementById('id').value = id;
            document.getElementById('nome').value = 'Nome ' + id;
            document.getElementById('descricao').value = 'Descrição ' + id;
            document.getElementById('marca').value = 'Marca ' + id;
            document.getElementById('modelo').value = 'Modelo ' + id;
            document.getElementById('valorunitario').value = '100.00';
            document.getElementById('categoria').value = 'Categoria ' + id;
            document.getElementById('ativo').checked = true;
        }

        // Função para salvar as edições feitas na tabela via AJAX
        function saveEdit(id, field, value) {
            $.ajax({
                url: 'produtos_controller.php', // Arquivo PHP que vai processar as mudanças
                type: 'POST',
                data: {
                    edit: true,
                    id: id,
                    field: field,
                    value: value
                },
                success: function(response) {
                    alert('Produto atualizado com sucesso!');
                },
                error: function() {
                    alert('Erro ao atualizar o produto.');
                }
            });
        }

        // Função para capturar as edições feitas nas células da tabela
        $(document).ready(function() {
            $('td[contenteditable="true"]').on('blur', function() {
                var id = $(this).closest('tr').find('td:first').text(); // Obtém o ID do produto
                var field = $(this).data('field'); // Obtém o nome do campo (ex: nome, marca)
                var value = $(this).text(); // Obtém o novo valor

                // Chama a função AJAX para salvar a alteração
                saveEdit(id, field, value);
            });
        });
    </script>
</head>
<body style="background-color: #f8f9fa;">

    <!-- Container principal -->
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Cadastro de Produtos</h2>

        <!-- Formulário de Cadastro/Atualização de Produto -->
        <form method="POST" action="" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
            <input type="hidden" id="id" name="id" value="<?php echo $produtoToEdit['id'] ?? ''; ?>">

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $produtoToEdit['nome'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" required><?php echo $produtoToEdit['descricao'] ?? ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value="<?php echo $produtoToEdit['marca'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo $produtoToEdit['modelo'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="valorunitario">Valor Unitário:</label>
                <input type="number" id="valorunitario" name="valorunitario" class="form-control" value="<?php echo $produtoToEdit['valorunitario'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" value="<?php echo $produtoToEdit['categoria'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="url_img">Imagem do Produto:</label>
                <input type="file" id="url_img" name="url_img" class="form-control" accept="image/*" <?php echo isset($produtoToEdit['url_img']) ? '' : 'required'; ?>>
                <?php if (isset($produtoToEdit['url_img']) && $produtoToEdit['url_img']): ?>
                    <p><strong>Imagem atual:</strong></p>
                    <img src="img/<?php echo $produtoToEdit['url_img']; ?>" alt="Imagem do Produto" width="150">
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="ativo">Ativo:</label>
                <input type="checkbox" id="ativo" name="ativo" <?php echo isset($produtoToEdit['ativo']) && $produtoToEdit['ativo'] == 1 ? 'checked' : ''; ?>>
            </div>

            <!-- Botões de ação -->
            <div class="form-group text-center">
                <button type="submit" name="save" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Salvar</button>
                <button type="submit" name="update" class="btn btn-warning btn-lg"><i class="fas fa-pen"></i> Atualizar</button>
                <button type="button" onclick="clearForm()" class="btn btn-secondary btn-lg"><i class="fas fa-plus-circle"></i> Novo</button>
            </div>
        </form>

        <!-- Tabela de Produtos -->
        <h2 class="text-center text-primary mt-5 mb-4">Produtos Cadastrados</h2>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Valor Unitário</th>
                    <th>Categoria</th>
                    <th>Imagem</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Preenche a tabela com os produtos -->
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td contenteditable="true" data-field="nome"><?php echo $produto['nome']; ?></td>
                        <td contenteditable="true" data-field="marca"><?php echo $produto['marca']; ?></td>
                        <td contenteditable="true" data-field="modelo"><?php echo $produto['modelo']; ?></td>
                        <td contenteditable="true" data-field="valorunitario"><?php echo $produto['valorunitario']; ?></td>
                        <td contenteditable="true" data-field="categoria"><?php echo $produto['categoria']; ?></td>
                        <td>
                            <?php if ($produto['url_img']): ?>
                                <img src="img/<?php echo $produto['url_img']; ?>" alt="Imagem do Produto" width="100">
                            <?php else: ?>
                                <span>Sem imagem</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="checkbox" <?php echo $produto['ativo'] ? 'checked' : ''; ?> disabled>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editProduto(<?php echo $produto['id']; ?>)"><i class="fas fa-edit"></i> Editar</button>
                            <a href="?delete=<?php echo $produto['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Excluir</a>
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

</body>
</html>
