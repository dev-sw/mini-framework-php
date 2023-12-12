<?php 
	class permisos extends Controllers{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function getPermisosRol(int $idrol){
			$intRolId = intval($idrol);

			if ($intRolId > 0){
				$arrRol = $this->model->selectRol($intRolId);
				$arrModulos = $this->model->selectModulos();
				$arrPermisosRol = $this->model->selectPermisosRol($intRolId);

				$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
				$arrPermisoRol = array('id_rol' => $intRolId, 'rol' => $arrRol['nombre']);

				if (empty($arrPermisosRol)){
					for ($i=0; $i < count($arrModulos); $i++){ 
						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}else{
					for ($i=0; $i < count($arrModulos); $i++){ 
						$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
						if(isset($arrPermisosRol[$i])){
							$arrPermisos = array('r' => $arrPermisosRol[$i]['r'],
												 'w' => $arrPermisosRol[$i]['w'],
												 'u' => $arrPermisosRol[$i]['u'],
												 'd' => $arrPermisosRol[$i]['d']
												);
						}
						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}
				$arrPermisoRol['modulos'] = $arrModulos;
				$html = getmodal("modalPermisos", $arrPermisoRol);
				//dep($arrModulos);
			}
			die();
		}

		public function setPermisos(){
			if ($_POST){
				$intIdRol = intval($_POST['idrol']);
				$arrModulo = $_POST['modulos'];

				$this->model->deletePermisos($intIdRol);
				foreach ($arrModulo as $modulo){
					$intIdModulo = $modulo['id_modulo'];
					$r = empty($modulo['r']) ? 0 : 1;
					$w = empty($modulo['w']) ? 0 : 1;
					$u = empty($modulo['u']) ? 0 : 1;
					$d = empty($modulo['d']) ? 0 : 1;
					$requestPermiso = $this->model->insertPermisos($intIdRol, $intIdModulo, $r, $w, $u, $d);
				}

				if ($requestPermiso > 0){
					$arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente.');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'No es posible asignar los permisos.');
				}
				
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
 ?>