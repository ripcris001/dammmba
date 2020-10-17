<?php
	class system_home extends Core {
		public function _init($param){
			$this->templateSetter($this->checkSession());
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/home.html");
			$this->__data->page_title = '<p class="home-page-title">D A M M M B A</p><p class="home-page-sub-title">We live to serve the poor!</p>';
			$this->render();
		}
	}
?>