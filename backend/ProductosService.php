<?php
include_once 'config.php';

class ProductosService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function listarProductos() {
        $query = "SELECT * FROM Productos";
        $resultado = mysqli_query($this->conn, $query);
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["error" => "Error en la consulta a la base de datos."]);
            exit;
        }

        $productos = [];
        while ($fila = mysqli_fetch_object($resultado)) {
            $productos[] = $fila;
        }

        return $productos;
    }
    

    public function buscarProducto($texto, $filtro) {
        $query = "SELECT * FROM Productos WHERE $filtro LIKE '%$texto%'";
        $resultado = mysqli_query($this->conn, $query);
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["error" => "Error en la consulta a la base de datos."]);
            exit;
        }
        $productos = [];
        while ($fila = mysqli_fetch_object($resultado)) {
            $productos[] = $fila;
        }

        return $productos;
    }
    public function getProductById($id){
        $query = "SELECT * FROM Productos WHERE id = '$id'";
        $resultado = mysqli_query($this->conn, $query);
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["error" => "Error en la consulta a la base de datos."]);
            exit;
        }
        return mysqli_fetch_object($resultado);
    }

    public function getComponents(){
        $query = "SELECT * FROM Componentes JOIN Productos ON Componentes.id = Productos.id";
        $resultado = mysqli_query($this->conn, $query);
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["error" => "Error en la consulta a la base de datos."]);
            exit;
        }
        $componentes = [];
        while ($fila = mysqli_fetch_object($resultado)) {
            $componentes[] = $fila;
        }

        return $componentes;
    }

    public function getPCArmados(){
        $query = "SELECT * FROM PCArmados JOIN Productos ON Componentes.id = Productos.id";
        $resultado = mysqli_query($this->conn, $query);
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["error" => "Error en la consulta a la base de datos."]);
            exit;
        }
        $componentes = [];
        while ($fila = mysqli_fetch_object($resultado)) {
            $componentes[] = $fila;
        }

        return $componentes;
    }
    public function getComponentesPCArmado($idPC){
        $query = "SELECT * FROM Productos JOIN Componentes_PCArmado ON Productos.id = Componentes_PCArmado.idComponente WHERE idPC = '$idPC'";
        $resultado = mysqli_query($this->conn, $query);
        if (!$resultado) {
            http_response_code(500);
            echo json_encode(["error" => "Error en la consulta a la base de datos."]);
            exit;
        }
        $componentes = [];
        while ($fila = mysqli_fetch_object($resultado)) {
            $componentes[] = $fila;
        }

        return $componentes;
    }
}
?>
