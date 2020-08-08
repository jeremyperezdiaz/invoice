<?php include 'cn.php'; ?>

<?php
$sql = "SELECT i.idInvoice as idInvoice, i.fecha AS fecha, e.nombre AS nombreEmisor, c.nombre AS nombreCliente, c.contacto_1 as contacto_1,
        d.valor as valor, est.descripcion as estadoPago, i.total as total, item.descripcion AS itemDescripcion, d.descripcion as itemDetalle
        FROM invoice i
        INNER JOIN cliente c ON i.idCliente = c.idCliente
        INNER JOIN emisor e ON i.idEmisor = e.idEmisor
        INNER JOIN estado est ON i.idEstado = est.idEstado
        INNER JOIN detalle d ON d.idInvoice = i.idInvoice
        INNER JOIN item ON item.idItem = d.idItem
        where i.idInvoice=116";
$resultado = mysqli_query($conexion, $sql);
$i = 0;

while ($lista[] =  mysqli_fetch_array($resultado));

  print_r($lista);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link rel="stylesheet" href="css/style_invoice_base.css" media="all" />
</head>

<body id="content">
  <header class="clearfix">
    <div id="logo">
      <img src="img/logo_ozeros.png">
    </div>
    <div id="company">
      <h2 class="name">OZEROS</h2>
      <div>No 12492, Los boldos street, El Bosque</div>
      <div>Santiago, Chile</div>
      <div>Tel : +56-9-75175766</div>
      <div><a href="mailto:company@example.com">jeremy@ozeros.com</a></div>
    </div>
    </div>
  </header>
  <main>
    <div id="details" class="clearfix">
      <div id="client">
        <div class="to">INVOICE TO:</div>
        <h2 class="name">MSI Computer Corp.</h2>
        <div class="address">901 Canada Court</div>
        <div class="address">City of Industry, CA 91748</div>
      </div>
      <div id="client">
        <div class="to">CONTACT:</div>
        <h2 class="name">Samuel Rojas</h2>
        <div class="email"><a href="mailto:john@example.com">samuelrojas@msi.com</a></div>
      </div>

      <div id="invoice">
        <h1>INVOICE Nº 1000</h1>
        <div class="date">Date of Invoice: 01/01/2020</div>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th class="tablehead">#</th>
          <th class="tablehead">ITEM</th>
          <th class="tablehead">DESCRIPTION</th>
          <th class="tablehead">TOTAL</th>
        </tr>
      </thead>
      <tbody>
        <?php
        /*$sql = "SELECT i.idInvoice as idInvoice, i.fecha AS fecha, e.nombre AS nombreEmisor, c.nombre AS nombreCliente, c.contacto_1 as contacto_1,
        d.valor as valor, est.descripcion as estadoPago, i.total as total, item.descripcion AS itemDescripcion, d.descripcion as itemDetalle
        FROM invoice i
        INNER JOIN cliente c ON i.idCliente = c.idCliente
        INNER JOIN emisor e ON i.idEmisor = e.idEmisor
        INNER JOIN estado est ON i.idEstado = est.idEstado
        INNER JOIN detalle d ON d.idInvoice = i.idInvoice
        INNER JOIN item ON item.idItem = d.idItem
        where i.idInvoice=116";
        $resultado = mysqli_query($conexion, $sql);
        $i = 0;

        while ($lista = mysqli_fetch_array($resultado)) {
        ?>
          <tr>
            <td class="no"><?php echo ($i = $i + 1) ?> </td>
            <td class="item"><?php echo $lista['itemDescripcion'] ?></td>
            <td class="desc"><?php echo $lista['itemDetalle'] ?></td>
            <td class="total"><?php echo $lista['valor'] ?></td>
          </tr>
        <?php
        };
        */
        foreach ($lista as $list){
        ?>
        <tr>
            <td class="no"><?php echo 1 ?> </td>
            <td class="item"><?php echo $list['itemDescripcion'] ?></td>
            <td class="desc"><?php echo $list['itemDetalle'] ?></td>
            <td class="total"><?php echo $list['valor'] ?></td>
          </tr>
        <?php
        };
        ?>


      </tbody>
      <tfoot>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="1" id="grandTotal">GRAND TOTAL</td>
          <td>$6,500.00</td>
        </tr>
      </tfoot>
    </table>
    <!-- <div id="thanks">Thank you!</div> -->

    <div id="totalInWords">SAY TOTAL US DOLLARS ONE THOUSAND AND EIGHTY EIGHT.</div>
    <div id="banks">
      <div>Bank Account:</div>
      <div class="bank">Beneficiary’s Name: Jeremy Roberto Perez Diaz</div>
      <div class="bank">Beneficiary’s Address: Los Boldos #12492, Santiago, Chile</div>
      <div class="bank">Beneficiary’s Account Number: Cuenta Vista No 0-070-00-30025-4</div>
      <div class="bank">Receiving Bank’s Name: Santander-Chile</div>
      <div class="bank">Receiving Bank’s Address: Bandera 140, Santiago, Chile</div>
      <div class="bank">SWIFT Code: BSCH CL RM</div>
    </div>
  </main>
  <footer>
    Invoice was created on a computer and is valid without the signature and seal.
  </footer>
</body>
</html>