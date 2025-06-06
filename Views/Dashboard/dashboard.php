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
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-cart fa-3x"></i>
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
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th class="text-right">Monto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($data['lastOrders']) > 0) {                            
                            foreach ($data['lastOrders'] as $pedido) {
                        ?>
                        <tr>
                            <td><?= $pedido['idpedido'] ?></td>
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
                <div class="container-title">
                    <h3 class="tile-title">Tipos de pago por mes</h3>
                    <div class="dflex">
                        <input class="date-picker pagoMes" name="pagoMes" placeholder="Mes y Año">
                        <button type="button" class="btnTipoVentaMes btn btn-info btn-sm" onclick="fntSearchPagos();"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div id="pagosMesAnio"></div>
            </div>            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="container-title">
                    <h3 class="tile-title">Ventas por mes</h3>
                    <div class="dflex">
                        <input class="date-picker ventasMes" name="ventasMes" placeholder="Mes y Año">
                        <button type="button" class="btnVentasMes btn btn-info btn-sm" onclick="fntSearchVMes();"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div id="graficaMes"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <div class="container-title">
                    <h3 class="tile-title">Ventas por año</h3>
                    <div class="dflex">
                        <input class="ventasAnio" name="ventasAnio" placeholder="Año" minlength="4" maxlength="4" onkeypress="return controlTag(event);">
                        <button type="button" class="btnVentasAnio btn btn-info btn-sm" onclick="fntSearchVAnio();"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div id="graficaAnio"></div>
            </div>
        </div>
    </div>
</main>
<?php footerAdmin($data); ?>
<!-- PARA PAGOS POR MES Y AÑO -->
<?php 
    foreach ($data['pagoMes']['tipospago'] as $pagos) {
        $seriesData[] = [
            'name' => $pagos['tipopago'],
            'y' => (float) $pagos['total']
        ];
    }
?>
<!-- PARA PAGOS POR MES Y AÑO FIN-->

<script>

    Highcharts.chart('pagosMesAnio', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Ventas por tipo pago, <?= $data['pagoMes']['mes'].' '.$data['pagoMes']['anio'] ?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: <?= json_encode($seriesData) ?>
            
        }]
    });


    Highcharts.chart('graficaMes', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Ventas de <?= $data['ventasMDias']['mes'].' del '.$data['ventasMDias']['anio'] ?>'
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


    Highcharts.chart('graficaAnio', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Ventas del <?= $data['ventasAnio']['anio'] ?>'
        },
        subtitle: {
            text: 'Estadistica de venta por mes'
        },
        xAxis: {
            type: 'category',
            labels: {
                autoRotation: [-45, -90],
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Venta mensual'
        },
        series: [{
            name: 'Population',
            colors: [
                '#9b20d9', '#9215ac', '#861ec9', '#7a17e6', '#7010f9', '#691af3',
                '#6225ed', '#5b30e7', '#533be1', '#4c46db', '#4551d5', '#3e5ccf',
                '#3667c9', '#2f72c3', '#277dbd', '#1f88b7', '#1693b1', '#0a9eaa',
                '#03c69b',  '#00f194'
            ],
            colorByPoint: true,
            groupPadding: 0,
            data: [
                <?php 
                    for ($i=0; $i < count($data['ventasAnio']['meses']); $i++) { 
                        $nombre = $data['ventasAnio']['meses'][$i]['mes'];
                        $venta = $data['ventasAnio']['meses'][$i]['venta'];                    
                        echo  "['$nombre', $venta],"; 
                        }
                ?>
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                inside: true,
                verticalAlign: 'top',
format: '{point.y:.1f}', // one decimal
y: 10, // 10 pixels down from the top
style: {
    fontSize: '13px',
    fontFamily: 'Verdana, sans-serif'
}
}
}]
    });
</script>