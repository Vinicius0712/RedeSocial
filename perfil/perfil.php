<?php
// Inclui o arquivo com os dados do perfil
require_once('perfil_dados.php');

// Conexão com o banco de dados (supondo que você já tenha isso configurado)
require_once('../classes/Database.class.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Consulta para buscar os dados do usuário
$usuarioId = isset($_GET['user_id']) ? intval($_GET['user_id']) : $_SESSION['user_id'];
$proprioPerfil = ($usuarioId == $_SESSION['user_id']);

$seguindoUsuario = false;

// Consulta para verificar se o usuário logado segue o usuário atual
if (!$proprioPerfil) {
    $querySeguindo = $db->prepare("SELECT COUNT(*) AS total FROM seguidores WHERE seguidor_id = :seguidor_id AND seguido_id = :seguido_id");
    $querySeguindo->bindParam(':seguidor_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $querySeguindo->bindParam(':seguido_id', $usuarioId, PDO::PARAM_INT);
    $querySeguindo->execute();
    $seguindoUsuario = $querySeguindo->fetch(PDO::FETCH_ASSOC)['total'] > 0;
}

$queryPerfil = $db->prepare("
    SELECT usuarios.usuario, perfis.foto_perfil, perfis.seguidores, perfis.seguindo 
    FROM usuarios 
    JOIN perfis ON usuarios.id = perfis.usuario_id 
    WHERE usuarios.id = :usuario_id
");
$queryPerfil->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
$queryPerfil->execute();
$dadosPerfil = $queryPerfil->fetch(PDO::FETCH_ASSOC);

$nomeUsuario = htmlspecialchars($dadosPerfil['usuario']);
$fotoPerfil = !empty($dadosPerfil['foto_perfil']) ? htmlspecialchars($dadosPerfil['foto_perfil']) : '../img/default.jpg';
$seguidores = htmlspecialchars($dadosPerfil['seguidores']);
$seguindo = htmlspecialchars($dadosPerfil['seguindo']);
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

    <!-- Profile Header -->
    <div class="container mt-5">

        <div class="profile-header position-relative text-center">
            <!-- Ícone de edição no canto superior direito -->
            <?php if ($proprioPerfil): ?>
                <a href="#" class="edit-icon position-absolute" style="top: 10px; right: 10px;">
                    <i class="fas fa-edit"></i>
                </a>

                <a href="#" class="edit-icon position-absolute" style="top: 10px; right: 10px;" data-bs-toggle="modal"
                    data-bs-target="#editarImagemModal">
                    <i class="fas fa-edit"></i>
                </a>
            <?php endif; ?>

            <!-- Imagem do perfil -->
            
            <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" class="rounded-circle"
    width="150" height="150" draggable="false">

            <!-- Informações do perfil -->
            <div class="profile-info mt-3">
                <h3><?php echo htmlspecialchars($nomeUsuario); ?></h3>
                <p>@<?php echo htmlspecialchars($nomeUsuario); ?></p>
                <p>Seguidores: <strong><?php echo htmlspecialchars($seguidores); ?></strong> | Seguindo:
                    <strong><?php echo htmlspecialchars($seguindo); ?></strong>
                </p>

                <?php
                // Verifica se há um parâmetro 'user_id' na URL
                $usuarioId = isset($_GET['user_id']) ? intval($_GET['user_id']) : $_SESSION['user_id'];
                $proprioPerfil = ($usuarioId == $_SESSION['user_id']);

                // Consulta para buscar os dados do usuário
                $queryPerfil = $db->prepare("SELECT usuarios.usuario, perfis.foto_perfil, perfis.seguidores, perfis.seguindo 
                             FROM usuarios 
                             JOIN perfis ON usuarios.id = perfis.usuario_id 
                             WHERE usuarios.id = :usuario_id");
                $queryPerfil->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
                $queryPerfil->execute();
                $dadosPerfil = $queryPerfil->fetch(PDO::FETCH_ASSOC);

                $nomeUsuario = htmlspecialchars($dadosPerfil['usuario']);
                $fotoPerfil = !empty($dadosPerfil['foto_perfil']) ? htmlspecialchars($dadosPerfil['foto_perfil']) : '../img/default.jpg';
                $seguidores = htmlspecialchars($dadosPerfil['seguidores']);
                $seguindo = htmlspecialchars($dadosPerfil['seguindo']);

                // Contando as publicações
                $queryContagemPublicacoes = $db->prepare("SELECT COUNT(*) AS total FROM publicacoes WHERE usuario_id = :usuario_id");
                $queryContagemPublicacoes->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
                $queryContagemPublicacoes->execute();
                $totalPublicacoes = $queryContagemPublicacoes->fetch(PDO::FETCH_ASSOC)['total'];
                ?>

                <p>Publicações: <strong><?php echo htmlspecialchars($totalPublicacoes); ?></strong></p>
            </div>
    <?php if (!$proprioPerfil): ?>
        <form action="seguir_usuario.php" method="post" class="d-inline">
            <input type="hidden" name="seguido_id" value="<?php echo $usuarioId; ?>">
            <button type="submit" class="btn btn-<?php echo $seguindoUsuario ? 'danger' : 'primary'; ?>">
                <?php echo $seguindoUsuario ? 'Deixar de Seguir' : 'Seguir'; ?>
            </button>
        </form>
    <?php endif; ?>
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
            <?php if ($proprioPerfil): ?>
                <div class="nav-block">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#publicarModal">
                        Nova Publicação
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Exibindo as publicações do usuário -->
        <div class="row ">
            <?php
            // Consulta para buscar as publicações do usuário
            $queryPublicacoes = $db->prepare("SELECT * FROM publicacoes WHERE usuario_id = :usuario_id");
            $queryPublicacoes->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
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
    <div class="modal fade" id="publicarModal" tabindex="-1" aria-labelledby="publicarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="publicarModalLabel">Nova Publicação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="adicionar_publicacao.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem da Publicação</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"
                                placeholder="Escreva uma descrição..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Publicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarImagemModal" tabindex="-1" aria-labelledby="editarImagemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarImagemModalLabel">Editar Imagem de Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="atualizar_imagem_perfil.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="novaImagemPerfil" class="form-label">Selecione uma nova imagem</label>
                            <input type="file" class="form-control" id="novaImagemPerfil" name="novaImagemPerfil"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
        <div class="alert alert-success text-center" role="alert">
            Imagem de perfil atualizada com sucesso!
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            Erro ao atualizar a imagem de perfil. Por favor, tente novamente.
        </div>
    <?php endif; ?>

    <script>
    document.getElementById('novaImagemPerfil').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const validExtensions = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validExtensions.includes(file.type)) {
                alert('Por favor, envie uma imagem válida (JPEG, PNG ou GIF).');
                e.target.value = '';
            } else if (file.size > 2 * 1024 * 1024) {
                alert('O tamanho da imagem não pode exceder 2MB.');
                e.target.value = '';
            }
        }
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>