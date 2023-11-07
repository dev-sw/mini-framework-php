<?php 
	class usuariosModel extends mysql{
		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombres;
		private $strApellidos;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intRolId;
		private $intEstado;

		public function __construct(){
			parent:: __construct();
		}

		public function insertUsuario(string $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $idrol, int $estado){
			$this->strIdentificacion = $identificacion;
			$this->strNombres = $nombres;
			$this->strApellidos = $apellidos;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intRolId = $idrol;
			$this->intEstado = $estado;
			$return = 0;

			$sql = "SELECT * FROM usuario WHERE email = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->select_all($sql);

			if (empty($request)){
				$query_insert = "INSERT INTO usuario (identificacion, nombres, apellidos, telefono, email, password, rol_id, estado) VALUES (?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion, $this->strNombres, $this->strApellidos, $this->intTelefono, $this->strEmail, $this->strPassword, $this->intRolId, $this->intEstado);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = "exist";
			}

			return $return;
		}

		public function selectUsuarios(){
			$whereAdmin = "";

			if($_SESSION['idUser'] != 1){
				$whereAdmin = "AND u.id_usuario != 1";
			}
			
			$sql = "SELECT u.id_usuario, u.identificacion, u.nombres, u.apellidos, u.telefono, u.email, u.estado, r.id_rol, r.nombre FROM usuario AS u INNER JOIN rol AS r ON u.
			rol_id = r.id_rol WHERE u.estado != 0 {$whereAdmin}";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectUsuario(int $idusuario){
			$this->intIdUsuario = $idusuario;

			$sql = "SELECT u.id_usuario, u.identificacion, u.nombres, u.apellidos, u.telefono, u.email, u.ruc, u.razon_social, u.direccion, r.id_rol, r.nombre, u.estado, DATE_FORMAT(u.datecreated, '%d-%m-%Y') AS fechaRegistro FROM usuario AS u INNER JOIN rol AS r ON u.rol_id = r.id_rol WHERE u.id_usuario = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

		public function updateUsuario(int $idUsuario, string $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $idrol, int $estado){
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombres = $nombres;
			$this->strApellidos = $apellidos;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intRolId = $idrol;
			$this->intEstado = $estado;

			$sql = "SELECT * FROM usuario WHERE (email = '{$this->strEmail}' AND id_usuario != $this->intIdUsuario) OR (identificacion = '{$this->strIdentificacion}' AND id_usuario != $this->intIdUsuario)";
			$request = $this->select_all($sql);

			if (empty($request)){
				if ($this->strPassword != "") {
					$sql = "UPDATE usuario SET identificacion=?, nombres=?, apellidos=?, telefono=?, email=?, password=?, rol_id=?, estado=? WHERE id_usuario=$this->intIdUsuario";
					$arrData = array($this->strIdentificacion, $this->strNombres, $this->strApellidos, $this->intTelefono, $this->strEmail, $this->strPassword, $this->intRolId, $this->intEstado);
				}else{
					$sql = "UPDATE usuario SET identificacion=?, nombres=?, apellidos=?, telefono=?, email=?, rol_id=?, estado=? WHERE id_usuario=$this->intIdUsuario";
					$arrData = array($this->strIdentificacion, $this->strNombres, $this->strApellidos, $this->intTelefono, $this->strEmail, $this->intRolId, $this->intEstado);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

		public function deleteUsuario(int $idUsuario){
			$this->intIdUsuario = $idUsuario;
			$this->intEstado = 0;

			$sql = "UPDATE usuario SET estado = ? WHERE id_usuario = $this->intIdUsuario";
			$arrData = array($this->intEstado);
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
 ?>