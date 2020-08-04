<?php include 'cn.php';

//Variables que reciben los datos del formulario

//Invoice
$fecha = $_POST["fecha"];
//$fecha = '2020-01-01';
$total = 0;
$idEmisor = $_POST["emisor"];
//$idEmisor = 1;
$idEstado = 1; // 1 es pendiente de pago
$idCliente = $_POST["cliente"];
//$idCliente = 1;

//crear el insert
//primero el invoice
$insertarInvoice = "INSERT INTO invoice(`idInvoice`, `fecha`, `total`, `idEmisor`, `idEstado`, `idCliente`)
                        VALUES (default, '$fecha', '$total', '$idEmisor', '$idEstado', '$idCliente')";

//ejecutar la consulta de insertar invoice
$resultadoInvoice = mysqli_query($conexion, $insertarInvoice);

