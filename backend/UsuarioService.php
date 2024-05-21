<?php
include_once 'config.php';

class UsuarioService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function addToCart($ci, $producto_id, $cantidad) {
        // Obtener o crear el carrito
        $query = "SELECT idCarrito FROM Carrito WHERE ci = $ci";
        $result = $this->conn->query($query);

        if ($result->num_rows == 0) {
            $query = "INSERT INTO Carrito (costoCarrito, ci) VALUES (0, $ci)";
            $this->conn->query($query);
            $idCarrito = $this->conn->insert_id;
        } else {
            $row = $result->fetch_assoc();
            $idCarrito = $row['idCarrito'];
        }

        // Añadir producto al carrito
        $query = "INSERT INTO Carrito_Productos (idCarrito, idProducto, cantidad) 
                  VALUES ($idCarrito, $producto_id, $cantidad) 
                  ON DUPLICATE KEY UPDATE cantidad = cantidad + $cantidad";
        if ($this->conn->query($query)) {
            return true;
        }
        return false;
    }

    public function login($correo, $password) {
        $query = "SELECT * FROM Usuario WHERE correo = '$correo' AND password = '$password'";
        $result = $this->conn->query($query);
        if($result->num_rows > 0) {
            session_start();
            $_SESSION['user'] = $result->fetch_assoc();
            return $result->fetch_assoc();
        }
        return false;
    }
    
    public function registro($ci, $nombre, $username, $apellido, $fechanac, $correo, $imagen, $password) {
        $query = "INSERT INTO Usuario (ci, nombre, username, apellido, fechanac, correo, imagen, password) 
                  VALUES ($ci, '$nombre', '$username', '$apellido', '$fechanac', '$correo', '$imagen', '$password')";
        if($this->conn->query($query)) {
            return true;
        }
        return false;
    }

    public function finalizarCompra($ci, $direccion, $depto) {
        $query = "INSERT INTO Compra (fechaCompra, costoCarrito, depto, direccion, ci) 
                  SELECT NOW(), SUM(p.precio * cp.cantidad), '$depto', '$direccion', c.ci 
                  FROM Carrito_Productos cp 
                  JOIN Productos p ON cp.idProducto = p.id 
                  JOIN Carrito c ON cp.idCarrito = c.idCarrito 
                  WHERE c.ci = $ci";
        if($this->conn->query($query)) {
            $delete_query = "DELETE FROM Carrito_Productos WHERE idCarrito = (SELECT idCarrito FROM Carrito WHERE ci = $ci)";
            $this->conn->query($delete_query);
            return true;
        }
        return false;
    }

    public function eliminarDelCarrito($producto_id, $cantidad, $ci) {
        $query = "UPDATE Carrito_Productos SET cantidad = cantidad - $cantidad 
                  WHERE idCarrito = (SELECT idCarrito FROM Carrito WHERE ci = $ci) AND idProducto = $producto_id";
        if($this->conn->query($query)) {
            $delete_query = "DELETE FROM Carrito_Productos WHERE idCarrito = (SELECT idCarrito FROM Carrito WHERE ci = $ci) 
                             AND idProducto = $producto_id AND cantidad <= 0";
            $this->conn->query($delete_query);
            return true;
        }
        return false;
    }
    public function obtenerCarrito($ci){
        $query = "SELECT p.id, p.nombre, p.precio, cp.cantidad 
                  FROM Carrito_Productos cp 
                  JOIN Productos p ON cp.idProducto = p.id 
                  WHERE cp.idCarrito = (SELECT idCarrito FROM Carrito WHERE ci = $ci)";
        $result = mysqli_query($this->conn, $query);
        $productos = [];
        while ($fila = mysqli_fetch_object($result)) {
            $productos[] = $fila;
        }

        return $productos;

    }
}
?>