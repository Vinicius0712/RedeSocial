<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Synergy - Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <h2 class="brand-name">Synergy</h2>
            <div class="collapse navbar-collapse justify-content-center order-lg-2">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user-friends"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-store"></i></a>
                    </li>
                </ul>
            </div>
            <div class="d-flex order-lg-3">
                <a href="#" class="nav-link"><i class="fas fa-bell"></i><span class="badge bg-danger">17</span></a>
                <a href="#" class="nav-link"><img src="https://via.placeholder.com/40" alt="Profile" class="profile-icon"></a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-none d-md-block bg-white sidebar py-4" id="side">
                <a class="logo" href="#">
                    <img src="../img/synergy2.png" class="logo" alt="Synergy Logo">
                </a>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">*</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">*</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-6 content-background">
                <!-- Stories -->
                <div class="d-flex align-items-center my-4 stories">
                    <img src="https://via.placeholder.com/60" alt="Story 1">
                    <img src="https://via.placeholder.com/60" alt="Story 2">
                    <img src="https://via.placeholder.com/60" alt="Story 3">
                    <img src="https://via.placeholder.com/60" alt="Story 4">
                </div>

                <!-- Post -->
                <div class="card mb-4 post">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 profile-info">
                            <img src="https://via.placeholder.com/50" alt="Profile">
                            <div>
                                <h5 class="card-title mb-0">Nome do Usuário</h5>
                                <p class="card-text"><small class="text-muted">2 horas atrás</small></p>
                            </div>
                        </div>
                        <img src="https://via.placeholder.com/500x300" class="card-img-top" alt="Publicação">
                        <p class="card-text mt-3">Descrição da publicação aqui...</p>
                    </div>
                </div>

                <!-- Another Post -->
                <div class="card mb-4 post">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 profile-info">
                            <img src="https://via.placeholder.com/50" alt="Profile">
                            <div>
                                <h5 class="card-title mb-0">Nome do Usuário</h5>
                                <p class="card-text"><small class="text-muted">4 horas atrás</small></p>
                            </div>
                        </div>
                        <img src="https://via.placeholder.com/500x300" class="card-img-top" alt="Publicação">
                        <p class="card-text mt-3">Descrição da publicação aqui...</p>
                    </div>
                </div>
            </main>

            <!-- Suggestions -->
            <aside class="col-lg-3 d-none d-lg-block suggestions py-4">
                <h5>Seus Grupos</h5>
                <div class="d-flex align-items-center mb-3 suggestion">
                    <button><img src="https://via.placeholder.com/40" alt="Sugestão 1"> Grupo 1</button>
                </div>
                <div class="d-flex align-items-center mb-3 suggestion">
                    <button><img src="https://via.placeholder.com/40" alt="Sugestão 2"> Grupo 2</button>
                </div>
                <div class="d-flex align-items-center mb-3 suggestion">
                    <button><img src="https://via.placeholder.com/40" alt="Sugestão 3"> Grupo 3</button>
                </div>
            </aside>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Synergy. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
