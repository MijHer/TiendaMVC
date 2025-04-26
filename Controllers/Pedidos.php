<?php 
	
	class Pedidos extends Controllers
	{
		
		function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if (empty($_SESSION['login'])) {
				header('Location: '.base_url().'/login');
				die();
			}getPermisos(5);

		}

		public function Pedidos()
		{
			if (empty($_SESSION['permisosMod']['r'])) {
				header('location: '.base_url().'/dashboard');
			}
			$data['page_tag'] = "Pedidos";
			$data['page_title'] = "Pedidos - Tienda Virtual";
			$data['page_name'] = "pedidos";
			$data['page_functions_js'] = "functions_pedidos.js";
			$this->views->getView($this, 'pedidos', $data);
		}		

		public function getPedidos()
		{
			if ($_SESSION['permisosMod']['r']) 
			{			
				$idpersona = ""	;
				if ($_SESSION['userData']['idrol'] == RCLIENTES) {
					$idpersona = $_SESSION['userData']['idpersona'];
				}
				$arrData = $this->model->selectPedidos($idpersona);
				for ($i=0; $i < count($arrData) ; $i++) 
				{
					$btnView = "";
					$btnEdit = "";
					$btnDelete = "";

					$arrData[$i]['transaccion'] = $arrData[$i]['referenciacobro'];
					if($arrData[$i]['idtransaccionpaypal'] != ""){
						$arrData[$i]['transaccion'] = $arrData[$i]['idtransaccionpaypal'];
					}

					$arrData[$i]['monto'] = SMONEY.formatMoney($arrData[$i]['monto']);

					if ($_SESSION['permisosMod']['r']) {
						$btnView .= ' <a title="Ver Detalle" href="'.base_url().'/pedidos/orden/'.$arrData[$i]['idpedido'].'" target="_blank" class="btn btn-info btn-sm"><i class="far fa-eye"></i></a>  
							<button class="btn btn-danger btn-sm" onClick="fntViewDFP('.$arrData[$i]['idpedido'].')" title="Generar PDF" ><i class="fas fa-file-pdf"></i></button>';

						if ($arrData[$i]['idtipopago'] == 1) {
							$btnView .= ' <a title="Ver Transaccion"  href="'.base_url().'/pedidos/transaccion/'.$arrData[$i]['idtransaccionpaypal'].'" class = "btn btn-info btn-sm" target="_blank" > <i class="fa fa-paypal" aria-hidden="true"></i></a>';
						}else{
							$btnView .= ' <button class="btn btn-secondary btn-sm" disabled=""><i class="fa fa-paypal" aria-hidden="true"></i></button>';
						}
					}

					if ($_SESSION['permisosMod']['u']) {			        	
			        	$btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditInfo('.$arrData[$i]['idpedido'].')" title="Editar Pedido"><i class="fa fa-solid fa-pencil"></i></button>';
			        }

			        if ($_SESSION['permisosMod']['d']) {
			        	$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idpedido'].')" title="Eliminar Pedido"><i class="fa fa-solid fa-trash"></i></button>';
			        }
					$arrData[$i]['options'] = '<div class="text-center">' .$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function orden($idpedido)
		{
			if (!is_numeric($idpedido)) {
				header('location: '.base_url().'/pedidos');
			}
			if (empty($_SESSION['permisosMod']['r'])) {
				header('location: '.base_url().'/dashboard');
			}
			$idpersona = "";
			if ($_SESSION['userData']['idrol'] == RCLIENTES) 
			{
				$idpersona = $_SESSION['userData']['idpersona'];
			}
			$data['page_tag'] = "Pedido";
			$data['page_title'] = "Pedido - Tienda Virtual";
			$data['page_name'] = "pedido";
			$data['arrPedido'] = $this->model->selectPedido($idpedido, $idpersona);
			$this->views->getView($this, 'orden', $data);

		}

		public function transaccion($transaccion)
		{			
			if (empty($_SESSION['permisosMod']['r'])) {
				header('location: '.base_url().'/dashboard');
			}
			$idpersona = "";
			if ($_SESSION['userData']['idrol'] == RCLIENTES) 
			{
				$idpersona = $_SESSION['userData']['idpersona'];
			}

			$requestTransaccion = $this->model->selectTransPaypal($transaccion, $idpersona);
			//dep($requestTransaccion);
			$data['page_tag'] = "Transaccion";
			$data['page_title'] = "Transaccion - Tienda Virtual";
			$data['page_name'] = "transaccion";
			$data['page_functions_js'] = "functions_pedidos.js";
			$data['objTransaccion'] = $requestTransaccion;
			$this->views->getView($this, 'transaccion', $data);
		}

		public function getTransaccion(string $transaccion)
		{
			if ($_SESSION['permisosMod']['r'] and $_SESSION['userData']['idrol'] != RCLIENTES) {
				if ($transaccion == "") {
					$arrResponse = array('status' => false, 'msg' => 'Datos incorrectos');
				}else{
					$transaccion = strClean($transaccion);
					$requestTransaccion = $this->model->selectTransPaypal($transaccion);
					if (empty($requestTransaccion)) {
						$arrResponse = array('status' => false, 'msg' => 'Datos no disponible');
					}else{
						$htmlModal = getFile("Template/Modals/modalReembolso",$requestTransaccion);
						$arrResponse = array('status' => true, "html" => $htmlModal);
					}
				}				
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setReembolso()
		{
			if ($_POST) {				
				if ($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES) 
				{
					$idtransaccion = strClean($_POST['idtransaccion']);
					$observacion = strClean($_POST['observacion']);
					$requestTransaccion = $this->model->reembolsoPaypal($idtransaccion, $observacion);
					if ($requestTransaccion) {
						$arrResponse = array("status" => true, "msg" => 'El reembolso se ha procesado');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible procesar Reembolso');
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible reembolsar, consulte al administrador');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getPedido($idpedido)
		{
			if ($_SESSION['permisosMod']['u'] AND $_SESSION['userData']['idrol'] != RCLIENTES) {
				
				if ($idpedido == "") 
				{
					$arrResponse = array('status' => false, "msg" => 'Datos incorrectos');
				}else{
					$requestPedido = $this->model->selectPedido($idpedido,"");
					if(empty($requestPedido))
					{
						$arrResponse = array('status' => false, "msg" => 'Datos no disponible');
					}else{
						$htmlModal = getFile("Template/Modals/modalPedido", $requestPedido);
						$arrResponse = array('status' => true, "html" => $htmlModal);
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
?>