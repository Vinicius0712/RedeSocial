<?php
require_once('../classes/Database.class.php');

class Marketplace {
    // Atributos privados para os filtros
    private $pdo;
    private $precoMax;
    private $localizacao;
    private $categoria;

    // Construtor para inicializar os filtros
    public function __construct($precoMax = null, $localizacao = null, $categoria = null) {
        $this->setPrecoMax($precoMax);
        $this->setLocalizacao($localizacao);
        $this->setCategoria($categoria);
    }

    // Métodos setters para definir os filtros
    public function setPrecoMax($precoMax) {
        $this->precoMax = $precoMax;
    }

    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    // Método para buscar mercadorias aplicando os filtros
    public function buscarMercadorias() {
        try {
            $db = Database::getInstance();

            $sql = "SELECT mercadorias.*, usuarios.usuario AS username, perfis.foto_perfil 
                    FROM mercadorias 
                    JOIN usuarios ON mercadorias.usuario_id = usuarios.id
                    JOIN perfis ON usuarios.id = perfis.usuario_id
                    WHERE 1=1";

            // Array para armazenar parâmetros
            $params = [];

            // Filtro por preço máximo
            if (!empty($this->precoMax)) {
                $sql .= " AND mercadorias.preco <= :precoMax";
                $params[':precoMax'] = $this->precoMax;
            }

            // Filtro por localização
            if (!empty($this->localizacao)) {
                $sql .= " AND mercadorias.localizacao LIKE :localizacao";
                $params[':localizacao'] = '%' . $this->localizacao . '%';
            }

            // Filtro por categoria
            if (!empty($this->categoria)) {
                $sql .= " AND mercadorias.categoria = :categoria";
                $params[':categoria'] = $this->categoria;
            }

            $sql .= " ORDER BY mercadorias.data_cadastro DESC";

            $query = $db->prepare($sql);
            $query->execute($params);
            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception("Erro ao buscar mercadorias!");
        }
    }
    public function buscarMercadoriaPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM mercadorias WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function editarMercadoria($id, $nome, $descricao, $preco, $categoria, $localizacao) {
        $stmt = $this->pdo->prepare("UPDATE mercadorias SET nome = ?, descricao = ?, preco = ?, categoria = ?, localizacao = ? WHERE id = ?");
        $stmt->execute([$nome, $descricao, $preco, $categoria, $localizacao, $id]);
    }
    
}
?>
