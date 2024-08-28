<?php
require_once('cad.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <img src="../img/synergy2.png" alt="Synergy Logo" class="img-fluid" style="width: 150px;" draggable="false">
                    <h2>Crie Sua Conta</h2>
                    <p>Junte-se à nossa comunidade!</p>
                </div>
                <div class="login-box">
                    <!-- Exibe a mensagem de erro, se existir, e remove após exibição -->
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php
                                echo $_SESSION['error_message'];
                                unset($_SESSION['error_message']); // Limpa a mensagem de erro após exibir
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmacao_senha" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control" id="confirmacao_senha" name="confirmacao_senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                    <div class="separator">
                        <span>OU</span>
                    </div>
                    <div class="text-center">
                        <a href="index.php">Já tem uma conta? Faça login</a><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
