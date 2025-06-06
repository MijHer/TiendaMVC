<?php 
	
	class DashboardModel extends Mysql
	{
		
		public function __construct()
		{
			parent::__construct();
		}

		public function cantUsuarios()
		{
			$sql = "SELECT COUNT(*) AS total FROM persona WHERE status = 1";
			$request = $this->select($sql);
			$total = $request['total'];
			return $total;
		}

		public function cantClientes()
		{
			$sql = "SELECT COUNT(*) AS total FROM persona WHERE status = 1 AND rolid = ".RCLIENTES;
			$request = $this->select($sql);
			$total = $request['total'];
			return $total;
		}

		public function cantProductos()
		{
			$sql = "SELECT COUNT(*) AS total FROM producto WHERE status = 1";
			$request = $this->select($sql);
			$total = $request['total'];
			return $total;
		}

		public function cantPedidos()
		{
			$rolid = $_SESSION['userData']['idrol'];
			$idUser = $_SESSION['userData']['idpersona'];
			$where = "";
			if ($rolid == RCLIENTES) {
				$where = " WHERE personaid =".$idUser;
			}
			$sql = "SELECT COUNT(*) AS total FROM pedido".$where;
			$request = $this->select($sql);
			$total = $request['total'];
			return $total;
		}
		public function lastOrders()
		{
			$rolid = $_SESSION['userData']['idrol'];
			$idUser = $_SESSION['userData']['idpersona'];
			$where = "";
			if ($rolid == RCLIENTES) {				
				$where = "WHERE p.personaid =".$idUser;
			}
			$sql = "SELECT p.idpedido, p.personaid, p.status, p.monto, CONCAT(pe.nombres,' ', pe.apellidos) AS nombre  
					FROM pedido p 
					INNER JOIN persona pe					
					ON p.personaid  = pe.idpersona
					$where
					ORDER BY p.fecha DESC LIMIT 11";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectPagoMes(int $anio, int $mes)
		{
			$sql = "SELECT p.tipopagoid, t.tipopago, COUNT(p.tipopagoid) AS cantidad, SUM(p.monto) AS total 
					FROM pedido p
					INNER JOIN tipopago t
					ON p.tipopagoid = t.idtipopago
					WHERE MONTH(p.fecha) = $mes AND YEAR(p.fecha) = $anio
					GROUP BY tipopagoid";
			$pagos = $this->select_all($sql);
			$meses = Meses();
			$arrData = array('anio' => $anio, 'mes' => $meses[intval($mes-1)]  , 'tipospago' => $pagos);
			return $arrData;
		}

		public function selectVentasMes(int $anio, int $mes)
		{
			$rolid = $_SESSION['userData']['idrol'];
			$idUser = $_SESSION['userData']['idpersona'];
			$where = "";
			if ($rolid == RCLIENTES) {
				$where = " AND personaid =".$idUser;
			}
			$totalVentasMes = 0;
			$arrVentasDias = array();
			$dias = cal_days_in_month(CAL_GREGORIAN,$mes, $anio);
			$n_dia = 1;
			for ($i=0; $i < $dias; $i++) { 
				$fechaVenta = date_format(date_create($anio.'-'.$mes.'-'.$n_dia), "Y-m-d");
				//dep($fechaVenta);
				$sql = "SELECT DAY(fecha) AS dia, COUNT(idpedido) AS cantidad, SUM(monto) AS total
						FROM pedido
						WHERE DATE(fecha) = '$fechaVenta' AND STATUS = 'Completado' $where
						GROUP BY dia";
				$ventaDia = $this->select($sql);
				if (!$ventaDia) {
				    $ventaDia = [
				        'dia' => $n_dia,
				        'cantidad' => 0,
				        'total' => 0
				    ];
				}
				$totalVentasMes += $ventaDia['total'];
				array_push($arrVentasDias, $ventaDia);
				$n_dia++;
			}
			$meses = Meses();
			$arrData = array('anio' => $anio, 'mes' => $meses[intval($mes-1)],'total' => $totalVentasMes, 'ventas' => $arrVentasDias);
			return $arrData;
		}

		public function selectVentasAnio(int $anio)
		{
			$ventaTotal = 0;
			$arrMVentas = array();
			$arrMeses = Meses();
			for ($i=1; $i <= count($arrMeses); $i++) { 
				$arrData = array('anio'=>'','no_mes'=>'','mes'=>'','venta'=>'');
				$sql = "SELECT $anio AS anio, $i as mes, sum(monto) AS venta
						FROM pedido 
						WHERE MONTH(fecha) = $i AND YEAR(fecha) = $anio AND STATUS = 'Completado'
						GROUP BY MONTH(fecha)";
				$ventaMes = $this->select($sql);
				$arrData['mes'] = $arrMeses[$i-1];
				if(empty($ventaMes)){
					$arrData['anio'] = $anio;
					$arrData['no_mes'] = $i;
					$arrData['venta'] = 0;
				}else{
					$arrData['anio'] = $ventaMes['anio'];
					$arrData['no_mes'] = $ventaMes['mes'];
					$arrData['venta'] = $ventaMes['venta'];
				}
				array_push($arrMVentas, $arrData);
			}			
			$arrVentas = array('anio' => $anio, 'meses' => $arrMVentas);
			return $arrVentas;
		}

		public function productosTen()
		{
			$sql = "SELECT * FROM producto ORDER BY idproducto DESC LIMIT 1,10";
			$request = $this->select_all($sql);
			return $request;
		}
	}
?>

