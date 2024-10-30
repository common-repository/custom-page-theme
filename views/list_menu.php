<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * CustomPageTheme_MenuList.
 *
 * @author      Jeetendra
 * @category    Admin
 * @package     CSTM_PAGE_THEME/Views
 * @version     1.0.3
 */
class CustomPageTheme_MenuList extends WP_List_Table {

	/**
	 * Max items.
	 *
	 * @var int
	 */
	protected $max_items;

	/**
	 * items.
	 *
	 * @var array
	 */
	protected $item_list;

	/**
	 * items.
	 *
	 * @var array
	 */
	protected $curr;

	/**
	 * Constructor.
	 */
	public function __construct(  ) {

		parent::__construct( array(
			'singular'  => __( 'Custom Theme Navigation Menu', 'custom-page-theme' ),
			'plural'    => __( 'Custom Themes  Navigation Menus', 'custom-page-theme' ),
			'ajax'      => false
		) );
	}

	/**
	 * No items found text.
	 */
	public function no_items() {
		_e( 'No navigation menu found.', 'custom-page-theme' );
	}

	/**
	 * Don't need this.
	 *
	 * @param string $position
	 */
	public function display_tablenav( $position ) {

		if ( $position != 'top' ) {
			parent::display_tablenav( $position );
		}
	}

	/**
	 * Arrange views.
	*/
	function get_views(){
		
		 return  array();
	}

	/**
	 * Output the report.
	 */
	function fetch_output(){  
		if(isset($_GET['action'] ) && $_GET['action'] == 'edit' &&  isset($_GET['theme']) && $_GET['theme']  != null ){  
			$theme = $_GET['theme'] ;
			$action = $error = '';
			require_once(ABSPATH.'wp-admin/theme-editor.php');
		} else if(isset($_GET['action'] ) && $_GET['action'] == 'delete' &&  isset($_GET['theme']) && $_GET['theme']  != null ){  
			$theme = $_GET['theme'] ; 
			 $url = site_url('/wp-admin/admin.php?page=cstm-page-theme');
			 if ( wp_redirect( $url ) ) {
				exit;
			}
		} else { 
			$this->prepare_items();       ?>
			<div class="wrap">        
				<div id="icon-users" class="icon32"><br/></div>
				<h2>Navigation Menu Customization & Shortcodes<a href="<?php echo admin_url('nav-menus.php');  ?>" class="add-new-h2">Add New</a></h2> 
				<form id="plugins-filter" method="get">        
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />          
					<?php $this->display() ?>
				</form>        
			</div>
			<?php
		}    
	}

	
	/**
	 * Get column value.
	 *
	 * @param mixed $item
	 * @param string $column_name
	 */
	function column_default( $item, $column_name ) {
	  switch( $column_name ) { 
		case 'name':
		case 'slug':
		case 'shortcode':
		case 'shortcodephp':
        return $item[ $column_name ];
		default:
		  return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
	  }
   }

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	public function get_columns() {

		$columns = array(
			'cb'		   => '<input type="checkbox">',
			'name'		   => __( 'Menu Name', 'custom-page-theme' ),
			'slug'  	   => __( 'Slug', 'custom-page-theme' ),
			'shortcode'	   => __( 'Shortcode', 'custom-page-theme' ),
			'shortcodephp' => __( 'Shortcode PHP', 'custom-page-theme' ),
		);

		return $columns;
	}
	
	function column_cb($item)    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item['folder']
        );
	}
	

	function column_name($item) {
		$actions = array();
		if($item['slug'] != 'cpt-sample-menu'){
			$edit_url = admin_url("nav-menus.php?action=edit&amp;menu=%d");
			$cst_url = admin_url('admin.php?page=cstm-page-theme-menucustomization&amp;menu='.$item['id']);
			$delete_url = esc_url( wp_nonce_url( add_query_arg( array( 'action' => 'delete', 'menu' => $item['id'] ), admin_url( 'nav-menus.php' ) ), 'delete-nav_menu-' . $item['id']) );
		   $actions = array(
				'edit'    => sprintf('<a href="'.$edit_url.'">Edit</a>',$item['id']),
				'customise'=> sprintf('<a href="%s">Customise</a>',$cst_url),
				'delete'    => sprintf('<a href="'.$delete_url.'">Delete</a>'),
			);
		}
	   return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions) ); 
    }
	

	/**
	 * To arrange columns sorting criteria.
	 */
	function get_sortable_columns() {
	  $sortable_columns = array(
		'name'  => array('name',false),
		'slug' => array('slug',false),
	  );
	  return $sortable_columns;
	}

	/**
	 * Bulk action dropdown over the table.
	 */
	function get_bulk_actions() {
	  $actions = array(
		'delete'    => 'Delete'
	  );
	  return $actions;
	}

	function countThemes(){
		$themes = wp_get_themes();
		$i = 0;
		foreach ( $themes as $theme ) {
			if (strpos($theme->get_stylesheet(), 'cstpgthm') !== false) {
				$i++;
			}
		}
		return $i;
	}

	private function table_data()
    {
        $data = array();
		$menus = get_terms('nav_menu');
		foreach ( $menus as $menu ) {
			$data[] = array(
				'id'   => $menu->term_id,
				'name' => $menu->name,
				'slug' => $menu->slug,
				'shortcode' => '<textarea readonly class="shrtcd" title="Copy shortcode and paste it to Menu location">[custom_page_theme_nav menu="'.$menu->slug.'"]</textarea>',
				'shortcodephp' => '<textarea readonly class="shrtcd" title="Copy shortcode and paste it in any *.php (Like: index.php, header.php OR footer.php) file at Menu location"><?php echo do_shortcode("[custom_page_theme_nav menu=\"'.$menu->slug.'\"]"); ?></textarea>'

			);
		}
        return $data;
    }

	/**
	 * Prepare message list items.
	 */
	public function prepare_items() {

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);

		$data = $this->table_data();
		/**
		 * Pagination.
		 */
		$per_page = 10;
		$total_items = $this->countThemes(); 
		$current_page = $this->get_pagenum();
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
		) );

		$this->items = $data; 
	}

	function single_row( $item ) {
		 echo "<tr id='uid-".$item['id']."' class='msgrow'>";
		 echo $this->single_row_columns( $item );
		 echo "</tr>\n";
	}
}

add_action('admin_head', 'cstmpt_admin_custom_styles');

function cstmpt_admin_custom_styles() {
		echo '<style type="text/css">';
		echo '.wp-list-table .column-name { width: 5%; }';
		echo '.wp-list-table .column-slug { width: 5%; }';
		echo '.wp-list-table .column-shortcode { width: 40%; }';
		echo '.wp-list-table .column-shortcodephp { width: 40%; }';
		echo '.wp-list-table .column-action { width: 10%; }';
		echo '</style>';
		
	
}
echo '<style type="text/css">';
		echo '.wp-list-table .column-name { width: 10%; }';
		echo '.wp-list-table .column-slug { width: 10%; }';
		echo '.wp-list-table .column-shortcode { width: 30%; }';
		echo '.wp-list-table .column-shortcodephp { width: 30%; }';
		echo '.wp-list-table .column-action { width: 10%; }';
		echo '</style>';
	echo '<script>';
		echo 'jQuery(document).ready(function() {';
		echo 'jQuery(".shrtcd").on("click", function(e){';
		echo 'jQuery(this).select();';
		echo 'document.execCommand ("copy", false, null);';
		echo '});';
		echo '});';
		echo '</script>';
?>


