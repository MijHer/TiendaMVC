<?php 

	class PedidosModel extends Mysql
	{

		public function __construct()
		{
			parent::__construct();
		}

		public function selectPedidos($idpersona = null)
		{
			$where = "";
			if ($idpersona != null) {
				$where = " WHERE p.personaid = ".$idpersona;
			}
			$sql = "SELECT p.idpedido, 
							p.referenciacobro,
							p.idtransaccionpaypal,
							date_format(p.fecha, '%d/%m/%Y') as fecha , 
							p.monto, 
							t.tipopago,
							t.idtipopago, 
							p.status 
					FROM pedido p
					INNER JOIN tipopago t
					ON p.tipopagoid = t.idtipopago $where;
					";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectPedido(int $idpedido, $idpersona = null)
		{
			$busqueda = "";
			if ($idpersona != NULL) {
				$busqueda = " AND p.personaid =".$idpersona;
			}
			$request = array();
			$sql = "SELECT p.idpedido, 
							p.referenciacobro, 
							p.idtransaccionpaypal, 
							p.personaid, 
							date_format(p.fecha, '%d/%m/%Y') as fecha,
							p.costo_envio,
							p.monto,
							p.tipopagoid,
							t.tipopago,
							p.direccion_envio,
							p.status
							FROM pedido p
							INNER JOIN tipopago t
							ON p.tipopagoid = t.idtipopago
							WHERE p.idpedido = $idpedido ".$busqueda;
			$requestPedido = $this->select($sql);
			//dep($requestPedido);exit();
			if (!empty($requestPedido)) {
				$idpersona = $requestPedido['personaid'];
				$sql_cliente = "SELECT idpersona, 
										nombres, 
										apellidos, 
										telefono, 
										email_user
										user, 
										nit, 
										nombrefiscal, 
										direccionfiscal
										FROM persona
										WHERE idpersona = $idpersona";
				$requestCliente = $this->select($sql_cliente);
				$sql_detalle = "SELECT p.idproducto,
										p.nombre as producto,
										dp.precio, 
										dp.cantidad
										FROM detalle_pedido dp
										INNER JOIN producto p
										ON dp.productoid = p.idproducto
										WHERE dp.pedidoid = $idpedido;
										";
				$requestProductos = $this->select_all($sql_detalle);
				$request = array('cliente' => $requestCliente,
									'orden' => $requestPedido,
									'detalle' => $requestProductos
									);
			}			
			return $request;
		}

		public function selectTransPaypal(string $transaccion, $idpersona = null)
		{
			$busqueda = "";
			if ($idpersona != null) {
				$busqueda = "AND personaid = $idpersona";
			}

			$objTransaccion = array();
			$sql = "SELECT datospaypal FROM pedido WHERE idtransaccionpaypal = '{$transaccion}'".$busqueda;
			$requestData = $this->select($sql);
			//dep($requestData); exit();
			if (!empty($requestData)) {
				$objData = json_decode($requestData['datospaypal']);
				
				//PARA SANDBOX - PUEBA ---->
				$paraUrl = $objData->links[0]->href; //SANDBOX
				$objLinks = CurlConnectionGet($paraUrl, 'application/json',getTokenPaypal()); //SANDBOX
				$urlTransaccion = $objLinks->purchase_units[0]->payments->captures[0]->links[0]->href; //SANDBOX
				$urlOrden = $objLinks->purchase_units[0]->payments->captures[0]->links[2]->href; //SANDBOX
				// FIN SANDBOX - PUEBA  <----

				/*PARA PRODUCCION **----
				$urlTransaccion = $objData->purchase_units[0]->payments->captures[0]->links[0]->href; 
				$urlOrden = $objData->purchase_units[0]->payments->captures[0]->links[2]->href;
				---*/

				$objTransaccion = CurlConnectionGet($urlOrden, 'application/json',getTokenPaypal() );
			}
			return $objTransaccion;
		}

	}
 ?>

