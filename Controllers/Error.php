<?php 

 	class Errors extends Controllers
	{
		public function __construct()
		{
			parent::__construct();
			getPermisos(MPAGINAS);
		}

		public function notFound()
		{
			$data['page_tag'] = "Tienda Virtual";
			$data['page_title'] = "Tienda Virtual";
			$data['page_name'] = "Tienda";
			$data['page'] = getPageRout('not-found');
			$this->views->getView($this, 'error', $data);
		}		

	}

	$notFound = new Errors();
	$notFound->notFound();
?>