<?php
interface settings {
	const d_url = "http://localhost"; // url use by system
	const d_assets = '/PROJECT/FILES'; // assets url directory
	const d_path = '../PROJECT/FILES'; // root directory 
	
#DATABASE SETTINGS
	const db_host = "localhost";
	const db_user = "root";
	const db_port = 3306;
	const db_pass = "";
	const db_database = "dammmba_v2";

#TEMPLATE SETTINGS
	const c_title = 'DAMMMBA';
	const c_description = 'Sample Description';

#TEMPLATES
	const t_main = '/TEMPLATE/SYSTEM/LAYOUT/main.html';
	const t_sidebar = '/TEMPLATE/SYSTEM/COMPONENT/SIDEBAR/sidebar_current.html';
	const t_header = '/TEMPLATE/SYSTEM/COMPONENT/header.html';
	const t_footer = '/TEMPLATE/SYSTEM/COMPONENT/footer.html';
	const t_themer = '/TEMPLATE/SYSTEM/COMPONENT/themer.html';
	const t_chat = '/TEMPLATE/SYSTEM/COMPONENT/chat.html';
	
#ASSETS	
	const t_assets = '/ASSETS';
	const t_js = '/JS';
	const t_css = '/CSS';
	const t_cc = '/CUSTOM';
	const t_plugin = '/PLUGIN';

#ADMIN TEMPLATES
	const at_main = '/TEMPLATE/ADMIN/LAYOUT/main.html';
	const at_sidebar = '/TEMPLATE/SYSTEM/COMPONENT/SIDEBAR/sidebar_current.html';
	const at_header = '/TEMPLATE/SYSTEM/COMPONENT/header.html';
	const at_footer = '/TEMPLATE/SYSTEM/COMPONENT/footer.html';
	const at_themer = '/TEMPLATE/SYSTEM/COMPONENT/themer.html';
	const at_chat = '/TEMPLATE/SYSTEM/COMPONENT/chat.html';
	
#ADMIN ASSETS	
	const at_assets = '/ASSETS';
	const at_js = '/JS';
	const at_css = '/CSS';
	const at_cc = '/CUSTOM';
	const at_plugin = '/PLUGIN';

	const dts_menu_selection = "round";
	const dts_menu_collapsed = 0;
	const dts_menu_color = 'gradient-indigo-purple';
	const dts_footer_color = 'gradient-indigo-purple';
	const dts_navebar_color = 'gradient-indigo-purple';
	const dts_sidebar_mode = 'light';
}
interface server_control {
	const system_override = 1;
	const server_status = 0;
	const server_maintenance = 0;
	const server_lock = 0;
	const server_gateway = 0;
	const server_themer = 0;
	const server_chat = 0;
}
?>