<?php 
headerTienda($data);
?>
<br><br><br>

<div class="jumbotron text-center">
	<h1 class="display-4">¡Gracias por su compra.!</h1>
	<p class="lead">Tu pedido fue procesado con exito</p>
	<p>No. Orden <strong><?= $data['orden']; ?></strong> </p>
	<?php 
		if (!empty($data['transaccion'])) {		
	?>
	<p>Transaccion: <strong><?= $data['transaccion']; ?></strong></p>
	<?php 
		} 
	?>
	<hr class="my-4">
	<p>Nos comunicaremos con usted para coordinar la entrega.</p>
	<p>Puedes ver tu pedido en la seccion de pedidos de tu usuario.</p>
	<br>
	<a class="btn btn-primary btn-lg" href="<?= base_url(); ?>" role="button">Continuar</a>
</div>
<br><br><br>

<?php 
footerTienda($data);
?>
