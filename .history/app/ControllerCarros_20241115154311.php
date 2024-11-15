<?php
namespace app;
use app\Database;


class ControllerCarros {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

//Aqui vai levar o métodos do api
   // Obter todos os carros
   public function getAll() {
    try {
        $query = "SELECT * FROM GuilhermeCarros";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $carros = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode($carros);
    } catch (\PDOException $e) {
        echo json_encode(['msg' => 'Erro: ' . $e->getMessage(), 'status' => '500']);
    }
}
// Obter carro por ID
public function getById($id) {
    try {
        $query = "SELECT * FROM GuilhermeCarros WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $carro = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($carro) {
            echo json_encode($carro);
        } else {
            echo json_encode(['msg' => 'Carro não encontrado', 'status' => '404']);
        }
    } catch (\PDOException $e) {
        echo json_encode(['msg' => 'Erro: ' . $e->getMessage(), 'status' => '500']);
    }
}

// Criar um novo carro
public function create() {
    try {
        $query = "INSERT INTO alfCarros (marca, detalhes, foto) VALUES (:marca, :detalhes, :foto)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':marca', $_POST['Marca']);
        $stmt->bindParam(':detalhes', $_POST['Detalhes']);
        $stmt->bindParam(':foto', $_POST['Foto']);

        //print_r($_POST);
        if ($stmt->execute()) {
            echo json_encode(['msg' => 'Carro adicionado com sucesso.', 'status' => '200', 'Marca' => $_POST['Marca']]);
        } else {
            echo json_encode(['msg' => 'Erro ao adicionar o carro.', 'status' => '500']);
        }
    } catch (\PDOException $e) {
        echo json_encode(['msg' => 'Erro: ' . $e->getMessage(), 'status' => '500']);
    }
}

}


?>
