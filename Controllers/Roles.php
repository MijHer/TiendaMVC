<?php 
	
	class Roles extends Controllers
	{		
		public function __construct()
		{	
			//sessionStart();					
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}

			getPermisos(2);
		}

		public function Roles()
		{
			if (empty($_SESSION['permisosMod']['r'])) {
				header('location:'.base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Roles de Usuarios";
			$data['page_title'] = "rol_usuario";
			$data['page_name'] = "Roles_usuarios";
			$data['page_functions_js'] = "functions_roles.js";
			$this->views->getView($this, 'roles', $data);
		}

		public function getRoles()
		{
			if ($_SESSION['permisosMod']['r']) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectRoles();
				for ($i = 0; $i < count($arrData); $i++) {
					
			    $arrData[$i]['status'] = $arrData[$i]['status'] == 1 
			        ? '<span class="badge badge-success">Activo</span>' 
			        : '<span class="badge badge-danger">Inactivo</span>';			        

			        if ($_SESSION['permisosMod']['u']) {
			        	$btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['idrol'].')" title="Permisos"><i class="fa fa-solid fa-key"></i></button>';
			        	$btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['idrol'].')" title="Editar"><i class="fa fa-solid fa-pencil"></i></button>';
			        }

			        if ($_SESSION['permisosMod']['d']) {
			        	$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrol'].')" title="Eliminar"><i class="fa fa-solid fa-trash"></i></button>';
			        }


			    	$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.' </div>';
				}
						
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getRol(int $idrol)
		{
			if ($_SESSION['permisosMod']['r']) {
				$intIdrol = intval(strClean($idrol));
				if ($intIdrol > 0) 
				{
					$arrData = $this->model->selectRol($intIdrol);
					if (empty($arrData)) 
					{
						$arrResponse = array('status' => false, 'msg' => 'No existe registro');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);				
				}
			}			
			die();
		}

		public function setRol()
		{
			$intIdrol = intval($_POST['idRol']);
			$strRol =  strClean($_POST['txtNombre']);
			$strDescipcion = strClean($_POST['txtDescripcion']);
			$intStatus = intval($_POST['listStatus']);
			$request_rol = "";
			if($intIdrol == 0)
			{
				//Crear
				if ($_SESSION['permisosMod']['w']) {
					$request_rol = $this->model->insertRol($strRol, $strDescipcion,$intStatus);
					$option = 1;
				}				
			}else{
				//Actualizar
				if ($_SESSION['permisosMod']['u']) {
					$request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescipcion, $intStatus);
					$option = 2;
				}				
			}

			if(intval($request_rol) > 0 )
			{
				if($option == 1)
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				}else{
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				}
			}else if($request_rol == 'exist'){
				
				$arrResponse = array('status' => false, 'msg' => '¡Atención! El Rol ya existe.');
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delRol()
		{
			if ($_POST) {
				if ($_SESSION['permisosMod']['d']) {
					$intIdrol = intval($_POST['idrol']);
					$requestDelete = $this->model->deleteRol($intIdrol);
					if ($requestDelete == 'ok') {
						$arrResponse = array('status' => true, 'msg' => 'Los datos se elminarion');
					}else if ($requestDelete == 'exist') {
						$arrResponse = array('status' => false, 'msg' => 'No se puede eiminar un rol asociado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el rol');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
				}				
			}
			die();
		}

		public function getSelectRoles()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectRoles();
			if (count($arrData) > 0) 
			{
				for ($i=0; $i < count($arrData); $i++) {
					if ($arrData[$i]['status']) {
					 	$htmlOptions .= '<option value="'.$arrData[$i]['idrol'].'">'.$arrData[$i]['nombrerol'].'</option>';
					 }
				}
			}
			echo $htmlOptions;
			die();
		}
	}
 ?>