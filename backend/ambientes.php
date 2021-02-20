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
  listar todos los productos o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['categoria'])) {
        //Mostrar un post
        $sql = $dbConn->prepare("SELECT * FROM ambientes where categoria=:categoria");
        $sql->bindValue(':categoria', $_GET['categoria']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        exit();
    } else {
        //Mostrar lista de post
        $sql = $dbConn->prepare("SELECT * FROM `cantidad_ganado` INNER JOIN ambientes on pk_ambiente=fk_ambiente");
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

    $sql = "INSERT INTO ambientes
          (pk_ambiente, nombre, fecha_creacion, fecha_actualizacion, fk_establecimiento, 
          fk_tipo_ambiente,
     superficie, cant_pasto, coordenadas, estado)
          VALUES
          (:pk_ambiente, :nombre, :fecha_creacion, :fecha_actualizacion, :fk_establecimiento, 
          :fk_tipo_ambiente,
     :superficie, :cant_pasto, :coordenadas, :estado)";


    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if ($postId != null) {
        $input['id'] = $postId;
        header("HTTP/1.1 200 OK");
        echo json_encode($input);
        exit();
    }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'];
    $statement = $dbConn->prepare("DELETE FROM ambientes where id=:id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = $_GET;
    $postId = $input['id'];
    $fields = getParams($input);

    $sql = "
          UPDATE ambientes
          SET $fields
          WHERE id='$postId'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
