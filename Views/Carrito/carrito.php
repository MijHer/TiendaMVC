<?php 
	headerTienda($data);	
 ?>
	 <br> <br> <br>
	 <hr>
	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?php base_url(); ?>" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				<?= $data['page_title'] ?>
			</span>
		</div>
	</div>

	<?php
		$subtotal = 0;
		$total = 0; 
		if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0 ) {
	?>
	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table id="tblCarrito" class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Producto</th>
									<th class="column-2"></th>
									<th class="column-3">Precio</th>
									<th class="column-4">Catidad</th>
									<th class="column-5">Total</th>
								</tr>

								<?php 
									foreach ($_SESSION['arrCarrito'] as $productos) {
										$totalProductos = $productos['precio'] * $productos['cantidad'];
										$subtotal += $totalProductos;
										$idproducto = openssl_encrypt($productos['idproducto'], METHODENCRIPT, KEY)
									
								?>

								<tr class="table_row <?= $idproducto ?> ">
									<td class="column-1">
										<div class="how-itemcart1" idpr="<?= $idproducto; ?>" op="2" onclick="fntdelItem(this)">
											<img src="<?= $productos['imagen']; ?>" alt="<?= $productos['producto']; ?>">
										</div>
									</td>
									<td class="column-2"><?= $productos['producto']; ?></td>
									<td class="column-3"><?= SMONEY.formatMoney($productos['precio']); ?></td>
									<td class="column-4">
										<div class="wrap-num-product flex-w m-l-auto m-r-0">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" idpr="<?= $idproducto; ?>">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="<?= $productos['cantidad']; ?>" idpr="<?= $idproducto; ?>" >

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" idpr="<?= $idproducto; ?>">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
									</td>
									<td class="column-5"><?= SMONEY.formatMoney($totalProductos); ?></td>
								</tr>

								<?php } ?>

							</table>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Totales
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span id="subTotalCompra" class="mtext-110 cl2">
									<?= SMONEY.formatMoney($subtotal); ?>
								</span>
							</div>
						</div>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Envio:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2">
									<?= SMONEY.formatMoney(COSTOENVIO); ?>
								</span>
							</div>
						</div>

						<!-- <div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Shipping:
								</span>
							</div>

							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								<p class="stext-111 cl6 p-t-2">
									There are no shipping methods available. Please double check your address, or contact us if you need any help.
								</p>
								
								<div class="p-t-15">
									<span class="stext-112 cl8">
										Calculate Shipping
									</span>

									<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
										<select class="js-select2" name="time">
											<option>Select a country...</option>
											<option>USA</option>
											<option>UK</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>

									<div class="bor8 bg0 m-b-12">
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="State /  country">
									</div>

									<div class="bor8 bg0 m-b-22">
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Postcode / Zip">
									</div>
									
									<div class="flex-w">
										<div class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
											Update Totals
										</div>
									</div>
										
								</div>
							</div>
						</div> -->

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span id="totalCompra" class="mtext-110 cl2">
									<?= SMONEY.formatMoney($subtotal + COSTOENVIO); ?>
								</span>
							</div>
						</div>

						<a href="<?= base_url()?>/carrito/procesarpago" id="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Procesar Pago
						</a>
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php }else{ ?>
		<br>
		<div class="container" >
			<a href="<?= base_url(); ?>/tienda"> Ver Productos</a>
		</div>
		<br>
<?php
	} 
	footerTienda($data);
 ?>