<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Factura</title>
	<style>
		table{
			width: 100%;
		}
		table td, table th{
			font-size: 12px;
		}
		h4{
			margin-bottom: 0px;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.wd33{
			width: 33.33%;
		}
		.tbl-cliente{
			border: 1px solid #CCC;
			border-radius: 10px;
			padding: 5px;
		}
		.wd10{
			width: 10%;
		}
		.wd15{
			width: 15%;
		}
		.wd40{
			width: 40%;
		}
		.wd55{
			width: 55%;
		}
		.tbl-detalle{
			border-collapse: collapse;
		}
		.tbl-detalle thead th{
			padding: 5px;
			background-color: #009688;
			color: #FFF;
		}
		.tbl-detalle tbody td{
			border-bottom: 1px solid #CCC;
			padding: 5px;
		}
		.tbl-detalle tfoot td{
			padding: 5px;
		}
	</style>
</head>
<body>
	<table class="tbl-header">
		<tbody>
			<?php 
				$logo = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/TiendaVirtual-php/Assets/tienda/images/icons/logo-01.png'));
			?>
			<tr>
				<td class="wd33">
					<img src="data:image/png;base64,<?= $logo ?>">
				</td>
				<td class="text-center wd33">
					<h4><strong> <?= NOMBRE_EMPRESA ?> </strong></h4>
					<p><?= DIRECCION?> <br>
					Telefono: <?= TELEMPRESA ?> <br>
					Email: <?= EMAIL_EMPRESA ?></p>
				</td>
				<td class="text-right wd33">
					<P>N°. Orden <strong><?= $data['orden']['idpedido'] ?></strong></P>
					Fecha: <?= $data['orden']['fecha'] ?> <br>
					Metogo Pago: <?= $data['orden']['tipopago'] ?> <br>
					<?php 
						$transaccion = $data['orden']['tipopagoid'] == 1 ? $data['orden']['idtransaccionpaypal'] : $data['orden']['referenciacobro'];						
					?>
					Transaccion: <?= $transaccion ?>
				</td>
			</tr>
		</tbody>
	</table> <br>
	<table class="tbl-cliente">
		<tbody>
			<tr>
				<td class="wd10">NIT :</td>
				<td class="wd40"><?= $data['cliente']['nit'] ?></td>
				<td class="wd10">Telefono :</td>
				<td class="wd40"><?= $data['cliente']['telefono'] ?></td>
			</tr>
			<tr>
				<td>Nombre :</td>
				<td><?= $data['cliente']['nombres'].' '.$data['cliente']['apellidos'] ?></td>
				<td>Direccion :</td>
				<td><?= $data['cliente']['direccionfiscal'] ?></td>
			</tr>
		</tbody>
	</table> <br>
	<table class="tbl-detalle">
		<thead>
			<tr>
			    <th class="wd55">Descripcion</th>
			    <th class="wd15">Precio</th>
			    <th class="wd15">Cantidad</th>
			    <th class="wd15">Importe</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$subtotal = 0;
				foreach ($data['detalle'] as $detalles) {					
				$subtotal = $subtotal + $detalles['precio']*$detalles['cantidad'];
			?>
			<tr>
				<td><?= $detalles['producto'] ?></td>
				<td class="text-center"><?= SMONEY.' '.formatMoney($detalles['precio']) ?></td>
				<td class="text-center"><?=  SMONEY.' '.formatMoney($detalles['cantidad']) ?></td>
				<td class="text-right"><?=  SMONEY.' '.formatMoney($detalles['precio']*$detalles['cantidad']) ?></td>
			</tr>
			<?php
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" class="text-right">Subtotal:</td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($subtotal) ?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">Envio:</td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($data['orden']['costo_envio']) ?></td>
			</tr>
			<tr>
				<td colspan="3" class="text-right">Total:</td>
				<td class="text-right"><?= SMONEY.' '.formatMoney($data['orden']['monto']) ?></td>
			</tr>
		</tfoot>
	</table>
	<div class="text-center">
		<p>Si tiene pregunta sobre tu pedido <br> pongase en contacto con Nombre, Telefono y Email</p>
		<h4>¡Gracias por su compra!</h4>
	</div>
</body>
</html>