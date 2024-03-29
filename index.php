<?php
// databse config information
$host = "localhost";
$user = "root";
$password = "";
$database = "api_php";

// database connection  
$databaseConnection = new mysqli($host, $user, $password, $database);

// checking if connection is ok
if($databaseConnection->connect_error){
    die("Error al conectar la base de datos ".$databaseConnection->connect_error);
}

// setting the type of the data
// here we are going to give and revice data in json format
header("Content-Type: application/json");
// get the method
$method = $_SERVER["REQUEST_METHOD"];

// knowing which method is using 
switch ($method) {
    case 'GET':
        getUsers($databaseConnection);
        break;
    case 'POST':
        addUser($databaseConnection);
        break;
    case 'PUT':
        echo "Actualizar registros";
        break;
    case 'DELETE':
        echo "Eliminar registros";
        break;
    // in case of a diferent http method
    default:
        echo "No permission";
        break;
}

// get all users
function getUsers($connection){
    $sql = "SELECT * FROM usuarios";
    $result = $connection->query($sql);
    // if query is correct and we have a connection
    if ($result) {
        // storage data
        $data = array();
        // loop of data
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // parse data to json format and printing it
        echo json_encode($data);
        
        // in case the was an error in the query
    } else {
        echo "Error al extraer la data de la base de datos ";
    }
}

// add an user
function addUser($connection){
    // parse to json format, getting the data of object insert in thunder client
    $newUser = json_decode(file_get_contents("php://input"), true);
    $name = $newUser["nombre"];
    
    // sql query
    $sql = "INSERT INTO usuarios(nombre) VALUES('$name')";
    $result = $connection->query($sql);
    
    if ($result) {
        // returns the last added id
        $newUser['id'] = $connection->insert_id;
        echo json_encode($newUser); // muestra a el usuario ingresado 

    } else{
        echo array("error"=>"Error al ingresar el usuario");
    }
    
}

?>