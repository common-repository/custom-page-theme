<?PHP
/**
** Plugin Name: Custom Page Theme
** Plugin URI: https://github.com/jeetendrabajaj/custom-page-theme/
** Description: An alternate for Custom Page Templating in Wordpress, that resolves all the below mentioned limitations of Custom Page Templating. Imagine a wordpress websites having various pages implemented with Custom Page Templats, now  
** it's limitations are 1) All the styling, javascripts, images and font files for each Custom Page template will be saved in same css, js, images & fonts folders of Active Theme folder.
** 2) Removal of styling, javascripts, images and font files for the pages implemented with Custom Page Templats and have no more use is complex.
** 3) While upgradig Active theme special precaution required to maintain styling, javascripts, images and font files of Custom Page Templats.
** My Custom Page Theme plugin resolves all these above mentioned limitations
** Version: 1.0.3
** Author: Jeetendra Bajaj
** Author URI: https://www.linkedin.com/in/jeetendra-bajaj-14020b14/ 
**/ 




if ( ! class_exists( 'CSTM_PAGE_THEME' ) ) :

/**
 * Main CSTM_PAGE_THEME Class.
 *
 * @class CSTM_PAGE_THEME
 * @version	1.0.3
 */
final class CSTM_PAGE_THEME {
	
	/**
	 * CSTM_PAGE_THEME version.
	 *
	 * @var string
	 */
	public $version = '1.0.3';

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->cstmpt_define_constants();
		$this->cstmpt_include_files();
		$this->cstmpt_initialize_hooks();
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function cstmpt_define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Define Constants.
	 */
	private function cstmpt_define_constants() {
		$this->cstmpt_define( 'CSTM_PAGE_THEME_PLUGIN_FILE', __FILE__ );
		$this->cstmpt_define( 'CSTM_PAGE_THEME_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		$this->cstmpt_define( 'CSTM_PAGE_THEME_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		$this->cstmpt_define( 'CSTM_PAGE_THEME_FOLDER_PATH', trailingslashit( dirname(get_template_directory())) );
		$this->cstmpt_define( 'CSTM_PAGE_THEME_VERSION', $this->version );
		$this->cstmpt_define( 'CSTM_PAGE_THEME_DELIMITER', '|' );
		//$this->cstmpt_define( 'CSTM_PAGE_THEME_LOG_DIR', $upload_dir['basedir'] . '/CSTM_PAGE_THEME-logs/' );
	}

	/**
	 * Include required lib files.
	 */
	public function cstmpt_include_files() {
		include_once( CSTM_PAGE_THEME_PATH . 'classes/cstmpt_Inc.php' );
	}
	
	/**
	 * Hook into actions and filters.
	 */
	private function cstmpt_initialize_hooks() {
		add_action( "add_meta_boxes", array( $this, "cstmpt_add_meta_box" ) );
		add_action( "save_post", array( $this, "cstmpt_save_theme" ), 10, 3);
		add_action( 'admin_menu', array( $this, 'cstmpt_admin_menu' ), 9 );
		add_action( 'admin_action_addact', array( $this, 'cstmpt_admin_action_add' ));
		add_action( 'admin_action_custommenu', array( $this, 'cstmpt_admin_menu_customize' ));
		add_action( 'admin_action_addpgcontent', array( $this, 'cstmpt_add_page_content_template' ));
		add_action( 'admin_enqueue_scripts', array( $this, 'cstmpt_admin_scripts' ) );
		register_activation_hook( __FILE__, array( $this, 'cstmpt_init' ) );	


		/** 
		 * At User end examin the page request and find the theme->template pointed on this   
		 * page if page is pointed to some custome page theme then hooked function will load 
		 * the attached theme->template else it will open the active theme->template page.
		 */
		add_action( 'setup_theme', array( $this, 'cstmpt_switch_page_theme'));

	}
	
	
	 /**
	 * Add admin menu & it's items.
	 */
	public function cstmpt_admin_menu() {
		add_menu_page( "Custom Page Theme", "Custom Page Theme", "administrator", "cstm-page-theme", array( $this, 'cstmpt_all_theme_lst' ), CSTM_PAGE_THEME_URL.'/img/icon.png', null );

		/*add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )*/
		add_submenu_page( 'cstm-page-theme', 'All Themes', 'All Themes', 'administrator', 'cstm-page-theme', array( $this, 'cstmpt_all_theme_lst' ) );
		add_submenu_page( 'cstm-page-theme', 'Sample Theme', 'Checkout Sample Theme', 'administrator', 'cstm-page-theme-sample', array( $this, 'cstmpt_opn_sample_theme' ) );
		add_submenu_page( 'cstm-page-theme', 'Add Theme', 'Add Theme', 'administrator', 'cstm-page-theme-new', array( $this, 'cstmpt_add_form_markup' ));
		add_submenu_page( 'cstm-page-theme', 'Nav Menu Setup & Shortcodes', 'Menu Shortcodes', 'administrator', 'cstm-page-theme-nav', array( $this, 'cstmpt_menu_lst_setupnshortcode' ));
		add_submenu_page( 'null', 'Nav Menu Customization', 'Nav Menu Customization', 'administrator', 'cstm-page-theme-menucustomization', array( $this, 'cstmpt_menu_customization' ));
		add_submenu_page( 'cstm-page-theme', 'All Content Templates', 'Page Content Templates', 'administrator', 'cstm-page-theme-page-content', array( $this, 'cstmpt_list_page_cntnt_template' ));
		add_submenu_page( 'null', 'Add Content Template', 'Add Content Template', 'administrator', 'cstm-page-theme-page-content-update', array( $this, 'cstmpt_update_page_cntnt_template' ));

	}

	/**
	 * Add list of scripts into admin panel
	 */
	public function cstmpt_admin_scripts(){
		wp_enqueue_script( 'jquery-ui', CSTM_PAGE_THEME_URL . 'js/jquery-ui.js', CSTM_PAGE_THEME_VERSION );
		wp_enqueue_script( 'admin-script', CSTM_PAGE_THEME_URL . 'js/admin.js', CSTM_PAGE_THEME_VERSION );
		wp_enqueue_script( 'jquery-formater', CSTM_PAGE_THEME_URL . 'js/jquery.format.js', CSTM_PAGE_THEME_VERSION );
		wp_enqueue_style( 'jquery-ui-css', CSTM_PAGE_THEME_URL . 'css/jquery-ui.css' );
		wp_enqueue_style( 'admin-style', CSTM_PAGE_THEME_URL . 'css/admin.css' );
	}

	
	/**
	 * Initilise default menus and default page with activation of plugin
	 */
	static function cstmpt_init() {

			/*
			* First create the default theme
			*/
			$inc = new CSTM_PT_Inc();
			$theme_name = 'cstpgthm_default';
			global $wpdb;
			$dir = CSTM_PAGE_THEME_FOLDER_PATH.$theme_name;
			if(!is_dir($dir)){
				$dir = CSTM_PAGE_THEME_FOLDER_PATH.$theme_name;
				mkdir($dir);
			    $inc->rcopy(CSTM_PAGE_THEME_PATH."assets", $dir);
				$prepand = "/*";
				$prepand .= "\n"."Theme Name: Custom Page Theme - Getting Started";
				$prepand .= "\n"."Author: Custom Page Theme Plugin Support";
				$prepand .= "\n"."Description: Custom Page Theme - Getting Started";
				$prepand .= "\n"."Version: 1.0.3";
				$prepand .= "\n";
				//$prepand .= "Tags: bootstrap
				$prepand .= "\n"."*/"; 
				$inc->prepand_text($prepand, $dir."/style.css");
				$inc->prepand_text("<?php get_header(); ?>"."\r\n", $dir."/index.php");
				$inc->postappand_text("\r\n"."<?php get_footer(); ?>"."\r\n", $dir."/index.php");
			}

			$page = get_page_by_title('Welcome to Custom Page Theme', OBJECT, 'page');
			if(empty($page)){
				$postContent = '<div id="tab1cnt">';
				$postContent .= 'Hello everybody, and welcome to Custom Page Theme.'; 
				$postContent .= 'A newest greatest WordPress plugin out there for your needs to build WordPress themes and help you out all programming complexities, a WordPress theme writer faces while writing a theme.';
				$postContent .= '';
				$postContent .= '<h2>THE CORE IDEA</h2>';
				$postContent .= '';
				$postContent .= 'If you have any html template, and you want to build a WordPress theme of it. You just need to install the Custom Page Theme plugin, activate it, write the html in "index.php" file and css in "style.css" file. You just submit both the files to Custom Page Theme and it will make a separate theme for you.';
				$postContent .= '';
				$postContent .= '<strong style="color:orange">See, How easy it is. </strong>';
				$postContent .= '';
				$postContent .= 'Even if your html template contains some add-ons, like banners, responsive design, special fonts or images, you can submit all the associated files along with "index.php" and "style.css".';
				$postContent .= '';
				$postContent .= 'Now, you can apply this theme anytime to any page, post or even use it as your active theme as well.';
				$postContent .= '';
				$postContent .= '<h2>Advantages of custom page theme</h2>';
				$postContent .= '<ul>';
				$postContent .= '<li>You can convert your html templates into WordPress themes, even if you do not have hands on programming.</li>';
				$postContent .= '<li>Custom page theme keeps your active theme intact of all the themes you develop. It makes easy to get rid of any custom template,'; $postContent .= 'that has no more use on your website.</li>';
				$postContent .= '<li>Custom page theme maintains all the themes you develop. so that you can apply them anytime to any page, post or even use it as'; $postContent .= 'your active theme as well.</li>';
				$postContent .= '<li>It has easy panels to add, edit, retrieve, Delete and list all the themes.</li>';
				$postContent .= '<li>Custom page theme helps you apply any theme to any page irrespective of whatever active theme applied to website. So you can apply different themes to different sections on same website.</li>';
				$postContent .= '<li>To apply any theme on any page, "Custom page theme" adds a metabox into Add new page and Edit page, at the right corner holding a dropdown with a list of all the themes. you need to select the theme you want to apply and submit! </li>';
				$postContent .= '</ul>';
				$postContent .= '</div>';
			
				$defaults = array(
						'post_author' => '1',
						'post_content' => $postContent,
						'post_content_filtered' => '',
						'post_title' => 'Welcome to Custom Page Theme',
						'post_excerpt' => '',
						'post_status' => 'publish',
						'post_type' => 'page',
						'comment_status' => 'closed',
						'ping_status' => 'closed',
						'post_password' => '',
						'to_ping' =>  '',
						'pinged' => '',
						'post_parent' => 0,
						'menu_order' => 0,
						'guid' => '',
						'import_id' => 0,
						'context' => '',
					);
				$post_id = wp_insert_post( $defaults);
				add_post_meta($post_id, '_custom_page_theme_select', $theme_name, false );						
			}
			//Check for Menu
			$menu_name = 'CPT SAMPLE MENU';
			$menu_exists = wp_get_nav_menu_object( $menu_name );

			// If it doesn't exist, let's create it.
			if( !$menu_exists){
				$menu_id = wp_create_nav_menu($menu_name);

				// Set up default menu items
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' =>  __('Welcome'),
					'menu-item-classes' => 'selected',
					'menu-item-url' => '#', 
					'menu-item-status' => 'publish'));

				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' =>  __('Getting Started'),
					'menu-item-url' => '#', 
					'menu-item-status' => 'publish'));
				
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' =>  __('Popular Widgets'),
					'menu-item-url' => '#', 
					'menu-item-status' => 'publish'));

			}

			$sample_menu = Array ('menu_slug' => 'cpt-sample-menu', 
								  'action' => 'custommenu', 
				                  'menu_name' => 'CPT SAMPLE MENU', 
				                  'menu_class' => '', 
				                  'menu_id' => 'menu', 
				                  'container' => 'div', 
				                  'container_class' => '', 
				                  'container_id' => 'menubar', 
				                  'link_wrapper' => '',
				                  'link_wrapper_class' =>'', 
				                  'link_txt_wrapper' => '',
				                  'link_txt_wrapper_class' => '',
				                  'submit' => 'Save & Preview' );
			add_option( '_cpt_cpt-sample-menu_sch', serialize($sample_menu) );


    }

	 /**
	 * Sample Custome page theme.
	 */
	function cstmpt_opn_sample_theme(){
		echo '<iframe src="'. get_site_url().'/welcome-to-custom-page-theme" style="width:100%; height:100%; position:absolute;"></iframe>';
	}

	 /**
	 * Add Custome page theme form markup.
	 */
	function cstmpt_add_form_markup(){
		include( CSTM_PAGE_THEME_PATH . 'views/add_thm.html' );
	}

	 /**
	 * Custome page theme Listing markup.
	 */
	function cstmpt_all_theme_lst(){
		include( CSTM_PAGE_THEME_PATH . 'views/list_thm.php' );
		$template = new CustomPageTheme_List();
		$template->fetch_output();
	}
	
	/**
	 * Custome page theme Setup menu design and get shorcodes.
	 */
	function cstmpt_menu_lst_setupnshortcode(){
		include( CSTM_PAGE_THEME_PATH . 'views/list_menu.php' );
		$template = new CustomPageTheme_MenuList();
		$template->fetch_output();
	}
	
	/**
	 * Custome page theme Menu Customisation.
	 */
	function cstmpt_menu_customization(){
		$id = intval( $_GET['menu'] );
		include( CSTM_PAGE_THEME_PATH . 'views/custom_menu.php' );
	}

	/**
	 * Custome page theme All Page Content templates List
	 */
	function cstmpt_list_page_cntnt_template(){
		include( CSTM_PAGE_THEME_PATH . 'views/page_content_template_list.php' );
		$template = new CustomPageTheme_PageContentTemplatesList();
		$template->fetch_output();
	}


	/**
	 * Custome page theme Page Content section Customisation.
	 */
	function cstmpt_update_page_cntnt_template(){
		global $wpdb;
		include( CSTM_PAGE_THEME_PATH . 'classes/widgets/cstmpt_pagecontent.php' );
		$pg_cntnt = new CPT_Page_Content();
		$attr = array();
		if(isset($_GET['action'] ) && $_GET['action'] == 'edit' &&  isset($_GET['template']) && $_GET['template']  != null ){  
			$row = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name LIKE '_cpt_pg_content_template_".$_GET['template']."' ");
			$rec = unserialize(unserialize($row->option_value));
			$attr['applytitle'] = $rec['applytitle'];
			$attr['applycomments'] = $rec['applycomments'];
			$attr['content_title'] = $rec['content_title'];
			$attr['container'] = $rec['container'];
			$attr['container_class'] = $rec['container_class'];
			$attr['container_id'] = $rec['container_id'];
			$attr['comment'] = $rec['comment'];
			$attr['commentarea_class'] = $rec['commentarea_class'];
			$attr['commentarea_id'] = $rec['commentarea_id'];
			echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function() {';
			foreach($rec as $key => $val){
				if($key=="template_name")echo 'jQuery("#'.$key.'").attr("readonly","true");';
				echo 'jQuery("#'.$key.'").val("'.$val.'");';
			}
			echo '});';
			echo '</script>';
		}
		include( CSTM_PAGE_THEME_PATH . 'views/update_page_cntnt_template.php' );
	}
	

	 /**
	 * Create a Custome page theme in the theme folder.
	 */	
	function cstmpt_admin_action_add(){
		$inc = new CSTM_PT_Inc();

		if(isset($_POST['submit'])){
			if("" != $inc->title_sanitize($_POST['theme_title']) && "" != $inc->string_sanitize($_POST['theme_description']) && ( "1" == $_POST['use_default_indx'] || (0 == $_FILES['theme_index_markup']['error'] && "index.php" == $inc->filename_sanitize($_FILES['theme_index_markup']['name']))) && ( "1" == $_POST['use_default_style'] || (0 == $_FILES['theme_style']['error'])&& "style.css" == $inc->filename_sanitize($_FILES['theme_style']['name'])) ){

				$theme_name = 'cstpgthm'.time();
				$dir = CSTM_PAGE_THEME_FOLDER_PATH.$theme_name;
				mkdir($dir);
				
			    $inc->rcopy(CSTM_PAGE_THEME_PATH."assets", $dir);
				if("1" != $_POST['use_default_indx']){
					unlink($dir."/index.php");
					copy($_FILES['theme_index_markup']['tmp_name'],$dir."/index.php");
				}
				if("1" != $_POST['use_default_style']){
					 unlink($dir."/style.css");
					 copy($_FILES['theme_style']['tmp_name'],$dir."/style.css");
				}
				//if associative js files uploaded and move it to /js/ folder of theme
				$suportive_js = array();
				if(!empty($_FILES['theme_js'])){
					$jspath = $dir."/js/";
					for($i=0;$i<count($_FILES['theme_js']['tmp_name']);$i++){
						if(0 == $_FILES['theme_js']['error'][$i] && '' != $inc->title_sanitize($_POST['theme_js_title'][$i])){
							copy($_FILES['theme_js']['tmp_name'][$i],$jspath.$inc->filename_sanitize($_FILES['theme_js']['name'][$i]));
							$suportive_js[$inc->title_sanitize($_POST['theme_js_title'][$i])] = $inc->filename_sanitize($_FILES['theme_js']['name'][$i]);
						}
					}
					add_option( '_'.$theme_name.'_js', serialize ($suportive_js) );
				}

				//if associative css files uploaded and move it to /css/ folder of theme
				$suportive_css = array();
				if(!empty($_FILES['theme_css'])){
					$csspath = $dir."/css/";
					for($i=0;$i<count($_FILES['theme_css']['tmp_name']);$i++){
						if(0 == $_FILES['theme_css']['error'][$i] && '' != $_POST['theme_css_title'][$i]){
							copy($_FILES['theme_css']['tmp_name'][$i],$csspath.$inc->filename_sanitize($_FILES['theme_css']['name'][$i]));
							$suportive_css[$inc->title_sanitize($_POST['theme_css_title'][$i])] = $inc->filename_sanitize($_FILES['theme_css']['name'][$i]);
						}
					}
					add_option( '_'.$theme_name.'_css', serialize ($suportive_css) );
				}
				
				//if associative images uploaded and move it to /img/ folder of theme
				$suportive_img = array();
				if(!empty($_FILES['theme_img'])){
					$imgpath = $dir."/img/";
					for($i=0;$i<count($_FILES['theme_img']['tmp_name']);$i++){
						if(0 == $_FILES['theme_img']['error'][$i]){
							copy($_FILES['theme_img']['tmp_name'][$i],$imgpath.$inc->filename_sanitize($_FILES['theme_img']['name'][$i]));
						}
					}
				}

				//if associative fonts uploaded and move it to /fonts/ folder of theme
				$suportive_fonts = array();
				if(!empty($_FILES['theme_fonts'])){
					$fontspath = $dir."/fonts/";
					for($i=0;$i<count($_FILES['theme_fonts']['tmp_name']);$i++){
						if(0 == $_FILES['theme_fonts']['error'][$i]){
							copy($_FILES['theme_fonts']['tmp_name'][$i],$fontspath.$inc->filename_sanitize($_FILES['theme_fonts']['name'][$i]));
						}
					}
				}
				
				$prepand = "/*";
				$prepand .= "\n"."Theme Name: ".$inc->title_sanitize($_POST['theme_title']);
				$prepand .= "\n"."Author: Custom Page Theme Plugin Support";
				$prepand .= "\n"."Description: ".$inc->string_sanitize($_POST['theme_description']);
				$prepand .= "\n"."Version: ".$this->version;
				$prepand .= "\n";
				//$prepand .= "Tags: bootstrap
				$prepand .= "\n"."*/";
				$inc->prepand_text($prepand, $dir."/style.css");
				$inc->prepand_text("<?php get_header(); ?>"."\r\n", $dir."/index.php");
				$inc->postappand_text("\r\n"."<?php get_footer(); ?>"."\r\n", $dir."/index.php");
			}
		}
		 $url = site_url('/wp-admin/admin.php?page=cstm-page-theme');
		 if ( wp_redirect( $url ) ) {
			exit;
		}
	}

	/**
	 * Add & Customize Navigation Menu template.
	 */	
	function cstmpt_admin_menu_customize(){
		$inc = new CSTM_PT_Inc();
		if(isset($_POST['submit'])){
			update_option( '_cpt_'.$_POST['menu_slug']."_sch", serialize ($_POST) );
		}
		$url = admin_url('admin.php?page=cstm-page-theme-menucustomization&menu='.intval($_POST['id']));
		 if ( wp_redirect( $url ) ) {
			exit;
		}
	}

	/**
	 * Add & Customize Page Content Templates.
	 */	
	function cstmpt_add_page_content_template(){
		$inc = new CSTM_PT_Inc();
		if(isset($_POST['submit'])){
			update_option( '_cpt_pg_content_template_'.$_POST['template_slug'] , serialize ($_POST) );
		}
		$url = admin_url('admin.php?page=cstm-page-theme-page-content');
		 if ( wp_redirect( $url ) ) {
			exit;
		}
	}

	/**
	 * Hook custom page theme meta box into admin panel edit page.
	 */
	function cstmpt_add_meta_box(){
	    add_meta_box("custom-theme-meta-box", "Custom Page Theme",  array( $this, "cstmpt_meta_box_markup" ), "page", "side", "low", null);
	}


	/**
	 * Custom page theme meta box markup.
	 */
	function cstmpt_meta_box_markup(){
	    global $post;
		$values = get_post_custom( $post->ID );
	    $selected = isset( $values['_custom_page_theme_select'] ) ? esc_attr( $values['_custom_page_theme_select'][0] ) : '';
		// We'll use this nonce field later on when saving.
	    wp_nonce_field( basename(__FILE__), 'meta_box_nonce' );
		echo '<p>';
		$themes = wp_get_themes();  //get the list of themes
		echo '<label for="custom_page_theme_select">Select Page Theme</label>';
		echo '<select name="custom_page_theme_select" id="custom_page_theme_select">';
		echo '<option value="default" '.selected( $selected, 'default' ).'>Default</option>';
		foreach ( $themes as $theme ) {
		   echo '<option value="'.$theme->get_stylesheet().'" '.selected( $selected, $theme->get_stylesheet() ).'>'.$theme->get('Name').'</option>';
		}
		echo '</select>';
		echo '</p>';  
	}
	

	/**
	 * Save the custome page theme selected with the page meta items.
	 */
	function cstmpt_save_theme($post_id, $post, $update){ 
		$inc = new CSTM_PT_Inc();
	    if (!isset($_POST["meta_box_nonce"]) || !wp_verify_nonce($_POST["meta_box_nonce"], basename(__FILE__)))
		    return $post_id;

		if(!current_user_can("edit_post", $post_id))
			return $post_id;

		if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
			return $post_id;

		$slug = "page";
		if($slug != $post->post_type)
			return $post_id;

	    $custom_page_theme_select = "";

	    if(isset($_POST["custom_page_theme_select"])) {
	        $custom_page_theme_select = $inc->string_sanitize($_POST["custom_page_theme_select"]);
		}   
	    update_post_meta($post_id, "_custom_page_theme_select", $custom_page_theme_select);
	}

	/** 
	 * At User end examin the page request and find the theme->template pointed on this   
	 * page if page is pointed to some custome page theme then load the attached
	 * theme->template else it will open the active theme->template page.
	 */
	function cstmpt_switch_page_theme() {
		$req_uri = $_SERVER['REQUEST_URI'] ;
		$post_id = url_to_postid( $_SERVER['REQUEST_URI'] );
		
		$selected_page_theme = get_post_meta( $post_id, '_custom_page_theme_select', true );
		$page_theme = ('' != $selected_page_theme && 'default' != $selected_page_theme) ? $selected_page_theme : get_option('stylesheet');

		 add_filter( 'template', create_function( '$t', 'return "' . $page_theme . '";' ) );
		 add_filter( 'stylesheet', create_function( '$s', 'return "' . $page_theme . '";' ) );
	}
}	

endif;

// Global for backwards compatibility.
$GLOBALS['cstm_page_theme'] = new CSTM_PAGE_THEME();