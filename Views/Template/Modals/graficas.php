<?php
if ($data['grafica'] == "tipoPagoMes") {
	$pagoMes = $data['pagos'];
	if (!empty($pagoMes['tipospago'])) {
		foreach ($pagoMes['tipospago'] as $pagos) {
			$seriesData[] = [
				'name' => $pagos['tipopago'],
				'y' => (float) $pagos['total']
			];
		}
	}		
	?>
	<script>
		Highcharts.chart('pagosMesAnio', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Ventas por tipo pago, <?= $pagoMes['mes'].' '.$pagoMes['anio'] ?>'
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
	</script>
<?php 
	} 
?>
<!-- ####################################### -->
<?php 
if($data['grafica'] == "ventasMes"){
	$ventasMes = $data['pagos'];
	?>
	<script>
		Highcharts.chart('graficaMes', {
			chart: {
				type: 'line'
			},
			title: {
				text: 'Ventas de <?= $ventasMes['mes'].' del '.$ventasMes['anio'] ?>'
			},
			subtitle: {
				text: 'Total Ventas <?= SMONEY.'. '.formatMoney($ventasMes['total']) ?> '
			},
			xAxis: {
				categories: [
					<?php 
					foreach ($ventasMes['ventas'] as $dia) {
						echo $dia['dia'].",";
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
					foreach ($ventasMes['ventas'] as $dia) {
						echo $dia['total'].",";
					}
					?>
				]
			}]
		});
	</script>
<?php 
	} 
?>
<!-- ####################################### -->
<?php 
if($data['grafica'] == "ventaAnio") {
	$ventasAnio = $data['pagos'];
?>
	<script>
		Highcharts.chart('graficaAnio', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Ventas del <?= $ventasAnio['anio'] ?>'
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
                    for ($i=0; $i < count($ventasAnio['meses']); $i++) { 
                        $nombre = $ventasAnio['meses'][$i]['mes'];
                        $venta = $ventasAnio['meses'][$i]['venta'];                    
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
<?php 
}
?>
