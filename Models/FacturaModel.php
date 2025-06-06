<?php 
	
	class FacturaModel extends Mysql
	{
		
		public function __construct()
		{
			parent::__construct();
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
	}

?>