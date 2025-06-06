<?php 
 	class Dashboard extends Controllers
	{
		public function __construct()
		{
			//sessionStart();
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if (empty($_SESSION['login'])) 
			{
				header('location:'.base_url().'/login');
			}
			getPermisos(1);
		}

		public function dashboard()
		{
			
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard";
			$data['page_title'] = "Dashboard - Tienda Virtual";
			$data['page_name'] = "dashboard";
			$data['page_functions_js']  = "functions_dashboard.js";
			$data['usuarios'] = $this->model->cantUsuarios();
			$data['clientes'] = $this->model->cantClientes();
			$data['productos'] = $this->model->cantProductos();
			$data['pedidos'] = $this->model->cantPedidos();
			$data['lastOrders'] = $this->model->lastOrders();
			$data['productosTen'] = $this->model->productosTen();

			$anio = date('Y');
			$mes = date('m');

			$data['pagoMes'] = $this->model->selectPagoMes($anio, $mes);

			$data['ventasMDias'] = $this->model->selectVentasMes($anio, $mes);

			$data['ventasAnio'] = $this->model->selectVentasAnio($anio);

			if ($_SESSION['userData']['idrol'] == RCLIENTES) {
				$this->views->getView($this, 'dashboardClientes', $data);
			}else{
				$this->views->getView($this, 'dashboard', $data);
			}
		}

		public function tipoPagoMes()
		{
			if ($_POST) {
				$grafica = "tipoPagoMes";
				$nFecha = str_replace(" ","",$_POST['fecha']);
				$arrFecha = explode("-",$nFecha);
				$mes = $arrFecha[0];
				$anio = $arrFecha[1];
				$pagos = $this->model->selectPagoMes($anio,$mes);
				$script = getFile("Template/Modals/graficas",['grafica' => $grafica, 'pagos' => $pagos]);
				echo $script;
				die();
			}
		}

		public function ventasMes()
		{
			if ($_POST) {
				$grafica = "ventasMes";
				$nFecha = str_replace(" ","",$_POST['fecha']);
				$arrFecha = explode("-",$nFecha);
				$mes = $arrFecha[0];
				$anio = $arrFecha[1];
				$ventasMes = $this->model->selectVentasMes($anio,$mes);
				$script = getFile("Template/Modals/graficas",['grafica' => $grafica, 'pagos' => $ventasMes]);
				echo $script;
				die();
			}			
		}

		public function ventasAnio()
		{
			if ($_POST) {
				$grafica = "ventaAnio";
				$anio = intval($_POST['anio']);
				$ventaXAnio = $this->model->selectVentasAnio($anio);
				$script = getFile("Template/Modals/graficas",['grafica' => $grafica, 'pagos' => $ventaXAnio]);
				echo $script;
				die();
			}			
		}
	}
?>