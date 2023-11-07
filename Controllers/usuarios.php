<?php 
	class usuarios extends Controllers{
		
		public function __construct(){

			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
			}
			getPermisos(2);
		}

		public function usuarios(){
			if(empty($_SESSION['permisosMod']['r'])){
				header('Location: '.base_url().'/dashboard');
			}
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "USUARIOS <small>Tienda Virtual</small>";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "functions_usuarios.js";

			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if ($_POST){
				if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus'])){
					
					$arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');
				}else{

					$intIdUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = intval(strClean($_POST['txtIdentificacion']));
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intIdRol = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));

					if ($intIdUsuario == 0){
						$option = 1;
						$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);
						$request_user = $this->model->insertUsuario($strIdentificacion, $strNombre, $strApellido, $intTelefono, $strEmail, $strPassword, $intIdRol, $intStatus);
					}else{
						$option = 2;
						$strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);
						$request_user = $this->model->updateUsuario($intIdUsuario, $strIdentificacion, $strNombre, $strApellido, $intTelefono, $strEmail, $strPassword, $intIdRol, $intStatus);
					}

					if ($request_user === 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! El email o la identificación ya existe, ingrese otro.');
					}else if($request_user > 0){
						if ($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
						}
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
					}
				}

				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuarios(){
			$arrData = $this->model->selectUsuarios();

			for($i=0; $i<count($arrData); $i++){ 
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				if($arrData[$i]['estado'] == 1){
					# code...
					$arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
				}else{
					$arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onclick="fntViewUsuario('.$arrData[$i]['id_usuario'].')" title="Ver Usuario"><i class="far fa-eye"></i></button>';
				}
				if($_SESSION['permisosMod']['u']){
					if(($_SESSION['idUser'] == 1 AND $_SESSION['userData']['id_rol'] == 1) || ($_SESSION['userData']['id_rol'] == 1 AND $arrData[$i]['id_rol'] != 1)){
						$btnEdit ='<button class="btn btn-primary btn-sm btnEditUsuario" onclick="fntEditUsuario('.$arrData[$i]['id_usuario'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
					}else{
						$btnEdit ='<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';
					}
				}
				if($_SESSION['permisosMod']['d']){
					if(($_SESSION['idUser'] == 1 AND $_SESSION['userData']['id_rol'] == 1) || ($_SESSION['userData']['id_rol'] == 1 AND $arrData[$i]['id_rol'] != 1) AND ($_SESSION['userData']['id_usuario'] != $arrData[$i]['id_usuario'])){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onclick="fntDelUsuario('.$arrData[$i]['id_usuario'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
					}else{
						$btnDelete ='<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-trash-alt"></i></button>';	
					}
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
 			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getUsuario(int $idUsuario){
			$intIdUsuario = intval($idUsuario);

			if ($intIdUsuario > 0){
				$arrData = $this->model->selectUsuario($intIdUsuario);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delUsuario(){
			if ($_POST){
				$intIdUsuario = intval($_POST['idUsuario']);
				$requestDelete = $this->model->deleteUsuario($intIdUsuario);

				if ($requestDelete){
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
 ?>