<?php include 'header.php'; ?>
<?php include 'cn.php'; ?>

<div class="container section" id="todo">
    <h3 class="blue-text darken-2">Listado de Clientes</h3>
    <table class="highlight centered" class="responsive-table">
        <thead>
            <tr>
                <th>ID Cliente</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Código Postal</th>
                <th>País</th>
                <th>Teléfono</th>
                <th>Contacto 1</th>
                <th>Contacto 2</th>
            </tr>
        </thead>
        <?php
        $sql = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion, $sql);

        while ($lista = mysqli_fetch_array($resultado)) {
        ?>
            <tr>
                <td><?php echo $lista['idCliente'] ?></td>
                <td><?php echo $lista['nombre'] ?></td>
                <td><?php echo $lista['direccion'] ?></td>
                <td><?php echo $lista['ciudad'] ?></td>
                <td><?php echo $lista['cod_postal'] ?></td>
                <td><?php echo $lista['pais'] ?></td>
                <td><?php echo $lista['telefono'] ?></td>
                <td><?php echo $lista['contacto_1'] ?></td>
                <td><?php echo $lista['contacto_2'] ?></td>
            </tr>
        <?php
        };
        ?>

    </table>
    <button id="pdf" class="btn red">Crear PDF</button>

</div>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/jspdf.debug.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#pdf').on('click', function() {
            var doc = new jsPDF({
                orientation: 'landscape',
               
            })
            doc.fromHTML($('#todo').get(0));
            doc.save('prueba.pdf')
        });
    });
</script>



<?php include 'footer.php'; ?>