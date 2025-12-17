<?php 

	class Nosotros extends Controllers
	{
		public function __construct()
		{
			parent::__construct();
			session_start();

			getPermisos(MPAGINAS);
		}

		public function nosotros()
		{			
			$data['page_tag'] = "Tienda Virtual";
			$data['page_title'] = "Tienda Virtual";
			$data['page_name'] = "Tienda";
			$data['page'] = getPageRout('nosotros');
			if (empty($data['page'])) {
				header('Location:'.base_url());
			}
			$this->views->getView($this, 'nosotros', $data);
		}
	}
?>