<?php
class Perfil {
    private $usuario_id;
    private $foto_perfil;
    private $seguidores;
    private $seguindo;
    private $publicacoes;

    public function __construct($usuario_id) {
        $this->usuario_id = $usuario_id;
        $this->foto_perfil = 'default.jpg';
        $this->seguidores = 0;
        $this->seguindo = 0;
        $this->publicacoes = 0;
    }

    public function incluir() {
        try {
            $conexao = Database::getInstance();
            $sql = 'INSERT INTO perfis (usuario_id, foto_perfil, seguidores, seguindo, publicacoes) 
                    VALUES (:usuario_id, :foto_perfil, :seguidores, :seguindo, :publicacoes)';
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
            $comando->bindValue(':foto_perfil', $this->foto_perfil, PDO::PARAM_STR);
            $comando->bindValue(':seguidores', $this->seguidores, PDO::PARAM_INT);
            $comando->bindValue(':seguindo', $this->seguindo, PDO::PARAM_INT);
            $comando->bindValue(':publicacoes', $this->publicacoes, PDO::PARAM_INT);
            $comando->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception("Erro ao incluir perfil!");
        }
    }
}
?>
