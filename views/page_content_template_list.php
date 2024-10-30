<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * CustomPageTheme_PageContentTemplatesList.
 *
 * @author      Jeetendra
 * @category    Admin
 * @package     CSTM_PAGE_THEME/Views
 * @version     1.0.3
 */
class CustomPageTheme_PageContentTemplatesList extends WP_List_Table {

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
			'singular'  => __( 'Page Content Template', 'custom-page-theme' ),
			'plural'    => __( 'Page Content Templates', 'custom-page-theme' ),
			'ajax'      => false
		) );
	}

	/**
	 * No items found text.
	 */
	public function no_items() {
		_e( 'No content template found.', 'custom-page-theme' );
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
		if(isset($_GET['action'] ) && $_GET['action'] == 'edit' &&  isset($_GET['template']) && $_GET['template']  != null ){  
			$template = $_GET['template'] ;
			$url = admin_url('admin.php?page=cstm-page-theme-page-content-update');
			 if ( wp_redirect( $url ) ) {
				exit;
			}
		} else if(isset($_GET['action'] ) && $_GET['action'] == 'delete' &&  isset($_GET['id']) && $_GET['id']  != null ){  
			$this->delete_selected_template($_GET); 
			$url = admin_url("admin.php?page=cstm-page-theme-page-content");
			echo '<script>window.location.replace("'.$url.'");</script>';
		} else { 
			$this->prepare_items();       ?>
			<div class="wrap">        
				<div id="icon-users" class="icon32"><br/></div>
				<h2>All Page Content Templates<a href="<?php echo admin_url('admin.php?page=cstm-page-theme-page-content-update');  ?>" class="add-new-h2">Add New</a></h2> 
				<form id="plugins-filter" method="get">        
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />          
					<?php $this->display() ?>
				</form>        
			</div>
			<?php
		}    
	}

	function delete_selected_template($get) {
		global $wpdb;
		$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_id =".$get['id']);
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
			'name'		   => __( 'Theme Name', 'custom-page-theme' ),
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
		$edit_url = admin_url("admin.php?page=cstm-page-theme-page-content-update&amp;action=edit&amp;template=%s");
		$delete_url = admin_url("admin.php?page=cstm-page-theme-page-content&amp;action=delete&amp;id=%d");
			/*esc_url( wp_nonce_url( add_query_arg( array( 'action' => 'delete', 'menu' => $item['id'] ), admin_url( 'nav-menus.php' ) ), 'delete-nav_menu-' . $item['id']) );*/
       $actions = array(
			'edit'    => sprintf('<a href="'.$edit_url.'">Edit</a>',$item['slug']),
            'delete'    => sprintf('<a href="'.$delete_url.'">Delete</a>',$item['id']),
        );
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

	function countTemplates(){
		global $wpdb;
		$rows = $wpdb->get_results( "SELECT option_id FROM $wpdb->options WHERE option_name LIKE '_cpt_pg_content_template_%' ");
		$i = 0;
		foreach ( $rows as $row ) {$i++;}
		return $i;
	}

	private function table_data()
    {
		global $wpdb;
		$rows = $wpdb->get_results( "SELECT * FROM $wpdb->options WHERE option_name LIKE '_cpt_pg_content_template_%' ");
		 $data = array();
		foreach ( $rows as $row ) { 
			$rw = unserialize(unserialize($row->option_value));
			$data[] = array(
				'id'   => $row->option_id,
				'name' => $rw['template_name'],
				'slug' => $rw['template_slug'],
				'shortcode' => '<textarea readonly class="shrtcd" title="Copy shortcode and paste it to Page Content location">[custom_page_theme_page_content_widget template="'.$rw['template_slug'].'"]</textarea>',
				'shortcodephp' => '<textarea readonly class="shrtcd" title="Copy shortcode and paste it in any *.php (Like: index.php) file at Page Content location"><?php echo do_shortcode("[custom_page_theme_page_content_widget template=\"'.$rw['template_slug'].'\"]"); ?></textarea>'

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
		$total_items = $this->countTemplates(); 
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


