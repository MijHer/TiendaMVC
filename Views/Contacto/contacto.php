<?php
	headerTienda($data);
	/*$banner = media().'/tienda/images/bg-01.jpg';*/
	$banner = $data['page']['portada'];
	$idpagina = $data['page']['idpost'];
?>

<script>
	document.querySelector('header').classList.add('header-v4');
</script>
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url(<?= $banner ?>);">
	<h2 class="ltext-105 cl0 txt-center">
		Contacto
	</h2>	
</section>	

<?php 
	if(viewPage($idpagina)) {
?>
<!-- Content page -->
<section class="bg0 p-t-104 p-b-116">
	<div class="container">
		<div class="flex-w flex-tr">
			<div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
				<form id="formContacto">
					<h4 class="mtext-105 cl2 txt-center p-b-30">
						Enviar un mensaje
					</h4>
					<div class="bor8 m-b-20 how-pos4-parent">
						<input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="nombreContacto" id="nombreContacto" placeholder="Nombre completo">
						<img class="how-pos4 pointer-none" src="<?= media() ?>/tienda/images/icons/icon-name.png" alt="ICON" style="width: 22px; opacity: 0.6;">
					</div>

					<div class="bor8 m-b-20 how-pos4-parent">
						<input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="emailContacto" id="emailContacto" placeholder="Email">
						<img class="how-pos4 pointer-none" src="<?= media() ?>/tienda/images/icons/icon-email.png" alt="ICON">
					</div>

					<div class="bor8 m-b-30">
						<textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="mensaje" id="mensaje" placeholder="Cual es tu mensaje"></textarea>
					</div>

					<button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
						Enviar
					</button>
				</form>
			</div>

			<div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
				<div class="flex-w w-full p-b-42">
					<span class="fs-18 cl5 txt-center size-211">
						<span class="lnr lnr-map-marker"></span>
					</span>

					<div class="size-212 p-t-2">
						<span class="mtext-110 cl2">
							Direccion
						</span>

						<p class="stext-115 cl6 size-213 p-t-18">
							<?= DIRECCION ?>
						</p>
					</div>
				</div>

				<div class="flex-w w-full p-b-42">
					<span class="fs-18 cl5 txt-center size-211">
						<span class="lnr lnr-phone-handset"></span>
					</span>

					<div class="size-212 p-t-2">
						<span class="mtext-110 cl2">
							Telefono
						</span>

						<p class="stext-115 cl1 size-213 p-t-18">
							<a class="" href="tel:<?= TELEMPRESA ?>"><?= TELEMPRESA ?></a>
						</p>
					</div>
				</div>

				<div class="flex-w w-full">
					<span class="fs-18 cl5 txt-center size-211">
						<span class="lnr lnr-envelope"></span>
					</span>

					<div class="size-212 p-t-2">
						<span class="mtext-110 cl2">
							E-mail
						</span>

						<p class="stext-115 cl1 size-213 p-t-18">
							<a class="" href="mailto:<?= EMAIL_EMPRESA ?>"><?= EMAIL_EMPRESA ?></a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php 
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
<!-- Map que se encuentra en el panel administrativo-->
<?php
	}
	footerTienda($data);
?>