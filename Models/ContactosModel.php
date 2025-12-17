<?php 

	class ContactosModel extends Mysql
	{
		private $idMensaje;
		public function __construct()
		{
			parent::__construct();
		}

		public function selectContactos()
		{
			$sql = "SELECT id, nombre, email, DATE_FORMAT(datecreated, '%d-%m-%Y') AS fecha FROM contacto ORDER BY id DESC";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectMensaje(int $idmensaje)
		{
			$this->idMensaje = $idmensaje;
			$sql = "SELECT id, nombre, email, mensaje, DATE_FORMAT(datecreated, '%d-%m- %Y') as fecha  FROM contacto WHERE id = $this->idMensaje";
			$request = $this->select($sql);
			return $request;
		}
	}

?>