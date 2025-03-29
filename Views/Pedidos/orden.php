<?php 
	headerAdmin($data);	
?>
<main class="app-content">
	<div class="app-title">
		<div>
			<h1><?= $data['page_title'] ?></h1>
		</div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="<?= base_url();?>/pedidos">Pedidos</a></li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<?php 
					if(empty($data['arrPedido'])){
				?>
				<p>Datos no encontrados</p>
				<?php }else{ 
					$cliente = $data['arrPedido']['cliente'];
					$orden = $data['arrPedido']['orden'];
					$detalle = $data['arrPedido']['detalle'];
					$transaccion = $orden['idtransaccionpaypal'] != "" ? $orden['idtransaccionpaypal'] : $orden['referenciacobro'];
					?>
				<section id="sPedido" class="invoice">
					<div class="row mb-4">
						<div class="col-6">
							<h2 class="page-header"><img src="<?= media()?>/tienda/images/icons/logo-01.png"></h2>
						</div>
						<div class="col-6">
							<h5 class="text-right"><?= $orden['fecha'] ?></h5>
						</div>
					</div>
					<div class="row invoice-info">
						<div class="col-4">De :
							<address><strong><?= NOMBRE_EMPRESA; ?></strong><br>
								<?= DIRECCION ?><br>
								<?= TELEMPRESA ?><br>
								<?= EMAIL_EMPRESA ?><br>
								<?= WEB_EMPRESA ?>
							</address>
						</div>
						<div class="col-4">Para :
							<address><strong><?= $cliente['nombres'].' '.$cliente['apellidos'] ?></strong><br>
								<?= $cliente['direccionfiscal'] ?><br>
								<?= $cliente['nombrefiscal'] ?><br>
								Telefono: <?= $cliente['telefono'] ?><br>
								Email: <?= $cliente['user'] ?></address>
						</div>
						<div class="col-4"><b>Orden #<?= $orden['idpedido'] ?></b><br><br>
							<b>Pago: </b> <?= $orden['tipopago'] ?> <br>
							<b>Transaccion: </b> <?= $transaccion ?><br>
							<b>Estado: </b> <?= $orden['status'] ?><br>
							<b>Monto: </b> <?= SMONEY.' '.formatMoney($orden['monto']) ?>
						</div>
					</div>
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Descripcion</th>
										<th>Precio</th>
										<th class="text-center">Cantidad</th>
										<th class="text-right">Importe</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$subtotal = 0;
										for ($i=0; $i < count($detalle); $i++) { 
											$descripcion = $detalle[$i]['producto'];
											$precio = $detalle[$i]['precio'];
											$cantidad = $detalle[$i]['cantidad'];
											$importe = $precio * $cantidad;
											$subtotal = $importe + $subtotal;
									?>
									<tr>
										<td><?= $descripcion ?></td>
										<td><?= SMONEY.' '.formatMoney($precio)  ?></td>
										<td class="text-center"><?= $cantidad ?></td>
										<td class="text-right"><?= SMONEY.' '.formatMoney($importe)  ?></td>
									</tr>
									<?php 
										} 
									?>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="3" class="text-right">Sub-Total:</th>
										<td class="text-right"><?= SMONEY.' '.formatMoney($subtotal) ?></td>
									</tr>
									<tr>
										<th colspan="3" class="text-right">Envio:</th>
										<td class="text-right"><?= SMONEY.' '.formatMoney($orden['costo_envio']) ?></td>
									</tr>
									<tr>
										<th colspan="3" class="text-right">Total:</th>
										<td class="text-right"><?= SMONEY.' '.formatMoney($orden['monto']) ?></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<div class="row d-print-none mt-2">
						<div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print('#sPedido');" ><i class="fa fa-print"></i> Imprimir</a></div>
					</div>
				</section>
				<?php 
					}
				 ?>
			</div>
		</div>
	</div>
</main>
<?php 
	footerAdmin($data);
 ?>