<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Productos extends conexion {

    private $precio_dolar = 300;
    private $nombre = "";
    private $precio_pesos = "";
    private $id_producto = "";
    private $dolar;

//funcion para obtener la lista de todos los datos en BD
    public function listaProductos(){

        $query = "SELECT id_producto, nombre, precio_pesos FROM productos";                

        $data = parent::obtenerDatos($query);
        //var_dump($data); 
        return ($data);
    }

//funcion para obtener datos de un producto en BD a traves de ID
    public function obtenerProducto($id){
        $query = "SELECT id_producto, nombre, precio_pesos FROM productos WHERE id_producto = '$id'";

        return parent::obtenerDatos($query);
    }

    //metodo POST
    public function post($json){
        $_respuestas = new Respuestas;
        $data = json_decode($json, true);
        if(!isset($data['nombre']) || !isset($data['precio_pesos'])){
            
            return $_respuestas->error_400();

        }else{
            $this->nombre = $data['nombre'];
            $this->precio_pesos = $data['precio_pesos'];

            $resp = $this->insertProducto();

            if($resp){

                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_producto" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

//funcion para insertar datos en BD
    public function insertProducto(){
        $query = "INSERT INTO productos (nombre, precio_pesos) 
        VALUES ('" . $this->nombre . "','" .$this->precio_pesos . "')";

        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        } else{
            return 0;
        }
    }

    //metodo PUT
    public function put($json){
        $_respuestas = new Respuestas;
        $data = json_decode($json, true);
        if(!isset($data['id_producto'])){
            
            return $_respuestas->error_400();

        }else{
            $this->id_producto = $data['id_producto'];
            $this->nombre = $data['nombre'];
            $this->precio_pesos = $data['precio_pesos'];

            $resp = $this->updateProducto();

             if($resp){

                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_producto" => $this->id_producto
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            } 
        }
    }
//funcion para actualizar datos en BD
    public function updateProducto(){
        $query = "UPDATE productos SET nombre = '" . $this->nombre . "' , precio_pesos = '" .$this->precio_pesos . "'
        WHERE id_producto = '" .$this->id_producto . "' ";

        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        } else{
            return 0;
        } 
    }
    //metodo DELETE
    public function delete($id){
        $_respuestas = new Respuestas;
        //$data = json_decode($json, true);
       
        //if(!isset($data['id_producto'])){
        if(!isset($id)){
            
            return $_respuestas->error_400();

        }else{
            $this->id_producto = $id;
            $resp = $this->deleteProducto();

             if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_producto" => $this->id_producto
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            } 
        }
    }
//funcion para borrar datos en BD
    public function deleteProducto(){
        $query = "DELETE FROM productos WHERE id_producto = '" .$this->id_producto . "' ";
        $resp = parent::nonQuery($query);

        if($resp >= 1){
            return $resp;
        } else{
            return 0;
        } 
    }   


}



?>