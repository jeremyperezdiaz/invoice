<?php include 'header.php'; ?>
<?php include 'cn.php'; ?>

<div class="container section">
    <h3 class="blue-text darken-2">Listado de Invoices</h3>
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
            </tr>
        </thead>
        <?php
        $sql = "SELECT i.idInvoice as idInvoice, i.fecha AS fecha, e.nombre AS nombreEmisor, c.nombre AS nombreCliente, c.contacto_1 as contacto_1,
        d.valor as valor, est.descripcion as estadoPago, i.total as total, item.descripcion AS itemDescripcion, d.descripcion as itemDetalle
        FROM invoice i
        INNER JOIN cliente c ON i.idCliente = c.idCliente
        INNER JOIN emisor e ON i.idEmisor = e.idEmisor
        INNER JOIN estado est ON i.idEstado = est.idEstado
        INNER JOIN detalle d ON d.idInvoice = i.idInvoice
        INNER JOIN item ON item.idItem = d.idItem
        ORDER BY idInvoice DESC LIMIT 5";
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
                <td><?php echo $lista['contacto_1'] ?></td>
                <td><?php echo $lista['valor'] ?></td>
                <td><?php echo $lista['total'] ?></td>
                <td><?php echo $lista['estadoPago'] ?></td>
            </tr>
        <?php
        };
        ?>

    </table>

</div>

<?php include 'footer.php'; ?>

