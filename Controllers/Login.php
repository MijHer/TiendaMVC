<?php
	
	class Login extends Controllers
	{
		public function __construct()
		{
			//sessionStart();
			session_start();
			session_regenerate_id(true);
			if (isset($_SESSION['login'])) {
				header('location:'.base_url().'/dashboard');
			}
			parent::__construct();
		}

		public function login()
		{
			$data['page_tag'] = "Login";
			$data['page_title'] = "Pagina principal";
			$data['page_saludo'] = "Bienvenido";
			$data['page_name'] = "login";
			$data['functions_login_js'] = "functions_login.js";
			$this->views->getView($this, 'login', $data);
		}

		public function loginUser()
		{
			if ($_POST)
			{
				if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) 
				{
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{
					$strUsuario = strtolower(strClean($_POST['txtEmail']));
					$strPassword = hash("SHA256", $_POST['txtPassword']);
					$requestUser = $this->model->loginUser($strUsuario,$strPassword);

					if (empty($requestUser)) 
					{
						$arrResponse = array('status' => false, 'msg' => 'El usuario o contraseña es incorrecto');
					}else{
						$arrData = $requestUser;
						if ($arrData['status'] == 1) 
						{
							$_SESSION['idUser'] = $arrData['idpersona'];
							$_SESSION['login'] = true;
							$_SESSION['timeout'] = true;
							$_SESSION['inicio'] = time();

							$arrData = $this->model->sessionLogin($_SESSION['idUser']);
							sessionUser($_SESSION['idUser']);

							$arrResponse = array('status' =>true, 'msg' => 'ok');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'Usuario Inactivo');
						}
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function resetPass()
		{
			if ($_POST) 
			{
				/*error_reporting(0);*/
				if (empty($_POST['txtEmailReset'])) 
				{
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{
					$token = token();
					$strEmail = strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);

					if (empty($arrData)) 
					{
						$arrResponse = array('status' => false, 'msg' => 'Usuario no existe');
					}else{
						$idpersona = $arrData['idpersona'];
						$nombreUsuario = $arrData['nombres'].''.$arrData['apellidos'];

						$url_recovery = base_url() . '/login/confirmUser/' . urlencode($strEmail) . '/' . urlencode($token);
						$requestUpdate = $this->model->setTokenUser($idpersona, $token);

						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
												'email' => $strEmail,
												'asunto' => 'Recuperar Contraseña - '.NOMBRE_REMITENTE,
												'url_recovery' => $url_recovery);
						if ($requestUpdate) 
						{
							$sendEmail = sendEmail($dataUsuario, 'email_cambioPassword');

							if ($sendEmail) {
								$arrResponse = array('status' => true, 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña');
							}else{
								$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta mas tarde');
							}
						}else{
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta mas tarde');
						}
					}
				}
				sleep(3);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function confirmUser(string $params)
		{
			if (empty($params)) 
			{
				header('location:' .base_url());
			}else{

				$arrParams = explode(',', $params);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
				$arrResponse = $this->model->getUsuario($strEmail, $strToken);
				if (empty($arrResponse)) {
					header('location:'.base_url());
				}else{
					$data['page_tag'] = "Cambiar Contraseña";
					$data['page_title'] = "Cambiar Contraseña";
					$data['page_saludo'] = "Cambiar Contraseña";
					$data['page_name'] = "cambiar contraseña";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['idpersona'] = $arrResponse['idpersona'];
					$data['functions_login_js'] = "functions_login.js";
					$this->views->getView($this, 'cambiar_password', $data);
				}

			}
			die();
		}

		public function setPassword()
		{
			if (empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])  )
			{
				$arrResponse = array('status' => false, 'msg' => 'Erro de datos');
			}else{
				$intIdpersona = intval($_POST['idUsuario']) ;
				$strPassword = $_POST['txtPassword'];
				$strEmail = $_POST['txtEmail'];
				$strToken = $_POST['txtToken'];
				$strPasswordConfirm = $_POST['txtPasswordConfirm'];

				if ($strPassword != $strPasswordConfirm)
				{
					$arrResponse = array('status' => false, 'msg' => 'Las contraseña no coinciden');
				}else{
					$arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
					if (empty($arrResponseUser)) {
						$arrResponse = array('status' => false, 'msg' => 'Error de datos');
					}else{
						$strPassword = hash("SHA256", $strPassword);
						$requestPass = $this->model->insertPassword($intIdpersona, $strPassword);

						if ($requestPass) {
							$arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con exito');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'No es posible actualizar contraseña intente mas tarde');
						}
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}
			
		}
	}
?>