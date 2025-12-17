<?php 
    headerAdmin($data);
    $option = $data['infoPage']['status'];
    $fotoActual = $data['infoPage']['portada'];
    $fotoRemove = 0;
    $imgPortada = $fotoActual != "" ? '<img id="img" src="'.media()."/images/uploads/".$fotoActual.'">' : "";
    $pageRuta = base_url().'/'.$data['infoPage']['ruta'];
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?= $data['page_tag'] ?>            
        </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-solid fa-globe"></i></li>
        <li class="breadcrumb-item"><a href="<?= $pageRuta;?>">Ver pagina</a></li>
    </ul>
</div>  
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <form id="formPaginas" name="formPaginas">
                    <input type="hidden" name="idPost" id="idPost" value="<?= $data['infoPage']['idpost'] ?>">
                    <input type="hidden" id="foto_actual" name="foto_actual" value="<?= $fotoActual ?>">
                    <input type="hidden" id="foto_remove" name="foto_remove" value="<?= $fotoRemove ?>">
                    <p class="text-primary">Los campos con asterisco ( <span class="required"> * </span> ) son obligatorios.</p>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="control-label">Titulo<span class="required"> * </span></label>
                                <input class="form-control" type="text" id="txtTitulo" name="txtTitulo" value="<?= $data['infoPage']['titulo'] ?>" required>
                            </div>                            
                            <div class="form-group">
                                <label class="control-label">Contenido<span class="required"> * </span></label>
                                <textarea class="form-control" id="txtContenido" name="txtContenido">
                                    <?= $data['infoPage']['contenido'] ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group col col-md-12">                                
                                <label for="listStatus">Estado <span class="required">*</span></label>
                                <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                       
                            <div class="form-group col col-md-12">
                                <button id="btnActionForm" class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                            </div>

                        </div>
                    </div>
                    <div class="tile-footer">
                        <div class="form-group col-md-12">
                            <div id="containerGallery">
                                <h4>Portada</h4>
                                <span>Tamaño sugerido(1920px X 230px)</span>
                            </div>
                            <hr>
                            <div id="containerImages">
                                <div class="photo">
                                    <div class="prevPhoto prevPortada">
                                        <span class="delPhoto notBlock">X</span>
                                        <label for="foto"></label>
                                        <div>
                                            <?= $imgPortada; ?>
                                        </div>
                                    </div>
                                    <div class="upimg">
                                        <input type="file" name="foto" id="foto">
                                    </div>
                                    <div id="form_alert"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
               
            </div>
        </div>
    </div>
</div>
</main>
<?php footerAdmin($data); ?>
<script>
    document.querySelector('#listStatus').value = <?= $option; ?>
</script>
