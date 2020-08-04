<?php include 'cn.php';

//Invoice has Item
$item = $_POST["item"];
$descripcion = $_POST["descripcionItem"];
$valor = $_POST["valorItem"];

?>

<script>
    function agregarFila(){
    var table = document.getElementById("tablaItems");
    var row = table.insertRow(0);

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell2 = row.insertCell(2);

    // Add some text to the new cells:
    cell1.innerHTML = "NEW CELL1";
    cell2.innerHTML = "NEW CELL2";
    cell2.innerHTML = "NEW CELL3";
}
</script>