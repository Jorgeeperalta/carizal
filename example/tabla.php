<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="jquery/jquery-ui.css" rel="stylesheet">
    <script src="jquery/external/jquery/jquery.js"></script>
    <script src="jquery/jquery-ui.js"></script>
    <!-- <link rel="stylesheet" href="final.css"> -->
    <title>PAGINA 2</title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<body>
    <h1>Editar</h1>
    <div class="col-sm-8" id=cargar_tabla align="center"></div>
    <br>
    <button class="btn btn-primary btn-lg " id="btnInsertar">INSERTAR</button>
</body>

<script type="text/javascript">
    $(document).ready(function() {
        $('#cargar_tabla').load("servidor.php", {

            accion: 'mostrar'
        });

        $("#btnInsertar").click(function() {
            var matriz = [];

            $('.txt_nota1').each(function() {
                var array = {};
                array["alumno"] = $(this).data('pk');
                array["nota1"] = $(this).val();


                // alert(array["alumno"] + "  " + array["nota1"] );

                matriz.push(array);
            });

            $.post('servidor.php', {
                accion: 'actualizar',
                matriz: matriz,

            });

            alert('SE ACTUALIZO CON EXITO');

        });

        $(document).on("click", ".baja", function() {



            alert("Se elimino con exito");

            id = $(this).data('pk');

            if (id != "") {
                $.post("servidor.php", {
                    id: id,
                    accion: 'eliminar'
                }, function(data) {
                    data = JSON.parse(data);
                    console.log(data);

                });
                $('#cargar_tabla').load("servidor.php", {
                    accion: 'mostrar'
                });
            }


        });


    });
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</html>