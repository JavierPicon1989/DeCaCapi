<?php
//conexion a base de datos
class Conexion {
    private  $server;
    private  $user;
    private  $password;
    private  $database;
    private  $port;
    private  $conexion;

    function __construct(){
        $listadatos = $this->datosConexion();
        foreach($listadatos as $key => $value){
            $this->server =   $value['server'];
            $this->user =     $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port =     $value['port'];
        }
        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        if($this->conexion->connect_errno){
            echo "Algo salio mal en la conexion";
            die();
        }

    }

    private function datosConexion(){
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/". "config");
        
        return json_decode($jsondata, true);
    }
    //Conversion de datos a UTF-8
    private function convertirUTF8($array){
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);                
            }
        });
        
        return $array;
    }
    //obtencion de datos
    public function obtenerDatos($sql){
        $results = $this->conexion->query($sql);
        $resultArray = array();
        foreach($results as $key){
            $resultArray[] = $key;            
        }
        return $this->convertirUTF8($resultArray);
    }

    public function nonQuery($sql){
        $results = $this->conexion->query($sql);

        return $this->conexion->affected_rows;
    }

    //Se utiliza para insert
    public function nonQueryId($sql){
        $results = $this->conexion->query($sql);
        $filas = $this->conexion->affected_rows;

        if($filas >= 1){
            return $this->conexion->insert_id;
        }else{
            return 0;
        } 
    }

    public function addKeyAndValue( &$array, $key, $value ) {
    
        $array[$key] = $value;
    }


}




?>