<?php 
	class loginModel extends mysql{
		
		private $intIdUsuario;
		private $strEmail;
		private $strPassword;
		private $strToken;

		public function __construct(){
			//echo "Mensaje desde el modelo home";
			parent:: __construct();
		}

		public function loginUser(string $usuario, string $password){
			$this->strEmail = $usuario;
			$this->strPassword = $password;
			
			$sql = "SELECT id_usuario, estado FROM usuario WHERE email = '{$this->strEmail}' AND password = '{$this->strPassword}' AND estado != 0";
			$request = $this->select($sql);
			return $request;
		}

		public function sessionLogin(int $iduser){
			$this->intIdUsuario = $iduser;
			//BUSCAR ROLE
			$sql = "SELECT u.id_usuario, u.identificacion, u.nombres, u.apellidos, u.telefono, u.email, u.ruc, u.razon_social, u.direccion, r.id_rol, r.nombre, u.estado FROM usuario AS u INNER JOIN rol AS r ON u.rol_id = r.id_rol WHERE u.id_usuario = $this->intIdUsuario";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}

		public function getUserEmail(string $email){
			$this->strEmail = $email;

			$sql = "SELECT id_usuario, nombres, apellidos, estado FROM usuario WHERE email = '$this->strEmail' AND estado = 1";
			$request = $this->select($sql);
			return $request;
		}

		public function setTokenUser(int $idusuario, string $token){
			$this->intIdUsuario = $idusuario;
			$this->strToken = $token;

			$sql = "UPDATE usuario SET token = ? WHERE id_usuario = $this->intIdUsuario";
			$arrData = array($this->strToken);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function getUsuario(string $email, string $token){
			$this->strEmail = $email;
			$this->strToken = $token;

			$sql = "SELECT id_usuario FROM usuario WHERE email = '$this->strEmail' AND token = '$this->strToken' AND estado = 1";
			$request = $this->select($sql);
			return $request;
		}

		public function insertPassword(int $idusuario, string $password){
			$this->intIdUsuario = $idusuario;
			$this->strPassword = $password;

			$sql = "UPDATE usuario SET password = ?, token = ? WHERE id_usuario = $this->intIdUsuario";
			$arrData = array($this->strPassword,"");
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
 ?>