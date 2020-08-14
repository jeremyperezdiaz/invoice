<?php include 'header.php'; ?>
<?php include 'cn.php'; ?>

<div class="section container">
    <h4 class="header left blue-text text-darken-2">Emitir Nuevo INVOICE</h4>
    <div class="row">

        <form method="POST" class="col s12">
            <div class="row card-panel">
                <div class="input field col s4">
                    <label>Seleccionar EMISOR del INVOICE</label>
                    <select name="emisor" id="emisor" required>
                        <option value="">Lista de Emisores</option>
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
                    <select name="cliente" id="cliente" required>
                        <option value="">Lista de clientes</option>
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
                    <input type="text" class="datepicker" id="fecha" name="fecha" required>
                </div>

                <!-- Tabla de Detalles de los Servicios-->

                <h4 class="header left blue-text text-darken-2">Detalle de servicios</h4>

                <!-- Modal Trigger -->
                <div class="col s12 center">
                    <a class="waves-effect waves-light btn modal-trigger green" href="#modal1"><i class="material-icons right">library_add
                        </i>Agregar Item</a>
                    <a onclick="eliminarFila()" class="waves-effect waves-light btn red">
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
        <div class="modal-content ">
            <h4 class="blue-text darken-2">Ingrese Item de Servicio</h4>
            <form>
                <div class="input field col s2">
                    <label>Seleccionar ITEM</label>
                    <select name="item" id="item">
                        <option val="" disabled>Lista de Items</option>
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
                <div class="input field col s8">
                    <label for="descripcionItem">Detalle del Item de Servicio</label>
                    <input value="" id="descripcionItem" name="descripcionItem" type="text" required>
                </div>
                <div class="input field col s2" required>
                    <label for="valorItem">Valor en USD $</label>
                    <input value="" id="valorItem" name="valorItem" type="number" required>
                </div>
                <div class="modal-footer">

                    <button class="left waves-effect waves-light btn-large blue darken-3" onclick="agregarFila(item.value, descripcionItem.value, valorItem.value)" type="reset">Agregar Item <i class="material-icons right">send</i>Agregar Item</a>
                    </button>

                    <a class="modal-close waves-effect waves-light btn-large red darken-3">
                        <i class="material-icons right">close</i>Cerrar</a>
                </div>
            </form>
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

        if (item.trim() == '') {
            M.toast({html: 'Porfavor ingrese Item de Servicio', classes: 'rounded orange'})
            //alert('porfavor ingrese Item de Servicio.');
            $('#item').formSelect();
            return false;
        }
        if (descripcion.trim() == '') {
            M.toast({html: 'Porfavor ingrese descripción', classes: 'rounded orange'})
            //alert('porfavor ingrese descripción.');
            $('#descripcionItem').focus();
            return false;
        }
        if (valor.trim() == '') {
            M.toast({html: 'Porfavor ingrese Valor', classes: 'rounded orange'})
            //alert('porfavor ingrese Valor.');
            $('#valorItem').focus();
            return false;
        } else {
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
            M.toast({html: '¡Agregado exitosamente!', classes: 'rounded green'})
            //alert('¡Agregado exitosamente!.');
        }
    }

    function eliminarFila() {
        document.getElementById("tablaItems").deleteRow(-1);
            M.toast({html: '¡Eliminada exitosamente!', classes: 'rounded red'})
    }

    function eliminarFilaID(r) {
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("tablaItems").deleteRow(i - 1);
        M.toast({html: '¡Eliminada exitosamente!', classes: 'rounded red'})
    }
</script>

<!-- Script para transformar la tabla en json -->
<!-- Primero genera el INVOICE -->

<script>
    function genera_invoice(emi, cli, fec) {

        if (emi && cli) {
            $.ajax({
                type: "POST",
                url: "invoice_generador.php",
                data: {
                    emisor: emi,
                    cliente: cli,
                    fecha: fec
                }
            });
            //agrega_items();
            if (agrega_items()) {
                window.location.href = "invoice_guardar.php";
                //M.toast({html: '¡Invoice Insertado con éxito!', classes: 'rounded green'})
                alert("¡Invoice Insertado con éxito!");
            } else {
                M.toast({html: '¡Tienes la TABLA de Servicios vacía!', classes: 'rounded orange'})
                //alert("Tienes la TABLA de Servicios vacía");
            }

        } else {
            M.toast({html: 'Tienes datos de Emisor o Cliente vacios', classes: 'rounded orange'})
            //alert("Tienes datos de Emisor o Cliente vacios");
        }
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
        if (Array.isArray(filas) && filas.length) {
            // ahora ejecuta el php con los datos para insertar los items
            $.ajax({
                type: "POST",
                url: "invoice_json_insertar.php",
                data: {
                    valores: JSON.stringify(filas)
                }
            });
            return true
        } else {
            return false
        }

    };
</script>