<?php
include_once 'clases/respuestas.class.php';
require_once 'clases/productos.class.php';

$_respuestas = new Respuestas;
$_productos = new Productos;

//implementacion metodo para obtener los valores de los registros en BD
if($_SERVER['REQUEST_METHOD'] == "GET"){    

    if(isset($_GET['id'])){

        $id_producto = $_GET['id'];
        $datosProducto = $_productos->obtenerProducto($id_producto);
        header("Content-Type: application/json");
        echo json_encode($datosProducto);
        http_response_code(200);
        
    }else{
        $listaProductos = $_productos->listaProductos();
        header("Content-Type: application/json");
        echo json_encode($listaProductos);
        http_response_code(200);

    }
//implementacion metodo para crear resgistros
}else if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //se reciben los datos enviados
        $postData= file_get_contents("php://input");
        //se envian los datos al controlador
        $datosArray = $_productos->post($postData);
        //se devuelve una respuesta
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }
        echo json_encode($datosArray);

 //implementacion metodo para actualizar registros  
}else if ($_SERVER['REQUEST_METHOD'] == "PUT") {    
    //se reciben los datos enviados
    $postData= file_get_contents("php://input");
    //se envian los datos al controlador
    $datosArray = $_productos->put($postData);

    //se devuelve una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
    
//implementacion metodo para borrar registros
}else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    
     //se reciben los datos enviados
    
    if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
    //se envian los datos al controlador
    $datosArray = $_productos->delete($id);
    }else{
        $postData= file_get_contents("php://input");  
        $datosArray = $_productos->delete($postData); 
    }
    //se devuelve una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray); 
    
}else {
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}



?>