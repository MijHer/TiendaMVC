<?php 
	
	class Mysql extends Conexion
	{
		private $conexion;
		private $strquery;
		private $arrValues;
		
		function __construct()
		{
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
		}

		//INSERTAR UN REGISTRO
		public function insert(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrValues = $arrValues;
			$insert = $this->conexion->prepare($this->strquery);
			$resInsert = $insert->execute($this->arrValues);
			if ($resInsert) {
				$lastInsert = $this->conexion->lastInsertId();
			}else{
				$lastInsert = 0;
			}
			return $lastInsert;
		}

		//BUSCAR UN REGISTRO
		public function select(string $query)
		{
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$result->execute();
			$data = $result->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		//BUSCAR TODO LOS REGISTROS		
		public function select_all(string $query)
		{
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$result->execute();
			$data = $result->fetchall(PDO::FETCH_ASSOC);
			return $data;
		}

		//ACTUALIZAR REGISTRO
		public function update(string $query, array $arrValues)
		{			
			$this->strquery = $query;
			$this->arrValues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrValues);
			return $resExecute;
		}

		//BORRAR UN REGISTRO
		public function delete(string $query)
		{
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$delete = $result->execute();
			return $delete;
		}
	}

 ?>