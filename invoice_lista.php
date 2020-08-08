<?php include 'header.php'; ?>
<?php include 'cn.php'; ?>

<?php
// Si el post viene vacio carga fecha de hoy por defecto 
if (!empty($_POST["fechaInicio"]) and !empty($_POST["fechaFin"])):
    $fechaInicio = $_POST["fechaInicio"];
    $fechaFin = $_POST["fechaFin"];
    $sql = "SELECT i.idInvoice as idInvoice, i.fecha AS fecha, e.nombre AS nombreEmisor, c.nombre AS nombreCliente, c.contacto as contacto,
        d.valor as valor, est.descripcion as estadoPago, i.total as total, item.descripcion AS itemDescripcion, d.descripcion as itemDetalle
        FROM invoice i
        INNER JOIN cliente c ON i.idCliente = c.idCliente
        INNER JOIN emisor e ON i.idEmisor = e.idEmisor
        INNER JOIN estado est ON i.idEstado = est.idEstado
        INNER JOIN detalle d ON d.idInvoice = i.idInvoice
        INNER JOIN item ON item.idItem = d.idItem
        WHERE fecha BETWEEN '$fechaInicio' and '$fechaFin'
        ORDER BY idInvoice DESC LIMIT 10";
else:
    $sql = "SELECT i.idInvoice as idInvoice, i.fecha AS fecha, e.nombre AS nombreEmisor, c.nombre AS nombreCliente, c.contacto as contacto,
        d.valor as valor, est.descripcion as estadoPago, i.total as total, item.descripcion AS itemDescripcion, d.descripcion as itemDetalle
        FROM invoice i
        INNER JOIN cliente c ON i.idCliente = c.idCliente
        INNER JOIN emisor e ON i.idEmisor = e.idEmisor
        INNER JOIN estado est ON i.idEstado = est.idEstado
        INNER JOIN detalle d ON d.idInvoice = i.idInvoice
        INNER JOIN item ON item.idItem = d.idItem
        ORDER BY idInvoice DESC LIMIT 10";
endif;

?>

<div class="section container">
    <h5 class="header left blue-text text-darken-2">Buscar INVOICE Filtrando por fecha</h5>
    <div class="row">
        <form method="POST" class="col s12">
            <div class="input field col s3">
                <label for="fecha">Desde:</label>
                <input type="text" class="datepickerInicio" id="fechaInicio" name="fechaInicio">
            </div>
            <div class="input field col s3">
                <label for="fecha">Hasta:</label>
                <input type="text" class="datepickerFin" id="fechaFin" name="fechaFin">
            </div>
            <div class="input field s1">
                </br>
                <button class="btn blue darken-3 waves-effect waves-light" type="submit" name="action">cargar por fecha
                    <i class="material-icons right">file_download</i>
                </button>
            </div>
        </form>

    </div>
                
    <h5 class="blue-text">Listado de Invoices
        <?php if(!empty($_POST)):
            echo '('.$fechaInicio.' y '.$fechaFin.')';
        endif;
        ?>
    </h5>
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

        //Se ejecuta el SQL que se cargará a la tabla
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
                        <!-- Boton PDF -->
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