<?php include 'cn.php';

//recuperar el ID de invoice recien ingresado
$recuperaIdInvoice = "SELECT idInvoice FROM invoice ORDER BY idInvoice DESC LIMIT 1";
$resultado = mysqli_query($conexion, $recuperaIdInvoice);
$fila = mysqli_fetch_row($resultado);
$idInvoice = $fila[0];

$filas = json_decode($_POST['valores'], true);

$stmt = $conexion->prepare("INSERT INTO test_invoice2(
        idInvoice,
        item,
        descripcion,
        valor
    ) VALUES (
        $idInvoice,
        ?,
        ?,
        ?
    )");

$stmt->bind_param('sss', $item, $descripcion, $valor);

$inserciones = 0;
foreach ($filas as $fila) {
    $item      = $fila['item'];
    $descripcion   = $fila['descripcion'];
    $valor = $fila['valor'];
    $result = $stmt->execute();
    if ($result) {
        $inserciones++;
    }
}

echo "Se insertaron $inserciones registros";
