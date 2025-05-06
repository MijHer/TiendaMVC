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
				
				// INICIO PARA SANDBOX - PUEBA ---->
				$paraUrl = $objData->links[0]->href; //SANDBOX
				$objLinks = CurlConnectionGet($paraUrl, 'application/json',getTokenPaypal()); //SANDBOX
				$urlTransaccion = $objLinks->purchase_units[0]->payments->captures[0]->links[0]->href; //SANDBOX
				$urlOrden = $objLinks->purchase_units[0]->payments->captures[0]->links[2]->href; //SANDBOX
				// FIN SANDBOX - PUEBA  <----

				/*PARA INICIO  PRODUCCION **----
				$urlTransaccion = $objData->purchase_units[0]->payments->captures[0]->links[0]->href; 
				$urlOrden = $objData->purchase_units[0]->payments->captures[0]->links[2]->href;
				---*/

				$objTransaccion = CurlConnectionGet($urlOrden, 'application/json',getTokenPaypal() );
			}
			return $objTransaccion;
		}

		public function reembolsoPaypal(string $idtransaccion, string $observacion)
		{
			$response = false;
			$sql = "SELECT idpedido,datospaypal FROM pedido WHERE idtransaccionpaypal = '{$idtransaccion}'";
			$requestData = $this->select($sql);
			if (!empty($requestData)) {
				// INICIO PARA SANDBOX - PUEBA ---->
				$objData = json_decode($requestData['datospaypal']);
				$paraUrl = $objData->links[0]->href;
				$objLinks = CurlConnectionGet($paraUrl, 'application/json',getTokenPaypal());
				$urlReembolso = $objLinks->purchase_units[0]->payments->captures[0]->links[1]->href;
				// FIN SANDBOX - PUEBA  <----

				/*PARA INICIO  PRODUCCION **----
				$urlReembolso = $objData->purchase_units[0]->payments->captures[0]->links[1]->href; 
				$urlOrden = $objData->purchase_units[0]->payments->captures[0]->links[2]->href;
				---*/

				$objTransaccion = CurlConnectionPost($urlReembolso, 'application/json',getTokenPaypal());
				if (isset($objTransaccion->status) AND $objTransaccion->status == "COMPLETED") {
					$idpedido = $requestData['idpedido'];
					$idtransaccion = $objTransaccion->id;
					$intStatus = $objTransaccion->status;
					$jsonData = json_encode($objTransaccion);
					$observacion = $observacion;

					$sql_insert = "INSERT INTO reembolso(pedidoid, idtransaccion, datosreembolso, observacion, status) VALUES(?,?,?,?,?)";
					$arrData = array($idpedido, $idtransaccion, $intStatus, $jsonData, $observacion);
					$request_insert = $this->insert($sql_insert, $arrData);
					if ($request_insert > 0) {
						$updatePedido = "UPDATE pedido SET status = ? WHERE idpedido = $idpedido";
						$arrPedido = array("Reembolsado");
						$request = $this->update($updatePedido,$arrPedido);
						$response = true;
					}
				}
				return $response;
			}
		}

		public function updatePedido(int $idpedido, $transaccion = null, $idtipopago = null, string $estado)
		{
			if ($transaccion == null) {
				$query_insert = "UPDATE pedido SET status = ? WHERE idpedido = $idpedido";
				$arrData = array($estado);
			}else{
				$query_insert = "UPDATE pedido SET referenciacobro = ?, tipopagoid = ?, status = ? WHERE idpedido = $idpedido";
				$arrData = array($transaccion, $idtipopago, $estado);
			}
			$request_insert = $this->update($query_insert, $arrData);
			return $request_insert;
		}
	}
 ?>

