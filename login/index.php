<?php
require_once('login.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Synergy - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container login-container" >
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <img src="../img/synergy2.png" alt="Synergy Logo" class="img-fluid" style="width: 150px;" draggable="false">
                    <h2>Bem-vindo de Volta!</h2>
                    <p>Inscreva-se hoje</p>
                </div>
                <div class="login-box">
                    <?php if (isset($_SESSION['error_message'])) {
                        echo '<div class="alert alert-danger text-center" role="alert">';
                        echo $_SESSION['error_message'];
                        echo '</div>';
                        unset($_SESSION['error_message']); // Limpar a mensagem de erro após exibir
                        }
                    ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="username" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="senha" required>
                        </div>
                        <input type="submit" class="btn btn-primary w-100" value="enviar">
                    </form>
                    <div class="separator">
                    <span>OU</span>
                </div>
                    <div class="text-center">
                        <a href="forgot_password.php">Esqueceu a senha?</a><br>
                        <a href="cadastro.php">Ainda não possui uma Conta?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
