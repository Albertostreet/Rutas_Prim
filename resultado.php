<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>
<style>
        html,
        body {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #38B6FF;
        }
        #cuadro{
            background-color: white;
            height: 90%;
            width: 90%;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 25px;
        }
        #opciones{
            display: flex;
            margin-left: 15px;
        }
        #opcion{
            width: 300px;
            display: flex;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 20px;
            transition-duration: 0.4s;
        }
        #opcion:hover{
            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
        }
        img{
            height: 30px;
            width: 30px;
            margin-left: 15px;
            margin: 18px;
        }
        #mapaYLista{
            display: flex;
            margin-left: 50px;
            margin-top: 25px;
            height: 100%;
            width: 100%;
        }
        #cssMapa{
            height: 100%;
            width: 65%;
        }
        #mapa{
            height: 85%;
            width: 90%;
        }
        #lista{
            margin-left: 25px;
        }
        td{
            text-align: center;
            min-width: 100px;
            font-size: 20px;
        }
        table, p{
            margin-left: 50px;
        }
        input[type=button]{
            background-color: #4CAF50;
            border: none;
            border-radius: 25px;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(250%, 600%);
        }
        input[type=submit]{
            background-color: #4CAF50;
            border: none;
            border-radius: 25px;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            cursor: pointer;
            margin-left: 25px;
            margin-top: 25px;
        }
        p, td, select, option, input[type=text], input[type=button], input[type=submit]{
            text-decoration: none;
            font-family: sans-serif;
            font-size: 17px;
        }
        #nombre{
            top: 50%;
            left: 50%;
            transform: translate(20%, 450%);
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var verticesLinea = [
            <?php
                $estacion= $_POST['estacion'];
                $conexion = $_POST['conexion'];
                $verticesLinea = '';
                foreach ($conexion as $index => $array) {
                    $array['estacion1'] = intval($array['estacion1']);
                    $array['estacion2'] = intval($array['estacion2']);
                    $lat = $estacion[$array['estacion1']]['lat'];
                    $lng = $estacion[$array['estacion1']]['lng'];
                    $verticesLinea .= '{ "lat": '. $lat .', "lng": '. $lng .'},';
                    $lat = $estacion[$array['estacion2']]['lat'];
                    $lng = $estacion[$array['estacion2']]['lng'];
                    $verticesLinea .= '{ "lat": '. $lat .', "lng": '. $lng .'},'; 
                }
                echo $verticesLinea;
            ?>
        ];
        //console.log(verticesLinea);
        var conexion = [
            <?php
                $estacion= $_POST['estacion'];
                $conexion = $_POST['conexion'];
                $conexiones = '';
                foreach ($conexion as $index => $array) {
                    $estacion1 = $estacion[$array['estacion1']]['nombre'];
                    $estacion2 = $estacion[$array['estacion2']]['nombre'];
                    $conexiones .= '{ "estacion1": "'. $estacion1 .'", "estacion2": "'. $estacion2 .'"},';
                }
                echo $conexiones;
            ?>
        ];
        //console.log(conexion);
        let miMapa;
        function inicio() {
            var miMapa = new google.maps.Map(document.getElementById('mapa'), {
            center: { lat: 20.674086759381435, lng: -103.34698444440731 },
            zoom: 14
            });
            var aux = [];
            var i = 0;
            while (i < verticesLinea.length){
                aux[0] = verticesLinea[i];
                i++;
                aux[1] = verticesLinea[i];
                i++;
                
                var linea = new google.maps.Polyline({
                    path: aux,
                    map: miMapa,
                    strokeColor: 'rgb(255, 0, 0)',
                    strokeWeight: 2
                });/**/
                //console.log(aux);
            }
            var LatLon = document.querySelector("#data");
            for (let i = 0; i < conexion.length; i++) {
                LatLon.innerHTML += "<tr id="+ '"' + i + '"' +"><td>" + conexion[i]['estacion1'] + "</td><td>" + conexion[i]['estacion2'] + "</td></tr>";
            };/**/
        }
        function enviar(){
            if (document.getElementById('nombreRuta').value == ''){
                alert('Ingresa un nombre para la ruta!');
            }else{
                var nombreRuta = document.getElementById('nombreRuta').value;
                var estacionesAux = [
                    <?php
                        $estacion= $_POST['estacion'];
                        $estaciones = '';
                        foreach ($estacion as $index => $array) {
                            //$indice = $index;
                            //$datosArray = $array;
                            $estaciones .= '{ "lat": '. $array['lat'] .', "lng": '. $array['lng'] .', "nombre": "'. $array['nombre'] .'" },';
                            //$verticesLinea .= '{ "lat": '. $lat .', "lng": '. $lng .'},';
                        }
                        echo $estaciones;
                    ?>
                ];
                //console.log(estacionesAux);
                var data = {
                    "nombreRuta": nombreRuta,
                    "estaciones": estacionesAux
                };
                $.post('guardarRuta.php', data, function(data){
                    alert('Ruta guardada');
                });
            }
            
        }
        function nuevaRuta(){
            window.location.replace("pantalla.html");
        }
    </script>
<body>
    <div id="cuadro">
        <div>
            <input type="submit" value="Nueva seleccion" onclick="nuevaRuta()">
        </div>
        <div id="mapaYLista">
            <div id="cssMapa">
                <div id="mapa"></div>
                <script async src="https://maps.googleapis.com/maps/api/js?key=yourAPIKEY&callback=inicio"></script>
            </div>
            <div id="lista">
                <p>Conexion entre las estaciones:</p>
                <table id="data">
                    <tr>
                        <td>
                            Estacion:
                        </td>
                        <td>
                            Estacion:
                        </td>
                    </tr>
                </table>
                <div id="nombre">
                    <p>Nombre de la ruta</p>
                    <input type="text" placeholder="Nombre de la ruta" id="nombreRuta">
                </div>
                <input type="button" value="Guardar Ruta" onclick="enviar()">
            </div>
        </div>
    </div>
</body>
</html>