<?php
    $id_ruta = $_POST['id_ruta'];

    $conecta = new mysqli("localhost", "Alberto", "", "proyectosis1");

    $sql = 'SELECT * FROM `estacion` WHERE id_ruta='.'"'. $id_ruta .'"'.'';

    if($respuesta = mysqli_query($conecta, $sql)){
        /*$data = "";
        while($fila = mysqli_fetch_assoc($respuesta)){
            $data .= ;
        }
        while($fila = mysqli_fetch_assoc($respuesta)){
            echo json_encode($fila);
        }*/
        //echo json_encode();
        //echo $data;
        echo json_encode(mysqli_fetch_all($respuesta));
    }
?>