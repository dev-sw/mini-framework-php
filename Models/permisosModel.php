<?php 
	class permisosModel extends mysql{
		public $intIdRol;
		public $intIdPermiso;
		public $intRolId;
		public $intModuloId;
		public $r;
		public $w;
		public $u;
		public $d;

		public function __construct(){
			//echo "Mensaje desde el modelo home";
			parent:: __construct();
		}

		public function selectRol(int $idrol){
			$this->intIdRol = $idrol;

			$sql = "SELECT * FROM rol WHERE id_rol = $this->intIdRol";
			$request = $this->select($sql);
			return $request;
		}

		public function selectModulos(){
			$sql = "SELECT * FROM modulo WHERE estado != 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectPermisosRol(int $idrol){
			$this->intRolId = $idrol;
			$sql = "SELECT * FROM permisos WHERE rol_id = $this->intRolId";
			$request = $this->select_all($sql);
			return $request;
		}

		public function deletePermisos(int $idrol){
			$this->intRolId = $idrol;
			$sql = "DELETE FROM permisos WHERE rol_id = $this->intRolId";
			$request = $this->delete($sql);
			return $request;
		}

		public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d){
			$this->intRolId = $idrol;
			$this->intModuloId = $idmodulo;
			$this->r = $r;
			$this->w = $w;
			$this->u = $u;
			$this->d = $d;
			$query_insert = "INSERT INTO permisos (rol_id, modulo_id, r, w, u, d) VALUES (?,?,?,?,?,?)";
			$arrData = array($this->intRolId, $this->intModuloId, $this->r, $this->w, $this->u, $this->d);
			$request_insert = $this->insert($query_insert, $arrData);
			return $request_insert;
		}

		public function permisosModulo(int $idrol){
			$this->intRolId = $idrol;

			$sql = "SELECT p.rol_id, p.modulo_id, m.nombre AS modulo, p.r, p.w, p.u, p.d FROM permisos AS p INNER JOIN modulo AS m ON p.modulo_id = m.id_modulo WHERE p.rol_id = $this->intRolId";
			$request = $this->select_all($sql);
			$arrPermisos = array();
			
			for($i=0; $i < count($request); $i++){ 
				$arrPermisos[$request[$i]['modulo_id']] = $request[$i];
			}
			return $arrPermisos;
		}
	}
 ?>