<?php

$accion = $_POST['accion'];


$servername = "localhost";
$database = "bd_rotacion";
$username = "root";
$password = "root";
// CREA CONECCION
$conn = mysqli_connect($servername, $username, $password, $database);




switch ($accion) {
    case 'actualizarIndice':
        $id = $_POST['id'];
        $indice = $_POST['indice'];
        if($indice < 0.3){
             $indice=0;
        }else if($indice > 0.3){
            $indice= 1;
        }
        $consulta = "UPDATE `ambientes` SET `estado`='" . $indice . "' WHERE pk_ambiente='" . $id . "' ";
        $resultado = mysqli_query($conn, $consulta);
        break;
    case 'traer_evento2':
        
        $consulta = "SELECT `pk_ambiente`,`nombre`FROM `cantidad_ganado` INNER JOIN ambientes on pk_ambiente=fk_ambiente";
        $resultado = mysqli_query($conn, $consulta);
        while ($fila = mysqli_fetch_array($resultado)) {
            echo "
                    <option value='" . $fila['pk_ambiente'] . "'>" . $fila['nombre'] . "</option>
                    
                  ";
        }

        break;

    case 'insertar':
        $dni = $_POST['cmbAlumno'];
        $id_materia = $_POST['cmbMateria'];

        $consulta = "SELECT * FROM `notas`  WHERE dni='" . $dni . "' AND id_materia='" . $id_materia . "' ";
        $resultado = mysqli_query($conn, $consulta);
        if (mysqli_num_rows($resultado) > 0) {

            $msj = 'NO SE PUEDE CARGAR';
        } else {

            $consulta = " INSERT INTO `notas`(`dni`, `id_materia`, `nota1`, `nota2`, `nota_final`) VALUES ('" . $dni . "','" . $id_materia . "','','','')";
            $resultado = mysqli_query($conn, $consulta);
            $msj = 'SE CARGO CON EXITO';
        }
        $resp = array('msg' => $msj, 'estado' => $cant);
        echo json_encode($resp);


        break;

    case 'mostrar':
        // $id = $_POST['id_materia'];

        $consulta = "SELECT * FROM `cantidad_ganado` INNER JOIN ambientes on pk_ambiente=fk_ambiente";
        $resultado = mysqli_query($conn, $consulta);
?><div class="table-responsive-xl">
            <table>
                <thead>

                    <th>Estado</th>
                    <th>Nombre</th>

                    <th>Cantidad</th>

                </thead>
                <tbody>
                    <?php
                    foreach ($resultado as $key) {
                    ?>
                        <tr>
                            <? echo "<td>".$key["estado"]." </td> " ?>
                            <? echo "<td><input type='text' name='nota1_".$key["pk_ambiente"]."' class='txt_nota1' data-pk=".$key["pk_ambiente"]." data-nombre=".$key["pk_ambiente"]." value='".$key["nombre"]."'> </td> " ?>
                            <? echo "<td><input type='text' name='nota1_".$key["pk_ambiente"]."' class='txt_nota1' data-pk=".$key["pk_ambiente"]." data-nombre2=".$key["cantidad"]." value='".$key["cantidad"]."'> </td> " ?>




                            <? echo "<td><button style='background-color: #FF0000' class='baja' data-pk=".$key["fk_ambiente"]." data-nombre=".$key["cantidad"].">BAJA</button> </td> " ?>

                        </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
<?php
        break;
    case 'eliminar':
        $dni = $_POST['id'];


        // $consulta = "SELECT * FROM `notas`  WHERE dni='" . $dni . "'  ";
        // $resultado = mysqli_query($conn, $consulta);
        // if (mysqli_num_rows($resultado) > 0) {
        //     $msj = 'NOTAS ELIMINADAS';
        // } else {
        //     $msj = 'NOTAS NO ELIMINADAS';
        // }
        // $resp = array('msg' => $msj, 'estado' => $cant);
        // echo json_encode($resp);

        $consulta = "DELETE FROM `cantidad_ganado` WHERE `fk_ambiente`='" . $dni . "'";
        $resultado = mysqli_query($conn, $consulta);

        break;

    case 'actualizar':

        $cont = 0;
        foreach ($_POST['matriz'] as $key) {
            if ($cont % 2 == 0) {
                $consulta = "UPDATE `ambientes` SET `nombre`='" . $key['nota1'] . "' WHERE pk_ambiente='" . $key['alumno'] . "' ";
                $resultado = mysqli_query($conn, $consulta);
            } else {
                $consulta = "UPDATE `cantidad_ganado` SET `cantidad`='" . $key['nota1'] . "' WHERE fk_ambiente='" . $key['alumno'] . "' ";
                $resultado = mysqli_query($conn, $consulta);
            }
            $cont++;
           
        }
}

?>