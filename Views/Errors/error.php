<?php 
	headerTienda($data);
	$pageError = "";
	if (!empty($data['page'])) {
		$pageError = $data['page']['contenido'];
	}
?>

<script>
	document.querySelector('header').classList.add('header-v4');
</script>

<div class="container-fluid error-wrapper">
    <div class="row min-vh-100 align-items-center justify-content-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">
            
            <div class="error-card text-center">
                <?= $pageError ?>
                <a href="javascript:window.history.back();" class="btn btn-danger btn-lg">
                    ← Regresar
                </a>
            </div>

        </div>
    </div>
</div>

<?php 
	footerTienda($data)
?>