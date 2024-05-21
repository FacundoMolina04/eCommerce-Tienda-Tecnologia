<?php
include_once 'config.php';

class AdminService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function modificarProducto($producto_id, $nombre,$imagen, $precio, $descripcion, $categoria, $stock) {
        $query = "UPDATE Productos SET nombre = ?, precio = ?, descripcion = ?, categoria = ?,imagen = ? ,stock = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        
        mysqli_stmt_bind_param($stmt, "sssssis", $nombre, $precio, $descripcion, $categoria,$imagen ,$stock ,$producto_id);
    
        if(mysqli_stmt_execute($stmt)) {
            return true;
        }
        return false;
    }

    public function addProducto($id, $nombre, $precio, $stock, $descripcion, $imagen, $categoria, $admin_ci) {
        $query = "INSERT INTO Productos (id, nombre, precio, stock, descripcion, imagen, admin_ci) 
                  VALUES ('$id', '$nombre', '$precio', '$stock', '$descripcion', '$imagen', '$admin_ci')";
        mysqli_query($this->conn, $query);
        if(mysqli_affected_rows($this->conn) > 0) {
           switch ($categoria) {
            case 'componente':
                $query = "INSERT INTO Componentes (id,categoria) 
                          VALUES ('$id', 'COMPONENTES')";
                break;
            case 'periferico':
                $query = "INSERT INTO Componentes (id,categoria) 
                VALUES ('$id', 'PERIFERICOS')";
                break;
            
            case 'notebook':
                $query = "INSERT INTO Componentes (id,categoria) 
                VALUES ('$id', 'NOTEBOOKS')";

            case 'pc_armado':
                $query = "INSERT INTO PCArmados (id) 
                VALUES ('$id')";
            break;
            
            default:
                mysqli_query($this->conn, "DELETE FROM Productos WHERE id = '$id'");
                return false;
                
           }
            mysqli_query($this->conn, $query);
            return true;

        }else return false;
    }


    public function eliminarProducto($producto_id) {

        $query = "DELETE FROM Componentes WHERE id = '$producto_id'";
        mysqli_query($this->conn, $query);

        $query = "DELETE FROM PCArmados WHERE id = '$producto_id'";
        mysqli_query($this->conn, $query);
        
        $query = "DELETE FROM Productos WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
    
        mysqli_stmt_bind_param($stmt, "s", $producto_id);
    
        if(mysqli_stmt_execute($stmt)) {
            return true;
        }
        return false;
    }
    public function asignarComponentePC($idPC,$idComponente){

        $query = "INSERT INTO Componentes_PCArmado (idPC,idComponente) 
                  VALUES ('$idPC', '$idComponente')";
        mysqli_query($this->conn, $query);
        if(mysqli_affected_rows($this->conn) > 0) {
            return true;
        }else return false;
    }
}
?>
