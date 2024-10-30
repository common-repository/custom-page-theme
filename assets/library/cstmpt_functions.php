<?php
/**
 * Custom Page Theme functions and definitions
 *
 * This file defines the some helper functions and shortcodes, these shortcodes
 * can be embwhich are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Custom Page Theme
 * @subpackage Custom Page Theme Templates
 * @since Custom Page Theme 1.0.1
 */


$cpt_themename = basename(__DIR__) ; 

/**
 * Get all assets (like images,scripts and styles) url, to be assed by page any where through shortcode.
 */
function get_custom_page_theme_asset_url($atts, $content = null, $tag ){
	$asset = preg_replace('/^' . preg_quote('custom_page_theme_', '/') . '/', '', preg_replace('/_url$/', '', $tag));
	$asset_url = get_template_directory_uri();
	switch($asset){
		case 'theme':
			$asset_url = get_template_directory_uri();
		break;
		case 'img':
			$asset_url = get_template_directory_uri().'/img/';
		break;
		case 'css':
			$asset_url = get_template_directory_uri().'/css/';
		break;
		case 'js':
			$asset_url = get_template_directory_uri().'/js/';
		break;
    }

	return $asset_url;
}
add_shortcode( 'custom_page_theme_theme_url', 'get_custom_page_theme_asset_url' );
add_shortcode( 'custom_page_theme_img_url', 'get_custom_page_theme_asset_url' );
add_shortcode( 'custom_page_theme_css_url', 'get_custom_page_theme_asset_url' );
add_shortcode( 'custom_page_theme_js_url', 'get_custom_page_theme_asset_url' );


function init_custom_page_theme_nav( $atts ) {
	$nav = unserialize(get_option( "_cpt_".$atts['menu']."_sch" ));

	$attr = array();
	$attr['menu'] = $atts['menu'];
	 if(!empty($nav)){
		 foreach($nav as $key => $val){
			$attr['menu'] = $nav['menu_name'];
			$attr['menu_class'] = $nav['menu_class'];
			$attr['menu_id'] = $nav['menu_id'];
			$attr['container'] = $nav['container'];
			$attr['container_class'] = $nav['container_class'];
			$attr['container_id'] = $nav['container_id'];
			if(isset($nav['link_wrapper']) && $nav['link_wrapper'] !=''){
				$cls='';
				if(isset($nav['link_wrapper_class']) && $nav['link_wrapper_class'] !='') $cls = ' class="'.$nav['link_wrapper_class'].'"';
				$attr['before'] = '<'.$nav['link_wrapper'].$cls.'>';
				$attr['after'] = '</'.$nav['link_wrapper'].'>';
		    }
			if(isset($nav['link_txt_wrapper']) && $nav['link_txt_wrapper'] !=''){
				$wpcls='';
				if(isset($nav['link_txt_wrapper_class']) && $nav['link_txt_wrapper_class'] !='') $wpcls = ' class="'.$nav['link_txt_wrapper_class'].'"';
				$attr['link_before'] =  '<'.$nav['link_txt_wrapper'].$wpcls.'>';
				$attr['link_after'] = '</'.$nav['link_txt_wrapper'].'>';
			}
		 }
	  }

    return add_custom_page_theme_nav( $attr );
}


function add_custom_page_theme_nav( $atts ) {
	$a = shortcode_atts( array(
		'menu'	=>	'',
		'menu_class'	=>	'',
		'menu_id'	=>	'',
		'container'	=>	'',
		'container_class'	=>	'',
		'container_id'	=>	'',
		'fallback_cb'	=>	'',
		'before'	=>	'',
		'after'	=>	'',
		'link_before'	=>	'',
		'link_after'	=>	'',
		'echo'	=>	'',
		'depth'	=>	'0',
		'theme_location' => '',
		'walker'	=>	'',
		'items_wrap'	=>	'',
		'item_spacing'	=>	'',
	), $atts );
	$nav = array();
	foreach($a as $key => $value){
		if('' != $value) $nav[$key] =  $value;
	}
    return wp_nav_menu( $nav );
}

add_shortcode( 'custom_page_theme_nav', 'init_custom_page_theme_nav' );

function add_custom_page_theme_widget( $atts, $content = null, $type ) {
	$a = shortcode_atts( array(
		'applytitle' =>	null,
		'classname' => null,
		'title'	=>	null,
		'slug'	=>	null,
		'container'	=>	'',
		'container_class'	=>	'',
		'container_id'	=>	'',
		'applycomments' =>null,
		'comment'	=>	'',
		'commentarea_class'	=>	'',
		'commentarea_id'	=>	'',
		'count'	=>	null,
		'dropdown'	=>	null,
		'hierarchical'	=>	null,
		'category'	=>	null,
		'description'	=>	null,
		'rating'	=>	null,
		'images'	=>	null,
		'name'	=>	null,
		'sortby'	=>	null,
		'exclude'	=>	null,
		'number'	=>	null,
		'url'	=>	null,
		'items' => null,
		'show_summary'	=>	null,
		'show_author'	=>	null,
		'show_date'	=>	null,
		'taxonomy'	=>	null,
		'text'	=>	null,
		'filter'	=>	null,
		'html'	=>	null,
		'cust_args'	=>	null,
		'address'	=>	null,
		'key'	=>	null,
		'width'	=>	null,
		'height'	=>	null,
		'zoom'	=>	null,
		'type'	=>	null
	), $atts );
	$nav = array();
	
	switch($type){
		case 'archives':
			$class = 'WP_Widget_Archives';
		break;
		case 'calendar':
			$class = 'WP_Widget_Calendar';
		break;
		case 'categories':
			$class = 'WP_Widget_Categories';
		break;
		case 'links':
			$class = 'WP_Widget_Links';
		break;
		case 'meta':
			$class = 'WP_Widget_Meta';
		break;
		case 'pages':
			$class = 'WP_Widget_Pages';
		break;
		case 'resent_comments':
			$class = 'WP_Widget_Recent_Comments';
		break;
		case 'recent_posts':
			$class = 'WP_Widget_Recent_Posts';
		break;
		case 'rss':
			$class = 'WP_Widget_RSS';
		break;
		case 'search':
			$class = 'WP_Widget_Search';
		break;
		case 'tag_cloud':
			$class = 'WP_Widget_Tag_Cloud';
		break;
		case 'text':
			$class = 'WP_Widget_Text';
		break;
		case 'googlemap':
			$class = 'CPT_Widget_Googlemap';
		break;
		case 'google_chart':
			$class = 'google_chart';
		break;
		case 'google_doc':
			$class = 'google_doc';
		break;
		case 'banner':
			$class = 'CPT_Widget_Banner';
		break;
		case 'page_content':		
			include( CSTM_PAGE_THEME_PATH . 'classes/widgets/cstmpt_pagecontent.php' );
			$class = 'CPT_Page_Content';
			register_widget( 'CPT_Page_Content' );
		break;
	}
	$instance = $args = array();
	foreach($a as $key => $value){
		if(null != $value) $instance[$key] =  $value;
	}
    return the_widget( $class, $instance, $args );
}


add_shortcode( 'custom_page_theme_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_archives_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_calendar_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_categories_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_links_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_meta_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_pages_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_resent_comments_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_recent_posts_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_rss_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_search_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_tag_cloud_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_text_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_googlemap_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_google_chart_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_google_doc_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_banner_widget', 'custom_page_theme_widget_func' );
add_shortcode( 'custom_page_theme_page_content_widget', 'custom_page_theme_widget_func' );




function custom_page_theme_widget_func( $atts, $content = null, $tag ) {
	global $wpdb;
	$attr = array();
	//extract the widget type from $tag parameter by removing prefix & postfixs from $tag strig
	$type = preg_replace('/^' . preg_quote('custom_page_theme_', '/') . '/', '', preg_replace('/_widget$/', '', $tag));
	switch($type){
		case 'page_content':
			if (!empty( $atts ) && array_key_exists("template",$atts)){
				$row = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = '_cpt_pg_content_template_".$atts['template']."' ");
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
			} 
		break;
	}	
	return add_custom_page_theme_widget( $attr, $content, $type );
}


/* Register and load all the custom widgets */
function CPT_load_widget() { 
	register_widget( 'CPT_Page_Content' );
}
//add_action( 'widgets_init', 'CPT_load_widget' );


/**
 * Enqueue scripts and styles.
 */
${$cpt_themename."_scripts"} = function() {
	global $cpt_themename;
    // Load our main stylesheet.
	wp_enqueue_style( 'cpt-style', get_stylesheet_uri() );

	//enque js files into theme
	$js = get_option( "_".$cpt_themename."_js" );
	if($js ){
		$jslst = unserialize($js);
		foreach($jslst as $key => $value){
			wp_enqueue_script( $key, get_template_directory_uri() . '/js/'.$value, array(), '', true );
		}
	}	

	//enque css files into theme
	$css = get_option( "_".$cpt_themename."_css" );
	if($css ){
		$csslst = unserialize($css);
		foreach($csslst as $key => $value){
			wp_enqueue_style( $key, get_template_directory_uri() . '/css/'.$value );
		}
	}	
};

add_action( 'wp_enqueue_scripts', ${$cpt_themename."_scripts"} );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function theme_setup() {
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'custom'    => __( 'User Defined Locations', $cpt_themename )
	) );
}
add_action( 'after_setup_theme', 'theme_setup' );