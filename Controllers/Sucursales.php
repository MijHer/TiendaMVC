<?php 

	class Sucursales extends Controllers
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			getPermisos(MPAGINAS);
		}

		public function Sucursales()
		{
			$data['page_tag'] = "Tienda Virtual";
			$data['page_title'] = "Tienda Virtual";
			$data['page_name'] = "Tienda";
			$data['page'] = getPageRout('sucursales');
			if (empty($data['page'])) {
				header('Location:'.base_url());
			}
			$this->views->getView($this, 'sucursales', $data);
		}
	}

?>