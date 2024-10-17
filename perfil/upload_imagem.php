<?php
// upload_imagem.php

// Diretório de uploads
$uploadDir = '../uploads/';

// Verifica se o diretório de uploads existe; se não, cria o diretório
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Falha ao criar o diretório de uploads.");
    }
}

// Caminho completo para o arquivo de upload
$uploadFile = $uploadDir . basename($_FILES['imagem']['name']);

// Move o arquivo para o diretório de upload
if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
    echo "Upload realizado com sucesso!";
} else {
    echo "Erro ao fazer upload da imagem.";
}
?>
