<?php
    $nombre = $_POST['nombreRuta'];
    $data = $_POST['estaciones'];
    
    $conecta = new mysqli("localhost", "Alberto", "", "proyectosis1");

    $sql = 'INSERT INTO `ruta`(`nombre_ruta`) VALUES ("'. $nombre .'")';

        if($respuesta = mysqli_query($conecta, $sql)){
            $sql = 'SELECT `id_ruta` FROM `ruta` WHERE `nombre_ruta`="'. $nombre .'"';
            if($respuesta = mysqli_query($conecta, $sql)){
                $fila = mysqli_fetch_assoc($respuesta);
                $id_ruta = $fila['id_ruta'];
                $nombre = "";
                $lat = 0.0;
                $lng = 0.0;
                $indice = 0;
                foreach ($data as $key => $value) {
                    $indice = $key;
                    $nombre = $value['nombre'];
                    $lat = floatval($value['lat']);
                    $lng = floatval($value['lng']);
                    $sql = 'INSERT INTO `estacion`(`id_ruta`, `nombre`, `latitud`, `longitud`, `indice`) VALUES ("'. $id_ruta .'", "'. $nombre .'", '. $lat .', '. $lng .', '. $indice .')';
                    mysqli_query($conecta, $sql);
                }
            }
        }

    
?>