<?php
// databse config information
$host = "localhost";
$user = "root";
$password = "";
$database = "api_php";

// database connection  
$databaseConnection = new mysqli($host, $user, $password, $database);

// checking if connection is ok
if(!$databaseConnection->connect_error){
    echo "Conexión establecida exitosamente!";
} else {
    die("Error al conectar la base de datos ".$databaseConnection->connect_error);
}

?>