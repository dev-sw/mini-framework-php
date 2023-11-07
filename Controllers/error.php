<?php 
	class errors extends Controllers{
		public function __construct(){
			parent::__construct();
		}
		public function notFound(){
			$this->views->getView($this,"error");
		}
	}
	$notFound = new errors();
	$notFound->notFound();
 ?>