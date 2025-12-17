<?php 

	class Categorias extends Controllers
	{
		public function __construct()
		{
			parent::__construct();
			//session_start();
			sessionStart();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(6); // ESTO SE USA PARA EXTRAER LOS PERMISOS DEL MODULO QUE ESTA DE ACUERDO A LA BASE DE DATOS
		}

		public function Categorias()
		{
			if (empty($_SESSION['permisosMod']['r'])) 
			{
				header('location:'.base_url().'/dashboard');
			}
				$data['page_tag'] = "Categorias";
				$data['page_title'] = "Categoria tienda virtual";
				$data['page_name'] = "categorias";
				$data['page_functions_js'] = "functions_categorias.js";
				$this->views->getView($this, 'categorias', $data);
		}

		public function setCategoria()
		{
			if ($_POST) 
			{	
					$intIdCategoria = intval($_POST['idCategoria']);
					$strCategoria = strClean($_POST['txtNombre']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$ruta = strtolower(clear_cadena($strCategoria));
					$ruta = str_replace(" ", "-", $ruta);
					$intStatus = intval($_POST['listStatus']);
					
				if ($strCategoria == '' || $strDescripcion == '' || $intStatus == '' ) {
					$arrResponse = array('status' => false, 'msg' => 'Todo los campos son obligatorios');
				}else{
					$foto = $_FILES['foto'];
					$nombre_foto = $foto['name'];
					$type = $foto['type'];
					$url_temp = $foto['tmp_name'];
					$imgPortada = 'portada_categoria.png';
					$request_categoria = "";

					if ($nombre_foto != '') {
						$imgPortada = 'img_'.md5(date('d-m-Y H:i:s')).'.jpg';
					}

					if ($intIdCategoria == 0) 
					{
						//crear
						if ($_SESSION['permisosMod']['w']) 
						{
							$request_categoria = $this->model->insertCatergoria($strCategoria,$strDescripcion,$imgPortada,$ruta,$intStatus);
							$option = 1;
						}						
						
					}else{
						//actualizar
						if ($_SESSION['permisosMod']['u']) 
						{
							if ($nombre_foto == '') {
								if ($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0) {
									$imgPortada = $_POST['foto_actual'];
								}
							}
							$request_categoria = $this->model->updateCatergoria($intIdCategoria,$strCategoria,$strDescripcion,$imgPortada,$ruta,$intStatus);
							$option = 2;
						}						
					}

					if ($request_categoria > 0) 
					{
						if ($option == 1) {
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
							if ($nombre_foto != '') {
								uploadImage($foto,$imgPortada);
							}
						}else{
							$arrResponse = array('status' =>true, 'msg' => 'Datos actualizados correctamente');
							if ($nombre_foto != '') {
								uploadImage($foto,$imgPortada);
							}
							if(($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png') 
								|| ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png')){
								deleteFile($_POST['foto_actual']);
							}
						}						
					}else if($request_categoria = 'exist'){
						$arrResponse = array('status' =>false, 'msg' => '¡Atencion!. La categoria ya existe');
					}else{
						$arrResponse = array('status' =>false, 'msg' => 'No es posible almacenar datos');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCategorias()
		{
			if($_SESSION['permisosMod']['r'])
			{

				$arrData = $this->model->selectCategorias();

				for ($i=0; $i < count($arrData); $i++) 
				{ 
					$btnView = "";
					$btnEdit = "";
					$btnDelete = "";

					$arrData[$i]['status'] = $arrData[$i]['status'] == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
				
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idcategoria'].')" title="Ver categoría"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo('.$arrData[$i]['idcategoria'].')" title="Editar categoría"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idcategoria'].')" title="Eliminar categoría"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = $btnView.' '.$btnEdit.' '.$btnDelete;
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCategoria(int $idcategoria)
		{
			if ($_SESSION['permisosMod']['r']) 
			{
				$intIdCategoria = intval($idcategoria);
				if ($intIdCategoria > 0) 
				{
					$arrData = $this->model->selectCategoria($intIdCategoria);
					 if (empty($arrData)) 
					 {
					 	$arrResponse = array('status' => false, 'msg' => 'Datos no encontrado');				 	
					 }else{
					 	$arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
					 	$arrResponse = array('status' => true, 'data' => $arrData);
					 }
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); 
				}
			}
			die();
		}

		public function delCategoria()
		{
			if ($_POST) 
			{
				if($_SESSION['permisosMod']['d']){

					$intIdCategoria = intval($_POST['idCategoria'] );
					$requestDelete = $this->model->deleteCategoria($intIdCategoria);

					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la categoría');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una categoría con productos asociados.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la categoría.');
					}
				}
				
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getSelectCategorias()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectCategorias();

			if (count($arrData) > 0)
			{
				for ($i=0; $i < count($arrData); $i++) {
					if ($arrData[$i]['status'] == 1) {
						$htmlOptions .= '<option value="'.$arrData[$i]['idcategoria'].'" >'.$arrData[$i]['nombre'].'</option>';
					}
				}				
			}
			echo $htmlOptions;
			die();
		}
	}
?>