<?php 
	
	require_once("Libraries/Core/Mysql.php");

	trait TCliente
	{
		private $con;
		private $strNombre;
		private $intIdUsuario;
		private $intIdTransaccion;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;		
		
		public function insertClienteT(string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid)
		{
			$this->con = new Mysql();

			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;

			$return = 0;
			$sql = "SELECT * FROM persona WHERE email_user = '{$this->strEmail}' ";
			$request = $this->con->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO persona(nombres,apellidos,telefono,email_user,password,rolid) 
								  VALUES(?,?,?,?,?,?)";
	        	$arrData = array($this->strNombre,
	    						$this->strApellido,
	    						$this->intTelefono,
	    						$this->strEmail,
	    						$this->strPassword,
	    						$this->intTipoId);
	        	$request_insert = $this->con->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
	       
		}

		public function insertPedido(string $idtransaccionpaypal = NULL, string $datospaypal = NULL, int $personaid, float $costo_envio, string $monto, int $tipopagoid, string $direccionenvio,string $status)
		{
			$this->con = new Mysql();
			$query_insert = "INSERT INTO pedido(idtransaccionpaypal, datospaypal, personaid, costo_envio, monto, tipopagoid, direccion_envio, status) VALUES(?,?,?,?,?,?,?,?)";
			$arrData = array($idtransaccionpaypal,
								$datospaypal,
								$personaid,
								$costo_envio,
								$monto,
								$tipopagoid,
								$direccionenvio,
								$status
							);
			$request_insert = $this->con->insert($query_insert, $arrData);
			$return = $request_insert;
			return $return;
		}

   		public function insertDetalle(int $idpedido,int $productoid,float $precio,int $cantidad)
		{
			$this->con = new Mysql();
			$query_insert = "INSERT INTO detalle_pedido(pedidoid, productoid, precio, cantidad) VALUES(?,?,?,?)";
			$arrData = array($idpedido,$productoid,$precio,$cantidad);
			$request_insert = $this->con->insert($query_insert, $arrData);
			$return = $request_insert;
			return $return;
		}

		public function insertDetalleTemp(array $pedido)
		{
			$this->con = new Mysql();

			$this->intIdUsuario = $pedido['idcliente'];
			$this->intIdTransaccion = $pedido['idtransaccion'];
			$productos = $pedido['productos'];
			$sql = "SELECT * FROM detalle_temp WHERE transaccionid = '{$this->intIdTransaccion}' AND personaid = $this->intIdUsuario ";
			$request = $this->con->select_all($sql);

			if (empty($request)) 
			{
				foreach ($productos as $producto) 
				{
					$sql_insert = "INSERT INTO detalle_temp(personaid, productoid, precio, cantidad, transaccionid) VALUES(?,?,?,?,?)";
					$arrData = array($this->intIdUsuario, 
									$producto['idproducto'],
									$producto['precio'],
									$producto['cantidad'],
									$this->intIdTransaccion
								);
					$request_insert = $this->con->insert($sql_insert, $arrData);
				}				
			}else{
				$sqlDelete = "DELETE FROM detalle_temp WHERE transaccionid = '{$this->intIdTransaccion}' AND personaid = $this->intIdUsuario";
				$request_delete = $this->con->delete($sqlDelete);

				foreach ($productos as $producto) 
				{
					$sql_insert = "INSERT INTO detalle_temp(personaid, productoid, precio, cantidad, transaccionid) VALUES(?,?,?,?,?)";
					$arrData = array($this->intIdUsuario, 
									$producto['idproducto'],
									$producto['precio'],
									$producto['cantidad'],
									$this->intIdTransaccion
								);
					$request_insert = $this->con->insert($sql_insert, $arrData);
				}
			}
		}

		public function getPedido(int $idpedido)
		{
			$this->con = new Mysql();
			$request = array();
			$sql = "SELECT p.idpedido,
							 p.referenciacobro,
							 p.idtransaccionpaypal,
							 p.personaid,
							 p.costo_envio,
							 p.fecha,
							 p.monto,
							 t.tipopago,
							 p.direccion_envio,
							 p.status
						FROM pedido p
						INNER JOIN tipopago t
						ON p.tipopagoid = t.idtipopago
						WHERE p.idpedido = $idpedido";
			$requestPedido = $this->con->select($sql);
			if (count($requestPedido) > 0) 
			{
				$sql_detalle = "SELECT p.idproducto,
								p.nombre as producto,
								d.precio,
								d.cantidad
						FROM detalle_pedido d
						INNER JOIN producto p
						ON d.productoid = p.idproducto
						WHERE d.pedidoid = $idpedido";
				$requestProducto = $this->con->select_all($sql_detalle);

				$request = array('orden' => $requestPedido,
								'detalle' => $requestProducto
								);
			}
			return $request;
		}

		public function setSuscripcion(string $nombre, string $email)
		{
			$this->con = new Mysql();
			$sql = "SELECT nombre, email FROM suscripcion WHERE email = '{$email}'";
			$request = $this->con->select_all($sql);			
			if (empty($request)) {
				$query_insert = "INSERT INTO suscripcion(nombre, email) VALUES(?,?)";
				$arrData = array($nombre, $email);
				$request_insert = $this->con->insert($query_insert, $arrData);
				$return = $request_insert;
			}else{
				$return = false;
			}
			return $return;
		}

		public function setContacto(string $nombre, string $email, string $mensaje, string $ip, string $dispositivo, string $useragent)
		{
			$this->con = new Mysql();
			$sql = "INSERT INTO contacto(nombre, email, mensaje, ip, dispositivo, useragent)
							VALUES(?,?,?,?,?,?)";
			$arrData = array($nombre, $email, $mensaje, $ip, $dispositivo, $useragent);
			$request_insert = $this->con->insert($sql, $arrData);
			return $request_insert;
		}
	}

?>