<?php 

	class CategoriasModel extends Mysql
	{
		public $intIdCategoria;
		public $strCategoria;
		public $strDescripcion;
		public $strRuta;
		public $intStatus;
		public $strPortada;

		public function __construct()
		{
			parent::__construct();			
		}

		public function insertCatergoria(string $nombre, string $descripcion, string $portada, string $ruta, int $status)
		{
			$return = "";
			$this->strCategoria = $nombre;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->strRuta = $ruta;
			$this->intStatus = $status;

			$sql = "SELECT * from categoria WHERE nombre = '{$this->strCategoria}' ";
			$request = $this->select_all($sql);

			if (empty($request)) {
				$query_insert = "INSERT INTO categoria(nombre, descripcion, portada, ruta, status) VALUES(?,?,?,?,?)";
				$arrData = array($this->strCategoria,
									$this->strDescripcion,
									$this->strPortada,
									$this->strRuta,
									$this->intStatus);

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = 'exist';
			}
			return $return;
		}

		public function selectCategorias()
		{
			$sql = "SELECT * FROM categoria";
			$return = $this->select_all($sql);
			return $return;
		}

		public function selectCategoria(int $idcategoria)
		{
			$this->intIdCategoria = $idcategoria;
			$sql = "SELECT * FROM categoria WHERE idcategoria = $this->intIdCategoria ";
			$request = $this->select($sql);
			return $request;
		}

		public function updateCatergoria(int $idcategoria,string $categoria,string $descripcion,string $portada, string $ruta, int $status)
		{
			
 			$this->intIdCategoria = $idcategoria;
			$this->strCategoria = $categoria;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->strRuta = $ruta;
			$this->intStatus = $status;

			$sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}' AND idcategoria != $this->intIdCategoria ";
			$request = $this->select_all($sql);

			if (empty($request)) 
			{
				$sql = "UPDATE categoria set nombre=?, descripcion=?, portada=?, ruta=?, status=? WHERE idcategoria = $this->intIdCategoria ";
				$arrData = array($this->strCategoria,
									$this->strDescripcion,
									$this->strPortada,
									$this->strRuta,
									$this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = 'exist';
			}
			return $request;
		}

		public function deleteCategoria(int $idcategoria)
		{
			$this->intIdCategoria = $idcategoria;

			$sql = "SELECT * FROM producto WHERE categoriaid = $this->intIdCategoria";
			$request = $this->select_all($sql);

			if (empty($request)) 
			{
				$sql = "DELETE FROM categoria WHERE idcategoria = $this->intIdCategoria";
				$request = $this->delete($sql);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}

		public function getCategoriasFooter()
		{
			$sql = "SELECT idcategoria, nombre, descripcion, ruta, portada 
					FROM categoria 
					WHERE status = 1 AND idcategoria IN (".CAT_FOOTER.")";
			$request = $this->select_all($sql);
			if (count($request) > 0) {
				for ($c=0; $c < count($request); $c++) { 
					$request[$c]['portada'] = BASE_URL.'/Assets/images/uploads'.$request[$c]['portada'];
				}
			}
			return $request;
		}
	}
 ?>