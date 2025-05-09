<?php 
headerAdmin($data); 
//getModal('modalProductos', $data);
?>
<div id="divModal"></div>
<main class="app-content">
	<div class="app-title">
		<div>
			<h1><?= $data['page_tag'] ?></h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-user"></i></li>
		<li class="breadcrumb-item"><a href="<?= base_url();?>/pedidos"><?= $data['page_tag'] ?></a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<div class="tile-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered" id="tablePedidos">
						<thead>
							<tr>
								<th>Id</th>
								<th>Ref. / Transaccion</th>
								<th>Fecha</th>
								<th>Monto</th>
								<th>Tipo Pago</th>
								<th>Estado</th>
								<th>Acciones</th>                            
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

</main>
<?php footerAdmin($data); ?>
