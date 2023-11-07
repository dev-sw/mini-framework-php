<?php 
	class roles extends Controllers{

		public function __construct(){

			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
			}
			getPermisos(2);
		}

		public function roles(){
			if(empty($_SESSION['permisosMod']['r'])){
				header('Location: '.base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Roles Usuario";
			$data['page_name'] = "rol_usuario";
			$data['page_functions_js'] = "functions_roles.js";
			$data['page_title'] = "ROLES USUARIOS <small>Tienda Virtual</small>";
			$this->views->getView($this,"roles",$data);
		}

		public function getRoles(){
			
			$arrData = $this->model->selectRoles();

			for($i=0; $i<count($arrData); $i++){ 
				$btnPermisos = '';
				$btnEdit = '';
				$btnDelete = '';

				if ($arrData[$i]['estado'] == 1) {
	
					$arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
				}else{
					$arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				if($_SESSION['permisosMod']['u']){
					$btnPermisos = '<button class="btn btn-secondary btn-sm btnPermisosRol" onclick="fntPermisos('.$arrData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key"></i></button>';
					$btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" onclick="fntEditRol('.$arrData[$i]['id_rol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onclick="fntDelRol('.$arrData[$i]['id_rol'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
				}

				$arrData[$i]['options'] = '<div class="text-center">'.$btnPermisos.' '.$btnEdit.' '.$btnDelete.'</div>';
 			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getSelectRoles(){
			$htmlOptions = "";
			$arrData = $this->model->selectRoles();
			if (count($arrData) > 0){
				for ($i=0; $i < count($arrData); $i++){
					if ($arrData[$i]['estado'] == 1){
						$htmlOptions .= '<option value="'.$arrData[$i]['id_rol'].'">'.$arrData[$i]['nombre'].'</option>';
					} 
				}
			}
			echo $htmlOptions;
			die();
		}

		public function getRol(int $idrol){
			$intIdrol = intval(strClean($idrol));

			if ($intIdrol > 0) {
				$arrData = $this->model->selectRol($intIdrol);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setRol(){
			
			$intIdrol = intval($_POST["idRol"]);
			$strRol = strClean($_POST["txtNombre"]);
			$strDescripcion = strClean($_POST["txtDescripcion"]);
			$intEstado = intval($_POST["listStatus"]);

			if ($intIdrol == 0) {
				// Crear
				$request_rol = $this->model->insertRol($strRol, $strDescripcion, $intEstado);
				$option = 1;
			}else{
				// Actualizar
				$request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescripcion, $intEstado);
				$option = 2;
			}

			if ($request_rol > 0){
				if ($option == 1) {
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				}else{
					$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
				}
			}else if ($request_rol == 'exist'){
				
				$arrResponse = array('status' => false, 'msg' => '¡Atención! El rol ya existe.');
			}else{
				
				$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delRol(){

			if ($_POST){
				$intIdrol = intval($_POST['idrol']);
				$requestDelete = $this->model->deleteRol($intIdrol);

				if ($requestDelete == 'ok'){
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
				}else if ($requestDelete == 'exist'){
					$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un rol asociado a usuarios.');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
?>