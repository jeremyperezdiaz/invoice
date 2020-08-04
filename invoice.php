<?php include 'header.php'; ?>
<?php include 'cn.php'; ?>

<div class="section container">
    <h4 class="header left blue-text text-darken-2">Emitir Nuevo INVOICE</h4>
    <div class="row">

        <form action="invoice.php" method="POST" class="col s12">
            <div class="row card-panel">
                <div class="input field col s4">
                    <label>Seleccionar EMISOR del INVOICE</label>
                    <select name="emisor" id="emisor">
                        <option value="" disabled selected>Lista de Emisores</option>
                        <?php
                        $sql = "SELECT idEmisor,nombre FROM emisor";
                        $resultado = mysqli_query($conexion, $sql);

                        while ($lista = mysqli_fetch_array($resultado)) {
                        ?>
                            <option value="<?php echo $lista['idEmisor'] ?>"><?php echo $lista['nombre'] ?></option>
                        <?php
                        };
                        ?>
                    </select>
                </div>

                <div class="input field col s4">
                    <label>Seleccionar Cliente (Recibe INVOICE)</label>
                    <select name="cliente" id="cliente">
                        <option value="" disabled selected>Lista de clientes</option>
                        <?php
                        $sql = "SELECT * FROM cliente";
                        $resultado = mysqli_query($conexion, $sql);

                        while ($lista = mysqli_fetch_array($resultado)) {
                        ?>
                            <option value="<?php echo $lista['idCliente'] ?>"><?php echo $lista['nombre'] ?></option>
                        <?php
                        };
                        ?>
                    </select>
                </div>

                <div class="input field col s4">
                    <label for="fecha">Fecha:</label>
                    <input type="text" class="datepicker" id="fecha" name="fecha">
                </div>

                <!-- Tabla de Detalles de los Servicios-->

                <h4 class="header left blue-text text-darken-2">Detalle de servicios</h4>

                <!-- Modal Trigger -->
                <div class="col s12 center">
                    <a class="waves-effect waves-light btn modal-trigger green" href="#modal1"><i class="material-icons right">library_add
                        </i>Agregar Item</a>
                    <a onclick="eliminarFila()" class="modal-close waves-effect waves-light btn red">
                        <i class="material-icons right">clear</i>Eliminar Item</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>Descripción del servicio</th>
                            <th>Valor en USD</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody id="tablaItems">
                        <!-- Aqui se insertan los item de servicios -->
                    </tbody>
                </table>
                <div class="center">Los cambios realizados no serán guardados hasta que se haya agregado el INVOICE</div>
            </div>

            <!-- Boton de agregar el INVOICE -->
            <button type="submit" value="Submit" id="agregarInvoice" class="btn-large blue darken-3 waves-effect waves-light center" onclick="genera_invoice(emisor.value, cliente.value, fecha.value)">Agregar Invoice
                <i class="material-icons right">send</i>
            </button>
        </form>
    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content container">
            <h4 class="blue-text darken-2">Ingrese Item de Servicio</h4>
            <div class="col s2">
                <label>Seleccionar ITEM</label>
                <select name="item" id="item" required>
                    <option value="0" disabled selected>Lista de Items</option>
                    <?php
                    $sql = "SELECT idItem, descripcion FROM item";
                    $resultado = mysqli_query($conexion, $sql);

                    while ($lista = mysqli_fetch_array($resultado)) {
                    ?>
                        <option value="<?php echo $lista['descripcion'] ?>"><?php echo $lista['descripcion'] ?></option>
                    <?php
                    };
                    ?>
                </select>
            </div>
            <div class="col s8">
                <label for="descripcionItem">Detalle del Item de Servicio</label>
                <input id="descripcionItem" name="descripcionItem" type="text" required>
            </div>
            <div class="col s2">
                <label for="valorItem">Valor en USD $</label>
                <input id="valorItem" name="valorItem" type="number" required>
            </div>
            <div class="modal-footer">
                <a onclick="agregarFila(item.value, descripcionItem.value, valorItem.value)" class="modal-close waves-effect waves-light btn-large blue darken-3">
                    <i class="material-icons right">send</i>Agregar Item</a>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script>
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth();
    var day = date.getDate();
    var date = new Date(year, month, day);

    $('.datepicker').datepicker({
        autoClose: true,
        format: 'yyyy-mm-dd',
        defaultDate: date,
        setDefaultDate: true
    });
</script>
<script>
    $(document).ready(function() {
        $('select').formSelect();
    });

    $(document).ready(function() {
        $('.modal').modal();
    });
</script>

<script>
    $(document).ready(function() {
        $('.fixed-action-btn').floatingActionButton();
    });
</script>

<script>
    function agregarFila(item, descripcion, valor) {
        var table = document.getElementById("tablaItems");
        var row = table.insertRow(-1);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        // Add some text to the new cells:
        cell1.innerHTML = item;
        cell2.innerHTML = descripcion;
        cell3.innerHTML = valor;
        cell4.innerHTML = '<input class="btn red" type="button" value="Borrar" onclick="eliminarFilaID(this)">';

    }

    function eliminarFila() {
        document.getElementById("tablaItems").deleteRow(-1);
    }

    function eliminarFilaID(r) {
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("tablaItems").deleteRow(i - 1);
    }
</script>

<!-- Script para transformar la tabla en json -->
<!-- Primero genera el INVOICE -->

<script>
    function genera_invoice(emi, cli, fec) {
        $.ajax({
            type: "POST",
            url: "invoice_generador.php",
            data: {
                emisor: emi,
                cliente: cli,
                fecha: fec
            }
        });
        alert("INVOICE CREADO con éxito");
        agrega_items();
    }
</script>

<!-- Ahora el Detalle de los ITEM -->
<script>
    function agrega_items() {
        var filas = [];

        $('#tablaItems tr').each(function() {
            var item = $(this).find('td').eq(0).text();
            var descripcion = $(this).find('td').eq(1).text();
            var valor = $(this).find('td').eq(2).text();

            var fila = {
                item,
                descripcion,
                valor
            };
            filas.push(fila);

        });
        // ahora ejecuta el php con los datos para insertar los items
        $.ajax({
            type: "POST",
            url: "invoice_json_insertar.php",
            data: {
                valores: JSON.stringify(filas)
            }
        });
        alert("Datos de ITEMS se han insertados con éxito")
    };
</script>