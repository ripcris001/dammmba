<?php
	Class Themer extends Connection implements settings {
		public function buildTheme($data){
			$theme = new stdClass();
	    	// start defaults
	    	$theme->menu_collapsed = "nav-lock";
	    	$theme->menu_collapsed_main = "";
	    	$theme->menu_selection = "";
	    	$theme->menu_color = "";
	    	$theme->menu_color_gradient = 0;
	    	$theme->menu_color_style_overide = "";
	    	$theme->sidebar_mode = "";
	    	$theme->footer_color = "";
	    	$theme->navebar_color_content = "";
	    	$theme->navebar_color_top = "";
	    	$theme->footer_class = "";
	    	// end defaults
	    	if(isset($data->menu_selection)){
	    		switch ($data->menu_selection){
	    			case "square":
	    				$theme->menu_selection = "sidenav-active-square";
	    			break;
	    			case "round":
	    				$theme->menu_selection = "sidenav-active-rounded";
	    			break;
	    			case "normal":
	    				$theme->menu_selection = "";
	    			break;
	    			default:
	    				$theme->menu_selection = "";
	    			break;
	    		}
	    	}
	    	if(isset($data->menu_collapsed) && $data->menu_collapsed > 0){
	    		$theme->menu_collapsed = "nav-collapsed";
	    		$theme->menu_collapsed_main = "main-full";
	    	}
	    	if(isset($data->sidebar_mode)){
	    		if($data->sidebar_mode == 'light'){
	    			$theme->sidebar_mode = "sidenav-light";
	    		}else if($data->sidebar_mode == 'dark'){
	    			$theme->sidebar_mode = "sidenav-dark";
	    		}else{
	    			$theme->sidebar_mode = $data->sidebar_mode;
	    		}
	    	}
	    	if(isset($data->menu_color)){
	    		$theme->menu_color = $this->gradientColor($data->menu_color, "gradient-shadow");
	    	}
	    	if(isset($data->footer_color)){
	    		$theme->footer_color = $this->gradientColor($data->footer_color, 'gradient-shadow');
	    	}
	    	if(isset($data->navebar_color)){
	    		$theme->navebar_color_top = $this->gradientColor($data->navebar_color);
	    		$theme->navebar_color_content = $this->gradientColor($data->navebar_color, 'gradient-shadow');
	    	}
	    	return $theme;
	    }
	    public function gradientColor($data, $shadow = false){
	    	$color = '';
	    	$theme_shadow = "no-shadow";
	    	if($shadow){
	    		$theme_shadow = $shadow;
	    	}
	    	if(isset($data)){
	    		switch ($data){
					case "gradient-amber":
						$color = "gradient-45deg-amber-amber $theme_shadow ";
					break;
					case "gradient-indigo-blue":
						$color = "gradient-45deg-indigo-blue $theme_shadow";
					break;
					case "gradient-indigo-purple":
						$color = "gradient-45deg-indigo-purple $theme_shadow ";
					break;
					case "gradient-blue-indigo":
						$color = "gradient-45deg-blue-indigo $theme_shadow ";
					break;
					case "gradient-brown-brown":
						$color = "gradient-45deg-brown-brown $theme_shadow ";
					break;
					case "gradient-deep-purple-blue":
						$color = "gradient-45deg-deep-purple-blue $theme_shadow ";
					break;
					case "gradient-indigo-light-blue":
						$color = "gradient-45deg-indigo-light-blue $theme_shadow ";
					break;
					case "gradient-blue-grey-blue":
						$color = "gradient-45deg-blue-grey-blue $theme_shadow ";
					break;
					case "gradient-deep-orange-orange":
						$color = "gradient-45deg-deep-orange-orange $theme_shadow ";
					break;
					case "gradient-red-pink":
						$color = "gradient-45deg-red-pink $theme_shadow ";
					break;
					case "gradient-purple-deep-orange":
						$color = "gradient-45deg-purple-deep-orange $theme_shadow ";
					break;
					case "gradient-light-blue-cyan":
						$color = "gradient-45deg-light-blue-cyan $theme_shadow ";
					break;
					case "gradient-light-blue-teal":
						$color = "gradient-45deg-light-blue-teal $theme_shadow ";
					break;
					case "gradient-green-teal":
						$color = "gradient-45deg-green-teal $theme_shadow ";
					break;
					case "gradient-purple-amber":
						$color = "gradient-45deg-purple-amber $theme_shadow ";
					break;
					case "gradient-light-blue-indigo":
						$color = "gradient-45deg-light-blue-indigo $theme_shadow ";
					break;
					case "gradient-indigo-light-blue":
						$color = "gradient-45deg-indigo-light-blue $theme_shadow ";
					break;
					case "gradient-yellow-green":
						$color = "gradient-45deg-yellow-green $theme_shadow ";
					break;
					case "gradient-teal-cyan":
						$color = "gradient-45deg-teal-cyan $theme_shadow ";
					break;
					case "gradient-purple-light-blue":
						$color = "gradient-45deg-purple-light-blue $theme_shadow ";
					break;
					case "gradient-orange-deep-orange":
						$color = "gradient-45deg-orange-deep-orange $theme_shadow ";
					break;
					case "gradient-blue-grey-blue-grey":
						$color = "gradient-45deg-blue-grey-blue-grey $theme_shadow ";
					break;
					case "gradient-cyan-cyan":
						$color = "gradient-45deg-cyan-cyan $theme_shadow ";
					break;
					case "gradient-deep-purple-purple":
						$color = "gradient-45deg-deep-purple-purple $theme_shadow ";
					break;
					case "gradient-cyan-light-green":
						$color = "gradient-45deg-cyan-light-green $theme_shadow ";
					break;
					case "gradient-yellow-teal":
						$color = "gradient-45deg-yellow-teal $theme_shadow ";
					break;
					case "gradient-light-green-amber":
						$color = "gradient-45deg-light-green-amber $theme_shadow ";
					break;
					case "gradient-orange-amber":
						$color = "gradient-45deg-orange-amber $theme_shadow ";
					break;
					case "gradient-cyan-light-green":
						$color = "gradient-45deg-cyan-light-green $theme_shadow ";
					break;
					case "gradient-purple-pink":
						$color = "gradient-45deg-purple-pink $theme_shadow ";
					break;
					case "red":
						$color = "red $theme_shadow ";
					break;
					case "pink":
						$color = "pink $theme_shadow ";
					break;
					case "purple":
						$color = "purple $theme_shadow ";
					break;
					case "deep-purple":
						$color = "deep-purple $theme_shadow ";
					break;
					case "indigo":
						$color = "indigo $theme_shadow ";
					break;
					case "blue":
						$color = "blue $theme_shadow ";
					break;
					case "light-blue":
						$color = "light-blue $theme_shadow ";
					break;
					case "cyan":
						$color = "cyan $theme_shadow ";
					break;
					case "teal":
						$color = "teal $theme_shadow ";
					break;
					case "green":
						$color = "green $theme_shadow ";
					break;
					case "light-green":
						$color = "light-green $theme_shadow ";
					break;
					case "yellow":
						$color = "yellow $theme_shadow ";
					break;
					case "orange":
						$color = "orange $theme_shadow ";
					break;
					case "deep-orange":
						$color = "deep-orange $theme_shadow ";
					break;
					case "brown":
						$color = "brown $theme_shadow ";
					break;
					case "grey":
						$color = "grey $theme_shadow ";
					break;
				}	
	    	}
	    	return $color;
	    }
	    public function pluginlist($data = false){
	    	$plugin = new stdClass();
	    	$assetList = array();
	    	if ($handle = opendir(settings::d_path.settings::t_assets.'/app-assets/vendors')) {
			    while (false !== ($file = readdir($handle))) {
			    	$blacklist = array('.', '..', 'imagesloaded.pkgd.min.js');
			        if (!in_array($file, $blacklist)) {
						$handle1 = settings::d_path.settings::t_assets."/app-assets/vendors/$file";
						if(is_dir($handle1)){
							$b = scandir($handle1);
							$convert = str_replace('-', '_', $file);
							$convert = str_replace('.', '_', $convert);
							$plugin->$convert = new stdClass();
							$plugin->$convert->css = array();
							$plugin->$convert->js = array();
							array_push($assetList, $convert);
							foreach ($b as $key => $value) {
								if (!in_array($value, $blacklist)) {	
									$dirl = "$handle1/$value";
									if(!is_dir($dirl)){
										$ext = pathinfo($dirl);
										if($ext['extension'] == 'css'){
											array_push($plugin->$convert->css, "/$file/$value");
										}else if($ext['extension'] == 'js'){
											array_push($plugin->$convert->js, "/$file/$value");
										}else{

										}
									}else{
										$c = scandir($dirl);
										foreach ($c as $key1 => $value1) {
											if (!in_array($value1, $blacklist)) {
												$dirl = "$dirl/$value1";
												if(!is_dir($dirl)){
													//print_r("$files/$value/$value1 \n");
													$ext = pathinfo($dirl);
													if($ext['extension'] == 'css'){
														array_push($plugin->$convert->css, "/$file/$value/$value1");
													}else if($ext['extension'] == 'js'){
														array_push($plugin->$convert->js, "/$file/$value/$value1");
													}else{

													}
												}else{
													
												}
											}
										}
									}
								}
							}
						}
			        }
			    }
			}
			if($data){
				return $assetList;
			}else{
				return $plugin;
			}
	    }
	    public function genButton($add = false, $edit = false, $delete = false, $param = null){
	    	$html = '';
	    	$pData = '';
	    	if($param){
	    		$pData = 'data-extra-param="'.$param.'"';
	    	}
	    	if($add){
	    		$html = $html.' <a class="btn waves-effect waves-light green darken-1 btn-extra-add" '.$pData.' title="Add">
	    		<i class="material-icons">add</i></a>';
	    	}
	    	if($edit){
	    		$html = $html.' <a class="btn waves-effect waves-light cyan accent-2 btn-extra-edit" '.$pData.' title="Edit">
	    		<i class="material-icons">edit</i></a>';
	    	}
	    	if($delete){
	    		$html = $html.' <a class="btn waves-effect waves-light red accent-2 btn-extra-delete" '.$pData.' title="Delete">
	    		<i class="material-icons">remove_circle</i></a>';
	    	}
	    	
	    	return '
	    		<div class="row s12 right">
	    			<div class="container">
	    				<div class="s2">
                  			'.$html.'
                  		</div>
                  	</div>
                </div>
            ';
	    }
	    public function genSidebar($role){
	    	$sidebar = settings::t_sidebar;
	    	switch($role){
	    		case 1:
	    			$sidebar = '/TEMPLATE/SYSTEM/COMPONENT/SIDEBAR/sidebar_admin.html';
	    		break;
	    		case 20:
	    			$sidebar = '/TEMPLATE/SYSTEM/COMPONENT/SIDEBAR/sidebar_member.html';
	    		break;
	    		case 21:
	    			$sidebar = '/TEMPLATE/SYSTEM/COMPONENT/SIDEBAR/sidebar_manila_admin.html';
	    		break;
	    	}
	    	return $sidebar;
	    }
	}
?>