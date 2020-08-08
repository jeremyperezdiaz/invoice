<?php include 'header.php'; ?>
<?php include 'cn.php'; ?>

<div class="section container">
    <h5 class="header left blue-text text-darken-2">Buscar INVOICE</h5>
    <div class="row">
        <form action="invoice_base_PDF.php" method="POST" class="col s12">
            <div class="input field col s3">
                <label>Seleccionar el INVOICE</label>
                <select name="invoice" id="invoice">
                    <!-- <option value="" disabled selected>Lista de Emisores</option> -->
                    <?php
                    $sql = "SELECT idInvoice,fecha, c.nombre as nombre FROM invoice i
                                INNER JOIN cliente c ON i.idCliente = c.idCliente
                                ORDER BY idInvoice DESC LIMIT 10";
                    $resultado = mysqli_query($conexion, $sql);

                    while ($lista = mysqli_fetch_array($resultado)) {
                    ?>
                        <option value="<?php echo $lista['idInvoice'] ?>"><?php echo 'Nº ' . $lista['idInvoice'] . ' - ' . $lista['nombre'] ?></option>
                    <?php
                    };
                    ?>
                </select>
            </div>
            <div class="input field s1">
                </br>
                <button class="btn red darken-3 waves-effect waves-light" type="submit" name="action">Descargar
                    <i class="material-icons right">picture_as_pdf</i>
                </button>
            </div>
        </form>
    </div>

    <h5 class="blue-text darken-2">Listado de Invoices</h5>
    <table class="highlight centered" class="responsive-table" id="tablaInvoices">
        <thead>
            <tr>
                <th>ID Invoice</th>
                <th>Fecha</th>
                <th>Item</th>
                <th>Descripción</th>
                <th>Emisor</th>
                <th>Cliente</th>
                <th>Contacto</th>
                <th>Valor</th>
                <th>Total</th>
                <th>Estado de Pago</th>
                <th>Descargar</th>
            </tr>
        </thead>
        <?php
        $sql = "SELECT i.idInvoice as idInvoice, i.fecha AS fecha, e.nombre AS nombreEmisor, c.nombre AS nombreCliente, c.contacto as contacto,
        d.valor as valor, est.descripcion as estadoPago, i.total as total, item.descripcion AS itemDescripcion, d.descripcion as itemDetalle
        FROM invoice i
        INNER JOIN cliente c ON i.idCliente = c.idCliente
        INNER JOIN emisor e ON i.idEmisor = e.idEmisor
        INNER JOIN estado est ON i.idEstado = est.idEstado
        INNER JOIN detalle d ON d.idInvoice = i.idInvoice
        INNER JOIN item ON item.idItem = d.idItem
        /*WHERE fecha BETWEEN fechaInicio and fechaTermino*/
        ORDER BY idInvoice DESC LIMIT 10";
        $resultado = mysqli_query($conexion, $sql);

        while ($lista = mysqli_fetch_array($resultado)) {
        ?>
            <tr>
                <td><?php echo $lista['idInvoice'] ?></td>
                <td><?php echo $lista['fecha'] ?></td>
                <td><?php echo $lista['itemDescripcion'] ?></td>
                <td><?php echo $lista['itemDetalle'] ?></td>
                <td><?php echo $lista['nombreEmisor'] ?></td>
                <td><?php echo $lista['nombreCliente'] ?></td>
                <td><?php echo $lista['contacto'] ?></td>
                <td><?php echo $lista['valor'] ?></td>
                <td><?php echo $lista['total'] ?></td>
                <td><?php echo $lista['estadoPago'] ?></td>
                <td>
                    <form action="invoice_base_PDF.php" method="POST">
                        <!-- Boton hace PDF -->
                        <button name="invoice" id="invoice" value="<?php echo $lista['idInvoice'] ?>" class="btn-floating red darken-2 waves-effect waves-light
                            tooltipped" data-position="right" data-tooltip="Crear PDF Invoice N° <?php echo $lista['idInvoice'] ?>" type="submit"><i class="material-icons right">picture_as_pdf</i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php
        };
        ?>

    </table>
    <div>
        </br>
    </div>

</div>

<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {
        $('select').formSelect();
    });
</script>

<script>
    $(document).ready(function() {
        $('.fixed-action-btn').floatingActionButton();
    });
</script>

<script>
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth();
    var day = date.getDate();
    var date = new Date(year, month, day);
    var dateIni = new Date(year, (month - 1), day);

    $('.datepickerInicio').datepicker({
        autoClose: true,
        format: 'yyyy-mm-dd',
        defaultDate: dateIni,
        setDefaultDate: true
    });

    $('.datepickerFin').datepicker({
        autoClose: true,
        format: 'yyyy-mm-dd',
        defaultDate: date,
        setDefaultDate: true
    });
</script>

<script>
    $(document).ready(function() {
        $('.tooltipped').tooltip();
    });
</script>