<?php 
	class views{
		function getView($controller,$view,$data=""){
			$controller = get_class($controller);
			
			if($controller == "home"){
				$view = "Views/".$view.".php";
			}else{
				$view = "Views/".$controller."/".$view.".php";
			}
			require_once($view);
		}
	}

 ?>