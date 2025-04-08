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
					//dep($data['objTransaccion']);
					if(empty($data['objTransaccion'])){
				?>
				<p>Datos no encontrados de la transaccion</p>
				<?php }else{
					//DATOS DE LA TRANSACCION
					$tsr = $data['objTransaccion']->purchase_units[0];
					$idTransaccion = $tsr->payments->captures[0]->id;
					$fecha = $tsr->payments->captures[0]->create_time;
					$estado = $tsr->payments->captures[0]->status;
					$monto = $tsr->payments->captures[0]->amount->value;
					$moneda = $tsr->payments->captures[0]->amount->currency_code;
					//DATOS DEL CLIENTE
					$cl = $data['objTransaccion']->payer;
					$nombreCliente = $cl->name->given_name.' '. $cl->name->surname;
					$emailCliente = $cl->email_address;
					$codCiudad = $cl->address->country_code;

					$direccion1 = $tsr->shipping->address->address_line_1;
					$direccion2 = $tsr->shipping->address->admin_area_2;
					$direccion3 = $tsr->shipping->address->admin_area_1;
					$codPostal = $tsr->shipping->address->postal_code;

					$emailComercio = $tsr->payee->email_address;
					//detalles
					$descripcion = $tsr->description;
					$montoDetalle = $tsr->amount->value;

					//Detalle pago
					$totalCompra =  $tsr->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
					$comision = $tsr->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
					$importeNeto = $tsr->payments->captures[0]->seller_receivable_breakdown->net_amount->value;
					?>
				<section id="sPedido" class="invoice">
					<div class="row mb-4">
						<div class="col-6">
							<h2 class="page-header"><img src="<?= media()?>/images/img-paypal.jpg"></h2>
						</div>
						<div class="col-6 text-right">
							<a href="#" class="btn btn-outline-primary"><i class="fa fa-reply-all"></i> REEMBOLSO </a>
						</div>
					</div>
					<div class="row invoice-info">
						<div class="col-4"><b>Transaccion: </b><?= $idTransaccion ?>
							<address><br>
								<b>Fecha: </b><?= $fecha ?><br>
								<b>Estado: </b><?= $estado ?><br>
								<b>Importe bruto: </b><?= $monto ?><br>
								<b>Moneda: </b><?= $moneda ?>
							</address>
						</div>
						<div class="col-4"><b>Enviado por :</b><br><br>
							<address>
								<b>Nombre: </b> <?= $nombreCliente ?><br>
								<b>Email: </b><?= $emailCliente ?><br>
								<b>Telefono:</b> <?= $data['arrPedido']['cliente']['telefono'] ?><br>
								<b>Direccion</b>  <?= $direccion1 ?><br>
								<?= $direccion2.', '.$direccion3.' '.$codPostal ?> <br>
								<?= $codCiudad?>
							</address>
						</div>
						<div class="col-4"><b>Eviado a: </b><br><br>
							<b>Email: </b> <?= $emailComercio ?> <br>							
						</div>
					</div>
					<div class="row">
						<div class="col-12 table-responsive">
							<table class="table">
								<thead class="thead-light">
									<tr>
										<th >Detalle Pedido</th>
										<th class="text-right">Cantidad</th>
										<th class="text-right">Precio</th>
										<th class="text-right">Subtotal</th>
									</tr>
								</thead>
								<tbody>									
									<tr>
										<td ><?= $descripcion ?></td>
										<td class="text-right">1</td>
										<td class="text-right" class="text-center"><?= $monto.' '.$moneda ?></td>
										<td class="text-right" class="text-right"><?= $monto.' '.$moneda ?></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>										
										<th colspan="3" class="text-right"><b>Total de la compra</b></th>
										<td class="text-right" ><?= $montoDetalle.' '.$moneda ?></td>
									</tr>
								</tfoot>
							</table>
							<table class="table">
								<thead class="thead-light">
									<tr>
										<th colspan="2"> Detalle del pago</th>
									</tr>
								</thead>
								<tbody>
									<div class="row">
										<tr>
											<td class="col-2"><strong>Total de la compra</strong></td>
											<td class="col-10 text-left"><?= $totalCompra.' '.$moneda ?></td>
										</tr>
										<tr>
											<td class="col-2"><strong>Comision Paypal</strong></td>
											<td class="col-10 text-left">-<?= $comision.' '.$moneda  ?></td>
										</tr>
										<tr>
											<td class="col-2"><strong>Inporte neto</strong></td>
											<td class="col-10 text-left"><?= $importeNeto.' '.$moneda ?></td>
										</tr>
									</div>
								</tbody>
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