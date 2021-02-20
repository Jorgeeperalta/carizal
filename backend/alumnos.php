<?php
include "config.php";
include "utils.php";

// Allow from any origin
if (isset($_SERVER["HTTP_ORIGIN"])) {
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
} else {
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}





$dbConn =  connect($db);

/*  //
  listar todos los  alumnos solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['categoria'])) {
        //Mostrar un post
        $sql = $dbConn->prepare("SELECT * FROM articulos where categoria=:categoria");
        $sql->bindValue(':categoria', $_GET['categoria']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        exit();
    } else {
        //Mostrar lista de post
        $sql = $dbConn->prepare("SELECT * FROM alumnos");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        exit();
    }
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST;
    $sql = "INSERT INTO alumnos
          (dni,apellido,nombre,sexo,domicilio)
          VALUES
          (:dni, :apellido, :nombre, :sexo, :domicilio)";


    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if ($postId) {
        $input['dni'] = $postId;
        header("HTTP/1.1 200 OK");
        echo json_encode($input);
        exit();
    }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['dni'];
    $statement = $dbConn->prepare("DELETE FROM alumnos where dni=:dni");
    $statement->bindValue(':dni', $dni);
    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = $_GET;
    $postId = $input['dni'];
    $fields = getParams($input);

    $sql = "
          UPDATE alumnos
          SET $fields
          WHERE dni='$postId'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
