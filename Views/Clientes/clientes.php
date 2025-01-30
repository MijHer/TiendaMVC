<?php 
headerAdmin($data);
getModal('modalClientes', $data);
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
        <li class="breadcrumb-item"><a href="<?= base_url();?>/clientes"><?= $data['page_tag'] ?></a></li>
    </ul>
</div>  
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableClientes">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Identificacion</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Telefono</th>
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
