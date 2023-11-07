<?php 
	class perfilModel extends mysql{
		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $strTelefono;
		private $strPassword;
		private $intEstado;
		
		public function __construct(){
			parent:: __construct();
		}

		public function updatePerfil(int $idUsuario, string $identificacion, string $nombre, string $apellido, string $telefono){
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strTelefono = $telefono;

			$sql = "UPDATE usuario SET identificacion=?, nombres=?, apellidos=?, telefono=? WHERE id_usuario = $this->intIdUsuario";
			$arrData = array($this->strIdentificacion, $this->strNombre, $this->strApellido, $this->strTelefono);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function updateDataSession(int $idUsuario, string $password, int $estado){
			$this->intIdUsuario = $idUsuario;
			$this->strPassword = $password;
			$this->intEstado = $estado;

			if($this->strPassword != ""){
				$sql = "UPDATE usuario SET password=?, estado=? WHERE id_usuario = $this->intIdUsuario";
				$arrData = array($this->strPassword, $this->intEstado);
			}else{
				$sql = "UPDATE usuario SET estado=? WHERE id_usuario = $this->intIdUsuario";
				$arrData = array($this->intEstado);
			}
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
 ?>