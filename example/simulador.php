<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="jquery/jquery-ui.css" rel="stylesheet">
    <script src="jquery/external/jquery/jquery.js"></script>
    <script src="jquery/jquery-ui.js"></script>
    <link rel="stylesheet" href="final.css">
    <title>PAGINA 2</title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<body>
    <h1>Simulador</h1>

    <br>
    <div class="col-sm-12">
        <select class="custom-select" id="cmbMateria"></select>
        <br>
        <br>

        <input class="input-group-text" type="number" id="txtIndice" placeholder="Valor de -1 a 1" aria-describedby="validationTooltipUsernamePrepend" required>

        <br><br>
        <button class="btn btn-danger" id="btnBuscar">Cambiar</button>
        <br><br>
    </div>


</body>

<script type="text/javascript">
    $(document).ready(function() {
        $("#cmbMateria").load('servidor.php', {
            accion: 'traer_evento2'
        });


        $("#btnBuscar").click(function() {


            id = $("#cmbMateria").val();
            indice = $("#txtIndice").val();

            alert('Se almaceno con exito')
            $.post("servidor.php", {
                id: id,
                indice: indice,
                accion: 'actualizarIndice'
            }, function(data) {
                data = JSON.parse(data);
                console.log(data);
                if (data) {
                    alert(data.msg);
                    console.log(data.estado);
                }
            });

        });



    });
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</html>