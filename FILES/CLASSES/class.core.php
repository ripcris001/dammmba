<?php
include('class.builder.php');
Class Core extends Themer implements settings, server_control {
	public $__template, $__tConfig, $__data, $__session, $__theme_overide, $builder;
	private $encryption_key = "VjWt#9<\=m<uyq6zC=%Yb.&DBe5q^+T]f8k";
	private $encryption_iv = "2zQfC2GEcQ*})gMg";
	private $encryption_cipher = "AES-256-CBC";
	public function __construct(){
		$check = $this->checkSession();
		$this->builder = new Builder();
		$this->enable_admin = 0;
		$this->__template = new stdClass();
		$this->__template->cTitle = settings::c_title;
		$this->__template->cDescription = settings::c_description;
		$this->__template->cFooter = $this->template(settings::d_path.settings::t_footer);
		$this->__template->cHeader = $this->template(settings::d_path.settings::t_header);
		$this->__template->cSidebar = $this->template(settings::d_path.settings::t_sidebar);
		$this->__template->cThemer = (server_control::system_override ? server_control::server_themer : $this->getServerSetting("themer")) ? $this->template(settings::d_path.settings::t_themer) : '';
		$this->__template->cChat = (server_control::system_override ? server_control::server_chat :$this->getServerSetting("chat")) ? $this->template(settings::d_path.settings::t_chat) : '';
		$this->__template->cAssets = settings::d_assets.settings::t_assets;
		$this->__template->cAssetsJS = $this->__template->cAssets.settings::t_js;
		$this->__template->cAssetsCSS = $this->__template->cAssets.settings::t_css;
		$this->__template->cAssetsCC = $this->__template->cAssets.settings::t_cc;
		$this->__template->cAssetsPLUGIN = $this->__template->cAssets.settings::t_plugin;
		$this->__template->cPluginJS = "";
		$this->__template->cPluginCSS = "";
		$this->__template->cPluginCSSCustom = "";
		$this->__template->cPluginJSCustom = "";
		$this->__template->cContent = "Default Content";
		$this->__template->cData = null;
		$this->__template->cAllowTheme = server_control::system_override ? server_control::server_themer : $this->getServerSetting("themer");
		$this->__template->cRoleButton = "";
		$this->__asset = new stdClass();
		$this->__asset->js = array();
		$this->__asset->css = array();
		$this->__plugin = new stdClass();
		$this->__plugin->use = array();
		$this->__plugin->blacklist = array();

		$this->__tConfig = new stdClass();
		$this->__tConfig->template = settings::t_main;
		$this->__data = new stdClass();
		$this->__session = new stdClass();
		$this->__session->noSessionMessage = "No Session";
		$this->__session->web_title = settings::c_title;
		$this->__session->change_gateway = (server_control::system_override ? server_control::server_gateway : $this->getServerSetting("gateway")) ? '<a class="btn-logout-gateway" href="#">Change Gateway</a>' : '';
		$this->__theme = new stdClass();
		$this->__theme_overide = new stdClass();
		if($check){
			foreach($_SESSION as $key => $value){
				$this->__session->$key = $value;
			}
		}
	}
	public function controlInterface($param){
		$control = new stdClass();
		$control->server_maintenance = server_control::system_override ? server_control::server_maintenance : $this->getServerSetting('maintenance');
		$control->server_lock = server_control::system_override ? server_control::server_lock : $this->getServerSetting('lock');
		$control->server_gateway = server_control::system_override ? server_control::server_gateway : $this->getServerSetting('gateway');
		$control->server_themer = server_control::system_override ? server_control::server_themer : $this->getServerSetting('themer');
		$control->server_chat = server_control::system_override ? server_control::server_chat : $this->getServerSetting('chat');
		if(isset($param)){
			if(isset($control->$param)){
				return $control->$param;
			}else{
				return "";
			}
		}
		return server_control::$param;
	}
	public function template($data) {
		$template = $data;
        if (!file_exists($template))
        $this->SystemExit('Template not found: ' . $template, __FILE__);
        $__data[0][0] = fopen($template, "r");
        $__data[0][1] = fread($__data[0][0], filesize($template));
        fclose($__data[0][0]);
        return $__data[0][1];
    }
	public function buildComponent ($data){
		$output = $this->buildContent($this->template($data->file), $d_data);	
		return output;
	}
	public function buildTemplate($data, $def = true){
		$__object = new stdClass();
		$__object = $this->__template;
		$template = $this->__tConfig->template;
		foreach($data as $key => $value){
			if(!$def){
				$__object->$key = $value;
			}
		}
		foreach($this->__data as $key => $value){
			$checktype = gettype($value);
			$index = 'data_'.$key;
			if($checktype == 'array' || $checktype == 'object'){
				$__object->$index = json_encode($value);
			}else{
				$__object->$index = $value;
			}
		}
		foreach($this->__session as $key => $value){
			$checktype = gettype($value);
			$index = 'session_'.$key;
			if($checktype == 'array' || $checktype == 'object'){
				$__object->$index = json_encode($value);
			}else{
				$__object->$index = $value;
			}
		}
		foreach($this->__theme as $key => $value){
			$checktype = gettype($value);
			$index = 'theme_'.$key;
			if($checktype == 'array' || $checktype == 'object'){
				$__object->$index = json_encode($value);
			}else{
				$__object->$index = $value;
			}
		}
		if($def){
			$template = $this->__tConfig->template;
		}else{
			$template = $data->t_main;
		}
		$output = $this->buildContent($this->template(settings::d_path.$template), $__object);
		return $output;
	}
	public function loadTemplate($path, $def = false){
		$__object = new stdClass();
		$__object->t_main = $path;
		return $this->buildTemplate ($__object, $def);
	}
	
	public function render(){
		$local = new stdClass();
		$theme_setting = new stdClass();
		$this->__template->cSidebar = $this->getSessionVar('user_role') ? $this->template(settings::d_path.$this->genSidebar($this->getSessionVar('user_role'))) : '';
		if($this->enable_admin){
			$this->__template->cFooter = $this->template(settings::d_path.settings::at_footer);
			$this->__template->cHeader = $this->template(settings::d_path.settings::at_header);
			$this->__template->cSidebar = $this->template(settings::d_path.settings::at_sidebar);
			$this->__template->cAssets = settings::d_assets.settings::at_assets;
			$this->__template->cAssetsJS = $this->__template->cAssets.settings::at_js;
			$this->__template->cAssetsCSS = $this->__template->cAssets.settings::at_css;
			$this->__template->cAssetsCC = $this->__template->cAssets.settings::at_cc;
			$this->__template->cAssetsPLUGIN = $this->__template->cAssets.settings::at_plugin;
			$this->__tConfig->template = settings::at_main;
		}
		$check = $this->checkSession();
		if($check){
			if($this->getSessionVar('template_enable')){
				$session_template_setting = $this->getSessionVar('template_setting');
				$theme_setting->menu_selection = isset($session_template_setting->menu_selection) ? $session_template_setting->menu_selection : settings::dts_menu_selection;
				$theme_setting->menu_collapsed = isset($session_template_setting->menu_collapsed) ? $session_template_setting->menu_collapsed : settings::dts_menu_collapsed;
				$theme_setting->menu_color = isset($session_template_setting->menu_color) ? $session_template_setting->menu_color : settings::dts_menu_color;
				$theme_setting->footer_color = isset($session_template_setting->footer_color) ? $session_template_setting->footer_color : settings::dts_footer_color;
				$theme_setting->navebar_color = isset($session_template_setting->navebar_color) ? $session_template_setting->navebar_color : settings::dts_navebar_color;
				$theme_setting->sidebar_mode = isset($session_template_setting->sidebar_mode) ? $session_template_setting->sidebar_mode : settings::dts_sidebar_mode;
			}else{
				$theme_setting->menu_selection = settings::dts_menu_selection;
				$theme_setting->menu_collapsed = settings::dts_menu_collapsed;
				$theme_setting->menu_color = settings::dts_menu_color;
				$theme_setting->footer_color = settings::dts_footer_color;
				$theme_setting->navebar_color = settings::dts_navebar_color;
				$theme_setting->sidebar_mode = settings::dts_sidebar_mode;
			}
		}else{
			$theme_setting->menu_selection = settings::dts_menu_selection;
			$theme_setting->menu_collapsed = settings::dts_menu_collapsed;
			$theme_setting->menu_color = settings::dts_menu_color;
			$theme_setting->footer_color = settings::dts_footer_color;
			$theme_setting->navebar_color = settings::dts_navebar_color;
			$theme_setting->sidebar_mode = settings::dts_sidebar_mode;
		}
		if(isset($this->__plugin->use)){
			$this->plugin($this->__plugin->use, $this->__plugin->blacklist);
		}
		
		$this->additionalAssets($this->__asset->css, $this->__asset->js);
		$this->__theme = $this->buildTheme($theme_setting);
		if(isset($this->__theme_overide)){	
			foreach($this->__theme_overide as $key => $value){
				$index = $key;
				if(isset($value)){
					$this->__theme->$index = $value;
				}
			}
		}
		print_r($this->buildTemplate($local, true));
	}
	public function buildContent($data, $variables) {  
		$__variable = array();
		foreach($variables as $key => $value){
			$__variable['{'.$key.'}'] = $value;
		}
        $output = empty($variables) ? $data : str_replace(array_keys($__variable), array_values($__variable), $data);
        return $output;
    }
	public function checkFile($path){
		$path = settings::d_path.'/'.$path;
		if (!file_exists($path)){
			return false;
		}else {
			return true;
		}
	}
	public function checkSession(){
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_SESSION)){
			isset($_SESSION['lh_id']) ? $_SESSION['lh_id'] : false;
			isset($_SESSION['org_id']) ? $_SESSION['org_id'] : false;

			if(count($_SESSION)){
				$session = $_SESSION;
				if(isset($_SESSION['has_login'])){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function checkGateway(){
		$check = $this->checkSession();
		if(isset($_SESSION["gateway"])){
			return true;
		}else{
			return false;
		}
	}
	public function setGateway($data){
		$response = $this->newClass();
		$response->status = false;
		$response->message = "";
		$check = $this->checkSession();
		if(!$check){
			if(isset($_SESSION["gateway"])){
				$response->status = true;
				$response->message = "gateway already complete!";
				return $response;
			}else{
				$_SESSION["gateway"] = $data->gateway_key;
				$_SESSION["branch_id"] = $data->branch_id;
				$response->status = true;
				$response->message = "gateway setup complete!";
				return $response;
			}
		}else{
			$response->status = false;
			$response->message = "system error!";
			return $response;
		}
	}
	public function setLogin($data){
		$response = $this->newClass();
		$response->status = false;
		$response->message = "";
		$check = $this->checkSession();
		if($check){
			$response->status = false;
			$response->message = "Session Exist!";
			return $response;
		}else{
			$_SESSION["open"] = 0;
			$_SESSION["lock"] = 0;
			$_SESSION["has_login"] = 1;
			$_SESSION["user_id"] = $data->user_id;
			$_SESSION["user_name"] = $data->username;
			$_SESSION["user_role"] = $data->user_role;
			$_SESSION["name"] = $data->name;
			$_SESSION["profile_picture"] = $data->profile_picture;
			$_SESSION["profile_banner"] = $data->profile_banner;
			$_SESSION["template_setting"] = $this->parseTemplate($data->template_setting);
			$_SESSION["template_enable"] = $data->template_enable;
			$_SESSION['web_title'] = settings::c_title;
			$response->status = true;
			$response->message = "Session set complete!";
			return $response;
		}
	}
	public function parseTemplate($data){
		$localTemplate = $this->newClass();
		if(isset($data)){
			$parseData = explode(",",$data);
			foreach ($parseData as $key => $value) {
				$newValue = explode(":",$value);
				$index = $newValue[0];
				$iValue = $newValue[1];
				$localTemplate->$index = $iValue;
			}
			return $localTemplate;
		}else{
			return $localTemplate;
		}
	}
	public function setLogout(){
		$response = $this->newClass();
		$response->status = false;
		$response->message = "";
		$check = $this->checkSession();
		if($check){
			session_unset();
			session_destroy();
			$response->status = true;
			$response->message = "Session destroy!";
			return $response;
		}else{
			$response->status = false;
			$response->message = $this->__session->noSessionMessage;
			return $response;
		}
	}
	public function setLogoutGateway(){
		$response = $this->newClass();
		$response->status = false;
		$response->message = "";
		$check = $this->checkGateway();
		if($check){
			session_unset();
			session_destroy();
			$response->status = true;
			$response->message = "Session gateway destroy!";
			return $response;
		}else{
			$response->status = false;
			$response->message = $this->__session->noSessionMessage;
			return $response;
		}
	}
	public function updateSession($param){
		$response = $this->newClass();
		$response->message = "";
		$response->status = false;
		if(gettype($param) == 'object'){
			$session = $this->checkSession();
			if($session){
				foreach($param as $key => $value){
					if(isset($_SESSION[$key])){
						$_SESSION[$key] = $value;
					}
				}
				$response->status = true;
				return $response;
			}else{
				$response->message = "Session doesnt exist!";
				return $response;
			}
		}else{
			$response->message = "No Parameter.";
			return $response;
		}
	}
	public function resetSession($data){
		$response = $this->newClass();
		$response->message = "";
		$response->status = false;
		$session = $this->checkSession();
		if($session){
			if(isset($_SESSION[$data])){
				$response->status = true;
				$_SESSION[$data] = null;
			}else{
				$response->message = "Session data doesnt exist!";
			}
			return $response;
		}else{
			$response->message = "Session doesnt exist!";
			return $response;
		}
	}
	public function getSessionVar($param){
		if(isset($param)){
			$session = $this->checkSession();
			if($session){
				if(isset($_SESSION[$param])){
					return $_SESSION[$param];
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	public function themeSetter($data){

	}
	public function templateSetter($data){
		if(!$data){
			$this->__theme_overide->menu_collapsed_main = "main-full-max";
			$this->__theme_overide->footer_class = "main-full-max";
			$this->__template->cSidebar = "";
			$this->__template->cHeader = $this->loadTemplate('/TEMPLATE/SYSTEM/COMPONENT/HEADER/no-login.html');
		}
	}
	public function newClass(){
		$input = new stdClass();
		return $input;
	}
	public function redirect($param){
		header('Content-Type: text/plain');
        print ("Redirecting to $param");
        header("Location: $param");
        exit(1);
	}
	public function encrypt($data){
		//$iv_length = openssl_cipher_iv_length($this->encryption_cipher); 
		$encryption_iv = substr(hash('sha256', $this->encryption_iv), 0, 16); 
		$encryption_key = hash('sha256', $this->encryption_key); 
		$encryption = openssl_encrypt($data, $this->encryption_cipher, $encryption_key, 0, $encryption_iv); 
		return $encryption;
	}
	public function decrypt($data){
		$decryption_iv = substr(hash('sha256', $this->encryption_iv), 0, 16);
		$decryption_key = hash('sha256', $this->encryption_key); 
		$decryption = openssl_decrypt ($data, $this->encryption_cipher, $decryption_key, 0, $decryption_iv);
		return $decryption;
	}
	public function response($data){
		print_r(json_encode($data));
		exit(1);
	}
	public function queryParser($query, $value){
		$output = "";
        $output = empty($value) ? $output : str_replace(array_keys($value), array_values($value), $query);
        return $output;
	}
	PUBLIC function refValues($arr){
	    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
	    {
	        $refs = array();
	        foreach($arr as $key => $value)
	            $refs[$key] = &$arr[$key];
	        return $refs;
	    }
	    return $arr;
	}
	public function execQuery($type, $data, $all = false){
		$output = $this->newClass();
		$output->status = false;
		$type = strtolower($type);
		$result = "";
		$this->connectDB();
		// insert logging history here
		
		if(isSet($data)){
			if($type == 'fetch'){
				$query = $this->DBase('query', $data);
				if($all){
					$output->data = $query->fetch_all(MYSQLI_ASSOC);
					$output->status = true;
				}else{
					$output->data = $query->fetch_object();
					if($output->data){
						$output->status = true;
					}
				}
			}else if($type == 'update'){
				try {
					$query = $this->DBase('prepare', $data);
					if ($query->execute()) { 
						$output->status = true;
					} else {
					 	$output->status = false;
					}
				} catch(PDOException $e){
					$output->message = $e->getMessage();
				}
			}else if($type == 'insert'){
				try {
					$query = $this->DBase('query', $data);
					$output->status = true;
					$output->data = json_encode($query);
				} catch(PDOException $e){
					$output->message = $e->getMessage();
				}
			}else if($type == 'delete'){
				try {
					$query = $this->DBase('prepare', $data);
					if ($query->execute()) { 
						$output->status = true;
					}
				} catch(PDOException $e){
					$output->message = $e->getMessage();
				}
			}
			return $output;
		}
	}
	public function getRoute(){
		$output = $this->newClass();
		$query = $this->execQuery("fetch","SELECT * FROM routes", true);
		if($query->status){
			$output->data = $query->data;
			$output->status = true;
		}else{
			$output->data = array();
		}
		return $output;
	}

	public function getServerSetting($data){
		$output = 0;
		$query = $this->execQuery("fetch","SELECT * FROM server_settings WHERE server_function='$data' ");
		if($query->status){
			$output = intval($query->data->server_value);
		}else{
			$output = 0;
		}
		return $output;
	}
	public function updateServerSetting($target, $value, $field, $fieldValue){
		$output = 0;
		$query = $this->execQuery("update","UPDATE server_settings SET $target=$value WHERE $field='$fieldValue'");
		$output  = $query;
		return $output;
	}
	public function plugin($data, $blacklist){
		$pluginList = $this->pluginlist();
		$localCSS = "";
		$localJS = "";
   	 	foreach ($data as $key => $value) {
   	 		if(isset($pluginList->$value)){
   	 			if(isset($pluginList->$value->css)){
   	 				foreach ($pluginList->$value->css as $a => $b) {
   	 					if (!in_array($b, $blacklist)) {
   	 						$localCSS = $localCSS.'<link rel="stylesheet" type="text/css" href="'.$this->__template->cAssets.'/app-assets/vendors'.$b.'">';
   	 					}
   	 				}
   	 			}
   	 			if(isset($pluginList->$value->js)){
   	 				foreach ($pluginList->$value->js as $a => $b) {
   	 					if (!in_array($b, $blacklist)) {
   	 						$localJS = $localJS.'<script src="'.$this->__template->cAssets.'/app-assets/vendors'.$b.'" type="text/javascript"></script>';
   	 					}
   	 				}
   	 			}
   	 		}
   	 	}
   	 	$this->__template->cPluginJS = $localJS;
   	 	$this->__template->cPluginCSS = $localCSS;
 	}
 	public function additionalAssets($css, $js){
		$localCSS = "";
		$localJS = "";
		if(isset($css)){
			foreach ($css as $key => $value) {
	   	 			$localCSS = $localCSS.'<link rel="stylesheet" type="text/css" href="'.$this->__template->cAssets.'/'.$value.'">';		
	   	 	}
		}
   	 	if(isset($js)){
	   	 	foreach ($js as $key => $value) {
	   	 		$localJS = $localJS.'<script src="'.$this->__template->cAssets.'/'.$value.'" type="text/javascript"></script>';
	   	 	}
   	 	}
   	 	$this->__template->cPluginJSCustom = $localJS;
   	 	$this->__template->cPluginCSSCustom = $localCSS;
 	}
 	public function qBuilder(){
 		$param = $this->newClass();
		$param->update = $this->newClass();
		$param->target = $this->newClass();
		return $param;
 	}
 	public function roleValidator($list, $roles){
 		if($roles){
 			if(in_array($roles, $list)){
 				return true;
 			} else {
 				return false;
 			}
 		}else{
 			return false;
 		}
 	}
	public function SystemExit($text, $loc, $file = null) {
        if (ob_get_level()) ob_end_clean();
        header('Content-Type: text/plain');
        print ("$text - " . date("F j, Y, g:i a"));
        print ("\nLocation: ($loc)");
        print ("\nSource: $file");
        exit(1);
    }
    public function SystemError($text) {
        if (ob_get_level()) ob_end_clean();
        header('Content-Type: text/plain');
        print ("$text - " . date("F j, Y, g:i a"));
        exit(1);
    }



    /* ======================= additional function ======================= */
    public function getRole($data = false, $all = false){
		$response = $this->newClass();
		$input = $this->newClass();
		if(!$all){
			$input->query = "SELECT * FROM user_role WHERE role_id = '$data'";
		}else{
			$input->query = "SELECT * FROM user_role";
		}
		$query = $this->execQuery("fetch",$input->query, $all);
		if($query->status){
			$response->message = "Successfully get role!";
			$response->status = true;
			$response->redirect = '';
			$response->data = $query->data;
			return $response;
		}else{
			$response->message = "Role Doest exist!";
			$response->status = false;
			return $response;
		}
	}
    public function getOrganization($data = false, $all = false){
		$response = $this->newClass();
		$input = $this->newClass();
		if(!$all){
			$input->query = "SELECT * FROM organization WHERE id = '$data'";
		}else{
			$input->query = "SELECT * FROM organization";
		}
		$query = $this->execQuery("fetch",$input->query, $all);
		if($query->status){
			$response->message = "Successfully get organization!";
			$response->status = true;
			$response->redirect = '';
			$response->data = $query->data;
			return $response;
		}else{
			$response->message = "Organization Doest exist!";
			$response->status = false;
			return $response;
		}
	}

	public function getLandHoldings($data = false, $all = false){
		$response = $this->newClass();
		$input = $this->newClass();
		if(!$all){
			$input->query = "SELECT * FROM landholdings WHERE id = '$data'";
		}else{
			$input->query = "SELECT * FROM landholdings";
		}
		$query = $this->execQuery("fetch",$input->query, $all);
		if($query->status){
			$response->message = "Successfully get landholdings!";
			$response->status = true;
			$response->redirect = '';
			$response->data = $query->data;
			return $response;
		}else{
			$response->message = "Landholdings Doest exist!";
			$response->status = false;
			return $response;
		}
	}
	public function getUser($data = false, $all = false){
		$response = $this->newClass();
		$input = $this->newClass();
		if(!$all){
			$input->query = "SELECT * FROM user WHERE user_id = '$data'";
		}else{
			$input->query = "SELECT * FROM user";
		}
		$query = $this->execQuery("fetch",$input->query, $all);
		if($query->status){
			$response->message = "Successfully get user!";
			$response->status = true;
			$response->redirect = '';
			$response->data = $query->data;
			return $response;
		}else{
			$response->message = "User Doest exist!";
			$response->status = false;
			return $response;
		}
	}
	public function getBranch($data = false, $all = false){
		$response = $this->newClass();
		$input = $this->newClass();
		if(!$all){
			$input->query = "SELECT * FROM branch WHERE branch_id = '$data'";
		}else{
			$input->query = "SELECT * FROM branch";
		}
		$query = $this->execQuery("fetch",$input->query, $all);
		if($query->status){
			$response->message = "Successfully get branch!";
			$response->status = true;
			$response->redirect = '';
			$response->data = $query->data;
			return $response;
		}else{
			$response->message = "Branch Doest exist!";
			$response->status = false;
			return $response;
		}
	}

	public function getMemberPosition($data = false, $all = false){
		$response = $this->newClass();
		$input = $this->newClass();
		if(!$all){
			$input->query = "SELECT * FROM organization_member_position WHERE position_id = '$data'";
		}else{
			$input->query = "SELECT * FROM organization_member_position";
		}
		$query = $this->execQuery("fetch",$input->query, $all);
		if($query->status){
			$response->message = "Successfully get organization member position!";
			$response->status = true;
			$response->redirect = '';
			$response->data = $query->data;
			return $response;
		}else{
			$response->message = "Organization member position Doest exist!";
			$response->status = false;
			return $response;
		}
	}

	//generate monthly dues conter
	public function genMonthlyDuesRecord(){
		$month = date('m');
		$year = date('Y');
		$input = $this->newClass();
		$response = $this->newClass();
		$response->status = false;
		$input->query = "SELECT * FROM monthly_dues_record WHERE month = '$month' AND year = '$year'";
		$input->result = $this->execQuery("fetch",$input->query);
		if(!$input->result->status){
			$sql = "INSERT INTO monthly_dues_record (month, year) VALUES ('$month', '$year')";
			$query = $this->execQuery("insert",$sql);
			if($query->status){
				$response->status = true;
				$response->message = "Successfully added new monthly dues record.";
			}else{
				$response->message = "Failed to add new monthly dues record.";
			}
		}else{
			$response->message = "Record already Exist. Month = [$month] Yeah = [$year]";
		}
		return $response;
		// $sql = "INSERT INTO monthly_dues_record (month, year) VALUES ('1', '1')";
		// $query = $this->execQuery("insert",$sql);
		
	}
}
?>