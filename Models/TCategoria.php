<?php 
	
	require_once("Libraries/Core/Mysql.php");

	trait TCategoria
	{
		private $con;

		public function getCategoriasT(string $categorias)
		{
			$this->con = new Mysql();
			$sql = "SELECT idcategoria, nombre, descripcion, portada, ruta FROM categoria WHERE status = 1 AND idcategoria IN ($categorias)";
			$request = $this->con->select_all($sql);
			if (count($request) > 0) {
				for ($i=0; $i < count($request); $i++) 
				{ 
					$request[$i]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$i]['portada'];
				}
			}
			return $request;
		}

		public function getCategorias()
		{
			$this->con = new Mysql();
			$sql = "SELECT c.idcategoria, c.nombre, c.portada, c.ruta, count(p.categoriaid) AS cantidad
					FROM producto p
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE c.status = 1 
					GROUP BY p.categoriaid, c.idcategoria";
			$request = $this->con->select_all($sql);
			if (count($request) > 0) {
				for ($i=0; $i < count($request); $i++) 
				{ 
					$request[$i]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$i]['portada'];
				}
			}
			return $request;
		}		
	}
?>