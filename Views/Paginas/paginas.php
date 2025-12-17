<?php 
    headerAdmin($data);
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?= $data['page_tag'] ?>
            <?php if ($_SESSION['permisosMod']['w']) { ?>
                <a href="<?= base_url(); ?>/paginas/crear" class="btn btn-primary" >Crear pagina <i class="fa fa-solid fa-plus-circle"></i></a>
            <?php } ?>
            </h1>
        </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-user"></i></li>
        <li class="breadcrumb-item"><a href="<?= base_url();?>/paginas"><?= $data['page_tag'] ?></a></li>
    </ul>
</div>  
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tablePaginas">
                        <thead>
                            <tr>
                                <th>Id</th>                  
                                <th>Titulo</th>                                
                                <th>Fecha</th>
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
