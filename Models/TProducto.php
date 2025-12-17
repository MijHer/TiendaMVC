<?php 

require_once("Libraries/Core/Mysql.php");

trait TProducto
{
	private $con;
	private $strCategoria;
	private $intIdcategoria;
	private $intIdProducto;
	private $strProducto;
	private $cant;
	private $option;
	private $strRuta;
	private $strRutaCategoria;

	public function getProductosT()
	{
		$this->con = new Mysql();

		$sql = "SELECT p.idproducto, 
		p.codigo, 
		p.nombre, 
		p.descripcion, 
		p.categoriaid, 
		c.nombre as categoria,
		p.precio,
		p.ruta, 
		p.stock
		FROM producto p
		INNER JOIN categoria c
		ON p.categoriaid = c.idcategoria ORDER BY p.idproducto desc LIMIT ".CANTPRODHOME;
		$request = $this->con->select_all($sql);
		if ( count($request) > 0) {
			for ($c=0; $c < count($request); $c++) { 
				$intIdProducto = $request[$c]['idproducto'];
				$sqlImg = "SELECT img 
				FROM imagen 
				WHERE productoid = $intIdProducto";
				$arrImg = $this->con->select_all($sqlImg);
				if ($arrImg > 0) {
					for ($i=0; $i < count($arrImg); $i++) { 
						$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
					}
				}
				$request[$c]['images'] = $arrImg;
			}
		}
		return $request;
	}

	public function getProductosPage($desde, $porpagina)
	{
		$this->con = new Mysql();

		$sql = "SELECT p.idproducto, 
		p.codigo, 
		p.nombre, 
		p.descripcion, 
		p.categoriaid, 
		c.nombre as categoria,
		p.precio,
		p.ruta, 
		p.stock
		FROM producto p
		INNER JOIN categoria c
		ON p.categoriaid = c.idcategoria ORDER BY p.idproducto desc LIMIT $desde,$porpagina";
		$request = $this->con->select_all($sql);
		if ( count($request) > 0) {
			for ($c=0; $c < count($request); $c++) { 
				$intIdProducto = $request[$c]['idproducto'];
				$sqlImg = "SELECT img 
				FROM imagen 
				WHERE productoid = $intIdProducto";
				$arrImg = $this->con->select_all($sqlImg);
				if ($arrImg > 0) {
					for ($i=0; $i < count($arrImg); $i++) { 
						$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
					}
				}
				$request[$c]['images'] = $arrImg;
			}
		}
		return $request;
	}

	public function getProductosCategoriaT(int $idcategoria, string $ruta, $desde = NULL, $porpagina = NULL)
	{		
		$this->intIdcategoria = $idcategoria;
		$this->strRuta = $ruta;
		$where = "";
		if (is_numeric($desde) && is_numeric($porpagina)) {
			$where = "LIMIT ".$desde.",".$porpagina;
		}

		$this->con = new Mysql();
		$sql_cat = "SELECT idcategoria, nombre, ruta FROM categoria WHERE idcategoria = '{$this->intIdcategoria}' ";
		$request = $this->con->select($sql_cat);
		
		if (!empty($request)) 
		{
			$this->strCategoria = $request['nombre'];
			$this->strRutaCategoria = $request['ruta'];
			$sql = "SELECT p.idproducto, 
							p.codigo, 
							p.nombre, 
							p.descripcion, 
							p.categoriaid, 
							c.nombre as categoria, 
							p.precio, 
							p.ruta,
							p.stock
							FROM producto p
							INNER JOIN categoria c
							ON p.categoriaid = c.idcategoria 
							WHERE p.categoriaid = $this->intIdcategoria AND c.ruta = '{$this->strRuta}'
							ORDER BY p.idproducto ".$where;
			$request = $this->con->select_all($sql);

			if (!empty($request)) 
			{
				for ($c=0; $c < count($request); $c++) { 
					$intIdProducto = $request[$c]['idproducto'];
					$sqlImg = "SELECT img 
					FROM imagen 
					WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if ($arrImg > 0) {
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}
					$request[$c]['images'] = $arrImg;
				}
			}
			$request = array('idcategoria' => $this->intIdcategoria,
								'ruta' => $this->strRutaCategoria,
								'categoria' => $this->strCategoria,
								'productos' => $request
								);
		}
		return $request;
	}

	/*public function getProductosCategoriaPage(int $idcategoria, string $ruta, $desde, $porpagina)
	{		
		$this->intIdcategoria = $idcategoria;
		$this->strRuta = $ruta;

		$this->con = new Mysql();
		$sql_cat = "SELECT idcategoria, nombre FROM categoria WHERE idcategoria = '{$this->intIdcategoria}' LIMIT $desde,$porpagina";
		$request = $this->con->select($sql_cat);
		
		if (!empty($request)) 
		{
			$this->strCategoria = $request['nombre'];
			$sql = "SELECT p.idproducto, 
							p.codigo, 
							p.nombre, 
							p.descripcion, 
							p.categoriaid, 
							c.nombre as categoria, 
							p.precio, 
							p.ruta,
							p.stock
							FROM producto p
							INNER JOIN categoria c
							ON p.categoriaid = c.idcategoria 
							WHERE p.categoriaid = $this->intIdcategoria AND c.ruta = '{$this->strRuta}'";
			$request = $this->con->select_all($sql);

			if (!empty($request)) 
			{
				for ($c=0; $c < count($request); $c++) { 
					$intIdProducto = $request[$c]['idproducto'];
					$sqlImg = "SELECT img 
					FROM imagen 
					WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if ($arrImg > 0) {
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}
					$request[$c]['images'] = $arrImg;
				}
			}
			$request = array('idcategoria' => $this->intIdcategoria, 
								'categoria' => $this->strCategoria,
								'productos' => $request
								);
		}
		return $request;
	}*/

	public function getProductoT(int $idproducto, string $ruta)
	{		
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		$this->strRuta = $ruta;

		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.descorto,
						p.categoriaid,
						c.nombre as categoria,
						c.ruta as ruta_categoria,
						p.precio,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.idproducto = '{$this->intIdProducto}' AND p.ruta = '{$this->strRuta}' ";
				$request = $this->con->select($sql);
				if(!empty($request)){
					$intIdProducto = $request['idproducto'];
					$sqlImg = "SELECT img
							FROM imagen
							WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if(count($arrImg) > 0){
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}else{
						$arrImg[0]['url_image'] = media().'/images/uploads/product.png';
					}
					$request['images'] = $arrImg;
				}			
		return $request;
	}

	public function getProductosRandom(int $idcategoria, int $cant, string $option)
	{
		$this->intIdcategoria = $idcategoria;
		$this->cant = $cant;
		$this->option = $option;

		if($option == "r"){
			$this->option = " RAND() ";
		}else if($option == "a"){
			$this->option = " idproducto ASC ";
		}else{
			$this->option = " idproducto DESC ";
		}

		$this->con = new Mysql();
		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						p.precio,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.categoriaid = $this->intIdcategoria
				ORDER BY $this->option LIMIT  $this->cant ";
				$request = $this->con->select_all($sql);
				if(count($request) > 0){
					for ($c=0; $c < count($request) ; $c++) { 
						$intIdProducto = $request[$c]['idproducto'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
		return $request;

	}

	public function getProductoIDT(int $idproducto)
	{		
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;

		$sql = "SELECT p.idproducto,
						p.codigo,
						p.nombre,
						p.descripcion,
						p.categoriaid,
						c.nombre as categoria,
						c.ruta as ruta_categoria,
						p.precio,
						p.ruta,
						p.stock
				FROM producto p 
				INNER JOIN categoria c
				ON p.categoriaid = c.idcategoria
				WHERE p.idproducto = '{$this->intIdProducto}' ";
				$request = $this->con->select($sql);
				if(!empty($request)){
					$intIdProducto = $request['idproducto'];
					$sqlImg = "SELECT img
							FROM imagen
							WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if(count($arrImg) > 0){
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}else{
						$arrImg[0]['url_image'] = media().'/images/uploads/product.png';
					}
					$request['images'] = $arrImg;
				}			
		return $request;
	}

	public function cantProductos($categoria = NULL)
	{
		$where = "";
		if ($categoria != NULL) {
			$where = "AND categoriaid = ".$categoria;
		}
		$this->con = new Mysql();
		$sql = "SELECT count(*) as total_registro FROM producto  WHERE status = 1 ".$where;
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;
	}

	public function cantProdSearch($busqueda)
	{
		$this->con = new Mysql();

		$sql = "SELECT count(nombre) as total_registro FROM producto WHERE nombre LIKE '%$busqueda%' AND status = 1";
		$result_register = $this->con->select($sql);
		$total_registro = $result_register;
		return $total_registro;
	}

	public function getProdSearch($busqueda, $desde, $porpagina)
	{
		$this->con = new Mysql();

		$sql = "SELECT p.idproducto, 
		p.codigo, 
		p.nombre, 
		p.descripcion, 
		p.categoriaid, 
		c.nombre as categoria,
		p.precio,
		p.ruta, 
		p.stock
		FROM producto p
		INNER JOIN categoria c
		ON p.categoriaid = c.idcategoria 
		WHERE p.status = 1 AND p.nombre LIKE '%$busqueda%' ORDER BY p.idproducto desc LIMIT $desde,$porpagina";
		$request = $this->con->select_all($sql);
		if ( count($request) > 0) {
			for ($c=0; $c < count($request); $c++) { 
				$intIdProducto = $request[$c]['idproducto'];
				$sqlImg = "SELECT img 
				FROM imagen 
				WHERE productoid = $intIdProducto";
				$arrImg = $this->con->select_all($sqlImg);
				if ($arrImg > 0) {
					for ($i=0; $i < count($arrImg); $i++) { 
						$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
					}
				}
				$request[$c]['images'] = $arrImg;
			}
		}
		return $request;
	}
}

?>