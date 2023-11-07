<?php 
	class home extends Controllers{
		public function __construct(){
			parent::__construct();
		}
		public function home(){
			$data['page_id'] = 1;
			$data['page_tag'] = "Home";
			$data['page_title'] = "Página Principal";
			$data['page_name'] = "home";
			$data['page_content'] = "Loren jsflahl dlahlfha nlkhsfalhfñ ñanñfas afhjhlasdf ahflasñf añlhsfuahysjbf dfahuraufuv";
			$this->views->getView($this,"home",$data);
		}
	}
 ?>