<?php headerAdmin($data);?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url();?>/dashboard">Dashboard</a></li>
        </ul>
    </div>    
    <div class="row">
        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
        <div class="col-md-6 col-lg-3">
            <a href="<?= base_url() ?>/usuarios" class="linkw">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4>Usuarios</h4>
                        <p><b><?= $data['usuarios'] ?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
        <div class="col-md-6 col-lg-3">
            <a href="<?= base_url() ?>/clientes" class="linkw">
                <div class="widget-small info coloured-icon"><i class="icon fa fa-user fa-3x"></i>
                    <div class="info">
                        <h4>Clientes</h4>
                        <p><b><?= $data['clientes'] ?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
        <div class="col-md-6 col-lg-3">
            <a href="<?= base_url() ?>/productos" class="linkw">
                <div class="widget-small warning coloured-icon"><i class="icon fa fa-archive fa-3x"></i>
                    <div class="info">
                        <h4>Productos</h4>
                        <p><b><?= $data['productos'] ?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
        <div class="col-md-6 col-lg-3">
            <a href="<?= base_url() ?>/pedidos" class="linkw">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                    <div class="info">
                        <h4>Pedidos</h4>
                        <p><b><?= $data['pedidos'] ?></b></p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Ultimos Pedidos</h3>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">Pedido</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th class="text-right">Monto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        if (count($data['lastOrders']) > 0) {                            
                            foreach ($data['lastOrders'] as $pedido) {
                                $i++;
                        ?>
                        <tr>
                            <td class="font-weight-bold"><?= $i ?></td>
                            <td class="text-center"><?= $pedido['idpedido'] ?></td>
                            <td><?= $pedido['nombre'] ?></td>
                            <td><?= $pedido['status'] ?></td>
                            <td class="text-right"><?= SMONEY.' '.formatMoney($pedido['monto'])  ?></td>
                            <td><a href="<?= base_url() ?>/pedidos/orden/<?= $pedido['idpedido'] ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } ?>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Ultimos Productos</h3>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>                            
                            <th>Producto</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        if (count($data['productosTen']) > 0) {                            
                            foreach ($data['productosTen'] as $producto) {
                        ?>
                        <tr>
                            <td><?= $producto['idproducto'] ?></td>
                            <td><?= $producto['nombre'] ?></td>
                            <td><?= SMONEY.' '.formatMoney($producto['precio'])  ?></td>
                            <td><a href="<?= base_url() ?>/tienda/producto/<?= $producto['idproducto'].'/'.$producto['ruta'] ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></td>                            
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="container-title">
                    <h3 class="tile-title">Compras por mes</h3>
                    <div class="dflex">
                        <input class="date-picker ventasMes" name="ventasMes" placeholder="Mes y Año">
                        <button type="button" class="btnVentasMes btn btn-info btn-sm" onclick="fntSearchVMes();"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div id="graficaMes"></div>
            </div>
        </div>
    </div>
</main>
<?php footerAdmin($data); ?>

<script>
   
    Highcharts.chart('graficaMes', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Compras de <?= $data['ventasMDias']['mes'].' del '.$data['ventasMDias']['anio'] ?>'
        },
        subtitle: {
            text: 'Venta total: <?= SMONEY.' '. formatMoney($data['ventasMDias']['total']) ?>'
        },
        xAxis: {
            categories: [
                <?php 
                    foreach ($data['ventasMDias']['ventas'] as $dias) {
                        echo $dias['dia'].",";
                    }
                ?>
            ]
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: '',
            data: [
                <?php 
                    foreach ($data['ventasMDias']['ventas'] as $totales) {
                        echo $totales['total'].",";
                    }
                ?>
            ]
        }]
    });

</script>