<?php 
	require_once("Config/config.php");
	require_once("Helpers/helpers.php");
	
	$url = isset($_GET['url'])?$_GET['url']:'home/home';
	$arrUrl = explode("/", $url);
	$controller = $arrUrl[0];
	$method = $arrUrl[0];
	$params = "";

	if (isset($arrUrl[1])){
		if ($arrUrl[1] != ""){
			$method = $arrUrl[1];
		}
	}
	if (isset($arrUrl[2])){
		if ($arrUrl[2] != ""){
			for ($i=2; $i < count($arrUrl); $i++) { 
				# code...
				$params .= $arrUrl[$i].',';
			}
			$params = trim($params,',');
		}
	}

	require_once("Libraries/Core/autoLoad.php");
	require_once("Libraries/Core/load.php");

 ?> 