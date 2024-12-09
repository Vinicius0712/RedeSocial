<?php
require_once('../classes/Database.class.php');

class Produto {
    private $nome;
    private $descricao;
    private $preco;
    private $categoria;
    private $localizacao;
    private $usuarioId;
    private $imagem;

    // Construtor para inicializar os atributos
    public function __construct($nome, $descricao, $preco, $categoria, $localizacao, $usuarioId, $imagem = 'default.jpg') {
        $this->setNome($nome);
        $this->setDescricao($descricao);
        $this->setPreco($preco);
        $this->setCategoria($categoria);
        $this->setLocalizacao($localizacao);
        $this->setUsuarioId($usuarioId);
        $this->setImagem($imagem);
    }

    // Setters com validação
    public function setNome($nome) {
        if (empty($nome)) {
            throw new Exception("Erro: Nome do produto é obrigatório!");
        }
        $this->nome = $nome;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setPreco($preco) {
        if (!is_numeric($preco) || $preco <= 0) {
            throw new Exception("Erro: Preço inválido!");
        }
        $this->preco = $preco;
    }

    public function setCategoria($categoria) {
        if (empty($categoria)) {
            throw new Exception("Erro: Categoria é obrigatória!");
        }
        $this->categoria = $categoria;
    }

    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    // Método para fazer o upload da imagem
    public function uploadImagem($file) {
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $nomeArquivo = basename($file['name']);
            $destino = '../uploads/' . $nomeArquivo;

            if (move_uploaded_file($file['tmp_name'], $destino)) {
                $this->setImagem($nomeArquivo);
            } else {
                throw new Exception("Erro ao fazer o upload da imagem!");
            }
        }
    }

    // Método para salvar o produto no banco de dados
    public function salvar() {
        try {
            $db = Database::getInstance();
            $query = $db->prepare("INSERT INTO mercadorias (usuario_id, nome, descricao, preco, categoria, localizacao, imagem) 
                                   VALUES (:usuario_id, :nome, :descricao, :preco, :categoria, :localizacao, :imagem)");
            $query->bindParam(':usuario_id', $this->usuarioId);
            $query->bindParam(':nome', $this->nome);
            $query->bindParam(':descricao', $this->descricao);
            $query->bindParam(':preco', $this->preco);
            $query->bindParam(':categoria', $this->categoria);
            $query->bindParam(':localizacao', $this->localizacao);
            $query->bindParam(':imagem', $this->imagem);

            $query->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception("Erro ao cadastrar mercadoria!");
        }
    }
}
?>
