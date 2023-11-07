<?php 
	class rolesModel extends mysql{

		public $intIdrol;
		public $strRol;
		public $strDescripcion;
		public $intEstado;

		public function __construct(){
			//echo "Mensaje desde el modelo home";
			parent:: __construct();
		}

		public function selectRoles(){

			$whereAdmin = "";
			if($_SESSION['idUser'] != 1){
				$whereAdmin = "AND id_rol != 1";
			}
			#Extrae Roles
			$sql = "SELECT * FROM rol WHERE estado != 0 {$whereAdmin}";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectRol(int $idrol){
			# Buscar Rol
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM rol WHERE id_rol = $this->intIdrol";
			$request = $this->select($sql);
			return $request;
		}

		public function insertRol(string $rol, string $descripcion, int $estado){
			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intEstado = $estado;

			$sql = "SELECT * FROM rol WHERE nombre = '{$this->strRol}'";
			$request = $this->select_all($sql);

			if (empty($request)){
				$query_insert = "INSERT INTO rol(nombre, descripcion, estado) VALUES(?,?,?)";
				$arrData = array($this->strRol, $this->strDescripcion, $this->intEstado);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function updateRol(int $idRol, string $rol, string $descripcion, int $estado){
			
			$return = "";
			$this->intIdrol = $idRol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intEstado = $estado;

			$sql = "SELECT * FROM rol WHERE nombre = '$this->strRol' AND id_rol != $this->intIdrol";
			$request = $this->select_all($sql);

			if (empty($request)) {
				$sql = "UPDATE rol SET nombre = ?, descripcion = ?, estado = ? WHERE id_rol = $this->intIdrol";
				$arrData = array($this->strRol, $this->strDescripcion, $this->intEstado);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

		public function deleteRol(int $idrol){
			$this->intIdrol = $idrol;
			$this->intEstado = 0;

			$sql = "SELECT * FROM usuario WHERE rol_id = $this->intIdrol";
			$request = $this->select_all($sql);
			if (empty($request)) {
				$sql = "UPDATE rol SET estado = ? WHERE id_rol = $this->intIdrol";
				$arrData = array($this->intEstado);
				$request = $this->update($sql,$arrData);
				if ($request) {
					$request = 'ok';
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}
	}
 ?>