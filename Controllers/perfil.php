<?php 
	class perfil extends Controllers{
		private $views;
		
		public function __construct(){

			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
			}
			getPermisos(2);
		}

        public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil de usuario";
			$data['page_name'] = "perfil";
			$data['page_functions_js'] = "functions_perfil.js";

			$this->views->getView($this,"perfil",$data);
		}

		public function setPerfil(){
			if($_POST){
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido'])){
					$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strIdentificacion = intval(strClean($_POST['txtIdentificacion']));
					$strNombre = strClean($_POST['txtNombre']);
					$strApellido = strClean($_POST['txtApellido']);
					$strTelefono = intval(strClean($_POST['txtTelefono']));
					
					$request_user = $this->model->updatePerfil($idUsuario, $strIdentificacion, $strNombre, $strApellido, $strTelefono);

					if($request_user){
						sessionUser($_SESSION['idUser']);
						$arrResponse = array("status" => true, "msg" => "Datos actualizados correctamente.");
					}else{
						$arrResponse = array("status" => false, "msg" => "No es posible actualizar los datos.");
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setDatosSesion(){
			if($_POST){
				$strPassword = "";
				$idUsuario = $_SESSION['idUser'];
				$intEstado = intval(strClean($_POST['listEstado']));
				
				if(!empty($_POST['txtPassword'])){
					$strPassword = hash("SHA256",$_POST['txtPassword']);
				}

				$request_dataSession = $this->model->updateDataSession($idUsuario, $strPassword, $intEstado);

				if($request_dataSession){
					sessionUser($_SESSION['idUser']);
					$arrResponse = array('status' => true, 'msg' => "Datos de sesión actualizados correctamente.");
				}else{
					$arrResponse = array('status' => false, 'msg' => "No es posible actualizar los datos.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
 ?>