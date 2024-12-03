<?php
// Inclui o arquivo com os dados do perfil
require_once('perfil_dados.php');

// Conexão com o banco de dados (supondo que você já tenha isso configurado)
require_once('../classes/Database.class.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Synergy - Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/perfil.css">
    <style>
       
    </style>
</head>

<body>
    <?php include('../menu.php'); ?>

    <?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger text-center" role="alert">
        Erro ao atualizar a imagem de perfil. Por favor, tente novamente.
    </div>
<?php endif; ?>

    <!-- Profile Header -->
    <div class="container mt-5">
        <div class="profile-header position-relative text-center">
            <!-- Ícone de edição no canto superior direito -->
            <a href="#" class="edit-icon position-absolute" style="top: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#editarImagemModal">
    <i class="fas fa-edit"></i>
</a>

            <!-- Imagem do perfil -->
            <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" class="rounded-circle"
                width="150" height="150" draggable="false">

            <!-- Informações do perfil -->
            <div class="profile-info mt-3">
                <h3><?php echo htmlspecialchars($nomeUsuario); ?></h3>
                <p>@<?php echo htmlspecialchars($nomeUsuario); ?></p>
                <p>Seguidores: <strong><?php echo htmlspecialchars($seguidores); ?></strong> | Seguindo:
                    <strong><?php echo htmlspecialchars($seguindo); ?></strong></p>

                <?php
                // Contando as publicações do usuário
                $queryContagemPublicacoes = $db->prepare("SELECT COUNT(*) AS total FROM publicacoes WHERE usuario_id = :usuario_id");
                $queryContagemPublicacoes->bindParam(':usuario_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $queryContagemPublicacoes->execute();
                $resultadoContagem = $queryContagemPublicacoes->fetch(PDO::FETCH_ASSOC);
                $totalPublicacoes = $resultadoContagem['total'];
                ?>

                <p>Publicações: <strong><?php echo htmlspecialchars($totalPublicacoes); ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Postagens do Usuário -->
    <div class="profile-details mt-4">
        <div class="d-flex justify-content-center nav-blocks mb-0">
            <div class="nav-block">
                <a href="#" class="nav-link-custom">
                    <h5>Publicações</h5>
                </a>
            </div>
            <div class="nav-block">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#publicarModal">
                    Nova Publicação
                </button>
            </div>
        </div>

        <!-- Exibindo as publicações do usuário -->
        <div class="row ">
    <?php
    // Consulta para buscar as publicações do usuário
    $queryPublicacoes = $db->prepare("SELECT * FROM publicacoes WHERE usuario_id = :usuario_id");
    $queryPublicacoes->bindParam(':usuario_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $queryPublicacoes->execute();
    $publicacoes = $queryPublicacoes->fetchAll(PDO::FETCH_ASSOC);

    if ($publicacoes) {
        foreach ($publicacoes as $publicacao) {
            echo '<div class="col-6 col-md-4 mb-4">'; // Define o tamanho das colunas para serem responsivas
            echo '<div class="post">'; 
            echo '<img src="../uploads/' . htmlspecialchars($publicacao['imagem']) . '" alt="Publicação">';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Você ainda não fez nenhuma publicação.</p>';
    }
    ?>
</div>
    </div>

    <!-- Modal do Formulário -->
    <div class="modal fade" id="editarImagemModal" tabindex="-1" aria-labelledby="editarImagemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarImagemModalLabel">Editar Imagem de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div>
                    <input type="file" id="novaImagemPerfil" accept="image/*" class="form-control mb-3">
                </div>
                <div>
                    <img id="imagemPreview" style="max-width: 100%; display: none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="salvarImagemCortada" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<script>
    let cropper;

    document.getElementById('novaImagemPerfil').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const img = document.getElementById('imagemPreview');
                    img.src = event.target.result;
                    img.style.display = 'block';
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(img, {
                        aspectRatio: 1,
                        viewMode: 2,
                        autoCropArea: 1,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

   document.getElementById('salvarImagemCortada').addEventListener('click', function () {
            if (!cropper) {
                alert('Nenhuma imagem foi selecionada.');
                return;
            }

            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
            });

            canvas.toBlob(function (blob) {
                const formData = new FormData();
                formData.append('imagem', blob);

                fetch('atualizar_imagem_perfil.php', {
                    method: 'POST',
                    body: formData,
                    headers: { 'Accept': 'application/json' }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.sucesso) {
                            alert('Imagem de perfil atualizada com sucesso!');
                            window.location.reload();
                        } else {
                            alert(`Erro ao atualizar imagem: ${data.erro}`);
                        }
                    })
                    .catch(error => {
                        alert('Erro ao enviar a imagem. Verifique sua conexão e tente novamente.');
                        console.error('Detalhes do erro:', error);
                    });
            });
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
    <div class="alert alert-success text-center" role="alert">
        Imagem de perfil atualizada com sucesso!
    </div>
<?php endif; ?>


    <script>
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(file.type)) {
                    alert('Por favor, envie apenas imagens nos formatos JPG, PNG ou GIF.');
                    this.value = ''; // Limpa o campo
                }
            }
        });
    });
</script>

</body>

</html>