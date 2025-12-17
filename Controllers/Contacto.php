<?php
	
	class Contacto extends Controllers
	{
		
		public function __construct()
		{
			parent::__construct();
			session_start();

			getPermisos(MPAGINAS);
		}

		public function contacto()
		{
			$data['page_tag'] = "Tienda Virtual";
			$data['page_title'] = "Contacto";
			$data['page_name'] = "contacto";
			$data['page'] = getPageRout('contacto');
			if (empty($data['page'])) {
				header('Location:'.base_url());
			}			
			$this->views->getView($this, 'contacto', $data);
		}
	}

?>