<?php 
    headerAdmin($data); 
    getModal('modalCategorias', $data);
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?= $data['page_tag'] ?>
            <?php if ($_SESSION['permisosMod']['w']) { ?>
                <button class="btn btn-primary" type="button" onclick="openModal();">Nuevo <i class="fa fa-solid fa-plus-circle"></i></button>
            <?php } ?>
        </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-user"></i></li>
        <li class="breadcrumb-item"><a href="<?= base_url();?>/categorias"><?= $data['page_tag'] ?></a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableCategorias">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
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
