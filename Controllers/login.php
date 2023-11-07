<?php 
	class login extends Controllers{
		
		public function __construct(){
			
			session_start();
			if(isset($_SESSION['login'])){
				header('Location: '.base_url().'/dashboard');
			}

			parent::__construct();
		}
		
		public function login(){
			$data['page_tag'] = "Login - Tienda Virtual";
			$data['page_title'] = "Tienda Virtual";
			$data['page_name'] = "login";
			$data['page_functions_js'] = "functions_login.js";
			$this->views->getView($this,"login",$data);
		}

		public function loginUser(){
			//dep($_POST);
			if($_POST){
				if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
					$arrResponse = array("status" => false,'msg' => 'Error de datos');
				}else{
					$strUsuario = strtolower(strClean($_POST['txtEmail']));
					$strPassword = hash("SHA256",$_POST['txtPassword']);
					$requestUser = $this->model->loginUser($strUsuario, $strPassword);
					if(empty($requestUser)){
						$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña son incorrectos.');
					}else{
						$arrData = $requestUser;
						if($arrData['estado'] == 1){
							$_SESSION['idUser'] = $arrData['id_usuario'];
							$_SESSION['login'] = true;

							$arrData = $this->model->sessionLogin($_SESSION['idUser']);
							//$_SESSION['userData'] = $arrData;

							$arrResponse = array('status' => true, 'msg' => 'Sesión iniciada correctamente.');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'El usuario se encuentra inactivo.');
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function resetPass(){
			if($_POST){
				//error_reporting(0);

				if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{
					$strToken = token();
					$strEmail = strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);

					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'La dirección de correo electrónico no se encuentra registrada.');
					}else{
						$intIdUsuario = $arrData['id_usuario'];
						$requestUpdate = $this->model->setTokenUser($intIdUsuario,$strToken);

						if($requestUpdate){
							$strNombreUsuario = "{$arrData['nombres']} {$arrData['apellidos']}";
							$url_recovery = base_url()."/login/confirmUser/{$strEmail}/{$strToken}";

							$arrDataRecovery = array('nombreUsuario' => $strNombreUsuario, 'email' => $strEmail, 'asunto' => 'Recuperar cuenta - '.NOMBRE_REMITENTE, 'url_recovery' => $url_recovery);
							$request_send = sendEmail($arrDataRecovery, 'email_cambioPassword');
							
							if($request_send){
								$arrResponse = array('status' => true, 'msg' => 'Se ha enviado información a tu cuenta de correo para recuperar la contraseña');
							}else{
								$arrResponse = array('status' => false, 'msg' => 'Ocurrió un error durante el envío de información, inténtalo más tarde.');
							}
						}else{
							$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar token de recuperación de contraseña, inténtalo más tarde.');
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function confirmUser(string $params){

			if(empty($params)){
				header("Location: ".base_url());
			}else{
				$arrParams = explode(',', $params);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
				
				$arrResponse = $this->model->getUsuario($strEmail, $strToken);
				if(empty($arrResponse)){
					header('Location: '.base_url().'/login');
				}else{
					$data['page_tag'] = "Cambiar Contraseña";
					$data['page_name'] = "Cambiar_Contraseña";
					$data['page_title'] = "Cambiar Contraseña";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['idusuario'] = $arrResponse['id_usuario'];
					$data['page_functions_js'] = "functions_login.js";
					$this->views->getView($this,"cambiar_password",$data);
				}
			}
			die();			
		}

		public function setPassword(){
			if(empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])){
				$arrResponse = array('status' => false, 'msg' => 'Error de datos');
			}else{
				$intIdUsuario = intval($_POST['idUsuario']);
				$strEmail = strClean($_POST['txtEmail']);
				$strToken = strClean($_POST['txtToken']);
				$strPassword = $_POST['txtPassword'];
				$strPasswordConfirm = $_POST['txtPasswordConfirm'];

				if($strPassword != $strPasswordConfirm){
					$arrResponse = array('status' => false, 'msg' => 'Las contraseñas no coinciden.');
				}else{
					$arrResponseUser = $this->model->getUsuario($strEmail,$strToken);
					if(empty($arrResponseUser)){
						$arrResponse = array('status' => false, 'msg' => 'Error de datos.');
					}else{
						$strPassword = hash("SHA256", $strPassword);
						$requestPass = $this->model->insertPassword($intIdUsuario, $strPassword);

						if($requestPass){
							$arrResponse = array('status' => true, 'msg' => 'La contraseña fué actualizada correctamente.');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'Hubo un error al actualizar la contraseña, inténtelo más tarde.');
						}
					}
				}
			}
			sleep(3);
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
	}
 ?>