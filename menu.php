<?php
// Verifica se a sessão já foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Caminho da imagem do perfil
$fotoPerfil = isset($_SESSION['foto_perfil']) ? '../img/' . $_SESSION['foto_perfil'] : '../img/default.jpg';
?>

<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid">
        <h2 class="brand-name"><a href="../rede/index.php" style="text-decoration: none; color: inherit;">Synergy</a>
        </h2>
        <div class="collapse navbar-collapse justify-content-center order-lg-2">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="../rede/index.php"><i class="fas fa-home"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-user-friends"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../market/marketplace.php"><i class="fas fa-store"></i></a>
                </li>
            </ul>
        </div>
        <div class="d-flex order-lg-3">

            <!-- <a href="#" class="nav-link"><i class="fas fa-bell"></i><span class="badge bg-danger"></span></a> -->

            <a href="../perfil/perfil.php" class="nav-link">
                <img src="<?php echo $fotoPerfil; ?>" alt="Profile" class="profile-icon" draggable="false" style="width: 50px; height: 45px; border-radius: 50%;">
            </a>

        </div>
    </div>
</nav>