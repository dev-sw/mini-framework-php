<?php 
	//define("BASE_URL","http://localhost/Sistema_Logistico/");
	const BASE_URL = "http://localhost/tienda_virtual";

	//Zona Horaria
	date_default_timezone_set('America/Bogota');

	//const LIBS = "Libraries/";
	//const VIEWS = "Views/";
	const DB_HOST = "mysql"; //"localhost"; //"127.0.0.1";
	const DB_NAME = "db_tiendavirtual";
	const DB_USER = "root";
	const DB_PASSWORD = "074-lambayeque";
	const DB_CHARSET = "charset-utf8";

	//Delimitadores decimal y millar Ej.24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "S/.";	

	//Datos envio de correo
	const NOMBRE_REMITENTE = "Tienda Virtual";
	const EMAIL_REMITENTE = "omar.rivash@gmail.com";

	const NOMBRE_EMPRESA = "Tienda Virtual";
	const WEB_EMPRESA = "www.abelosh.com";
 ?>