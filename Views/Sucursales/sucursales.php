<?php 
	headerTienda($data);
	//$banner = media().'/tienda/images/bg-01.jpg'
	$banner = $data['page']['portada'];
	$idpagina = $data['page']['idpost'];
?>
<script>
	document.querySelector('header').classList.add('header-v4');
</script>
<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url(<?= $banner ?>);">
	<h2 class="ltext-105 cl0 txt-center">
		<?= $data['page']['titulo'] ?>
	</h2>
</section>

<?php 
	if (viewPage($idpagina)) {
		echo $data['page']['contenido'];
	}else{	
?>
	<div class="construction-container">
	    <div class="construction-content text-center">
	        <div class="construction-icon">
	            <img src="<?= media().'/images/construction.png' ?>" alt="En Construcción" class="construction-img">
	        </div>
	        <h1 class="construction-title">Estamos trabajando para ti</h1>
	        <p class="construction-subtitle">Algo increíble está en camino</p>
	        <div class="construction-progress">
	            <div class="progress-bar"></div>
	        </div>
	    </div>
	</div>
<?php

	}

	footerTienda($data);
?>