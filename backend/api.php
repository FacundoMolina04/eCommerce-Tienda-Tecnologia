<?php
include_once 'UsuarioService.php';
include_once 'ProductosService.php';
include_once 'AdminService.php';

setHeaders();

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
    case 'POST':
        handlePostRequest($request);
        break;
    case 'GET':
        handleGetRequest($request);
        break;
    case 'PUT':
        handlePutRequest($request);
        break;
    case 'DELETE':
        handleDeleteRequest($request);
        break;
}

function setHeaders()
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

function handlePostRequest($request)
{
    $data = json_decode(file_get_contents("php://input"));
    switch ($request[0]) {
        case 'usuario':
            $usuarioService = new UsuarioService();
            handleUsuarioRequest($usuarioService, $request[1], $data);
            break;
        case 'productos':
            $productosService = new ProductosService();
            handleProductosRequest($productosService, $request[1], $data);
            break;
        case 'admin':
            $adminService = new AdminService();
            handleAdminRequest($adminService, $request[1], $data);
            break;
    }
}

function handleGetRequest($request)
{
    if ($request[0] == 'productos') {
        $productosService = new ProductosService();
        switch ($request[1]) {
            case 'componentes':
                echo json_encode($productosService->getComponents());

                break;
            
            default:
                $productos = $productosService->listarProductos();
                echo json_encode($productos);
                break;
        }
        
        
    }
    
  /*   $productosService = new ProductosService();
    $productos = $productosService->listarProductos();
    echo json_encode($productos); */

}

function handlePutRequest($request)
{
    $data = json_decode(file_get_contents("php://input"));
    if ($request[0] == 'admin' && $request[1] == 'modificarProducto') {
        $adminService = new AdminService();
        echo json_encode($adminService->modificarProducto($data->producto->id, $data->producto->nombre,$data->imagen ,$data->producto->precio, $data->producto->descripcion, $data->producto->categoria,$data->stock));
    }
}

function handleDeleteRequest($request)
{
    $data = json_decode(file_get_contents("php://input"));
    if ($request[0] == 'admin' && $request[1] == 'eliminarProducto') {
        $adminService = new AdminService();
        echo json_encode($adminService->eliminarProducto($data->producto_id));
    }
}

function handleUsuarioRequest($usuarioService, $action, $data)
{
    switch ($action) {
        case 'añadirAlCarrito':
            echo json_encode($usuarioService->añadirAlCarrito($data->producto_id, $data->cantidad, $data->ci));
            break;
        case 'login':
            echo json_encode($usuarioService->login($data->correo, $data->password));
            break;
        case 'registro':
            echo json_encode($usuarioService->registro($data->ci, $data->nombre, $data->username, $data->apellido, $data->fechanac, $data->correo, $data->imagen, $data->password));
            break;
        case 'finalizarCompra':
            echo json_encode($usuarioService->finalizarCompra($data->ci, $data->direccion, $data->depto));
            break;
        case 'eliminarDelCarrito':
            echo json_encode($usuarioService->eliminarDelCarrito($data->producto_id, $data->cantidad, $data->ci));
            break;
    }
}

function handleProductosRequest($productosService, $action, $data)
{
    switch ($action) {
        case 'buscarProducto':
            echo json_encode($productosService->buscarProducto($data->texto, $data->filtro));
            break;
        case 'infoProducto':
            echo json_encode($productosService->getProductById($data->id));
            break;

    }
}

function handleAdminRequest($adminService, $action, $data)
{
    switch ($action) {
        case 'modificarProducto':
            echo json_encode($adminService->modificarProducto($data->producto->id, $data->producto->nombre, $data->producto->precio, $data->producto->descripcion, $data->producto->categoria));
            break;
        case 'addProducto':
            echo json_encode($adminService->addProducto($data->id, $data->nombre, $data->precio, $data->stock, $data->descripcion, $data->imagen, $data->categoria, $data->admin_ci));
            break;
        case 'eliminarProducto':
            echo json_encode($adminService->eliminarProducto($data->producto_id));
            break;
    }
}
?>