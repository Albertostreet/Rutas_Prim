<?php

$conecta = new mysqli("localhost", "Alberto", "", "proyectosis1");

$sql = "SELECT * FROM `ruta`";

if($respuesta = mysqli_query($conecta, $sql)){
    $data = "";
    while($fila = mysqli_fetch_assoc($respuesta)){
        $data .= '<option value='.'"'. $fila['id_ruta'] .'"'.'>'. $fila['nombre_ruta'] .'</option>';
    }
    echo $data;
}
?>

