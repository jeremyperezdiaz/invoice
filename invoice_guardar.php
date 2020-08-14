<?php include 'header.php'; ?>
<?php include 'cn.php';

//recuperar el ID de invoice recien ingresado
$recuperaIdInvoice = "SELECT idInvoice FROM invoice ORDER BY idInvoice DESC LIMIT 1";
$resultado = mysqli_query($conexion, $recuperaIdInvoice);
$fila = mysqli_fetch_row($resultado);
$idInvoice = $fila[0];
?>

<div class="container section">
    <form action="invoice_base_PDF.php" method="POST">
        <!-- Boton hace PDF -->
        <button name="invoice" id="invoice" value="<?php echo $idInvoice ?>" class="btn-large red darken-2 waves-effect waves-light"
                target="_blank" type="submit">Generar PDF<i class="material-icons right">picture_as_pdf</i>
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>