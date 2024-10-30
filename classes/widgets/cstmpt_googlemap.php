<?php
/* Register Google map widget */
class CPT_Widget_Googlemap extends WP_Widget { 

	function __construct() {
		parent::__construct(
			// Base ID of widget
			'CPT_Widget_Googlemap', 

			// Widget name to appear in UI
			__('Googlemap Widget', 'CPT_Widget_Googlemap_domain'), 

			// Widget description
			array( 'description' => __( 'Google Map widget', 'CPT_Widget_Googlemap_domain' ), ) 
		);
		add_action( 'wp_enqueue_scripts', array( $this, 'google_map_api_js' ) );
	}

	/* Enqueue google map script */
	function google_map_api_js() {
		 wp_enqueue_script('google-maps', '', false);
	}

	function get_geocode($address, $key=''){ 
    // url encode of address
    $address = urlencode($address);
	$key = isset($key) ? '&key='.urlencode($key) : '';
    $url = "";
 
    // get the json response
    $json_resp = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($json_resp, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lat = $resp['results'][0]['geometry']['location']['lat'];
        $lng = $resp['results'][0]['geometry']['location']['lng'];
        $formatted_address = $resp['results'][0]['formatted_address'];
         
        // verify if data is complete
        if($lat && $lng && $formatted_address){
         
            // put the data in the array
            $data_arr = array();            
             
            array_push(
                $data_arr, 
                    $lat, 
                    $lng, 
                    $formatted_address
                );
             
            return $data_arr;
             
        }else{
            return false;
        }
         
    }else{
        return false;
    }
}

	function portraymap($geocode, $canvasId, $zoom = '2', $maptype = 'ROADMAP', $key =''){ 
		$latitude = $geocode[0];
		$longitude = $geocode[1];
		$formatted_address = $geocode[2];
		echo __( '<script type="text/javascript">', 'wpb_widget_domain' );
		echo __( 'function init_map() {', 'wpb_widget_domain' );
		echo __( 'var myOptions = {', 'wpb_widget_domain' );
		echo __( 'zoom: '.$zoom.',', 'wpb_widget_domain' );
		echo __( 'center: new google.maps.LatLng('.$latitude.', '. $longitude.'),', 'wpb_widget_domain' );
		echo __( 'mapTypeId: google.maps.MapTypeId.'.$maptype.'', 'wpb_widget_domain' );
		echo __( '};', 'wpb_widget_domain' );
		echo __( 'map = new google.maps.Map(document.getElementById("'.$canvasId.'"), myOptions);', 'wpb_widget_domain' );
		echo __( 'marker = new google.maps.Marker({', 'wpb_widget_domain' );
		echo __( 'map: map,', 'wpb_widget_domain' );
		echo __( 'position: new google.maps.LatLng('.$latitude.', '. $longitude.')', 'wpb_widget_domain' );
		echo __( '});', 'wpb_widget_domain' );
		echo __( 'infowindow = new google.maps.InfoWindow({', 'wpb_widget_domain' );
		echo __( 'content: "'.$formatted_address.'"', 'wpb_widget_domain' );
		echo __( '});', 'wpb_widget_domain' );
		echo __( 'google.maps.event.addListener(marker, "click", function () {', 'wpb_widget_domain' );
		echo __( 'infowindow.open(map, marker);', 'wpb_widget_domain' );
		echo __( '});', 'wpb_widget_domain' );
		echo __( 'infowindow.open(map, marker);', 'wpb_widget_domain' );
		echo __( '}', 'wpb_widget_domain' );
		echo __( 'google.maps.event.addDomListener(window, "load", init_map);', 'wpb_widget_domain' );
		echo __( '</script>', 'wpb_widget_domain' );
	}


	// Front-end markup for widget 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		$key = '';
		$geocode = $this->get_geocode($instance['address'], $key);
		if($geocode){
			$canvasId = "cpt_".time()."_canvas";
			$w = $h = '200px';
			$z = '2';
			$t = 'ROADMAP';
			$w = isset($instance['width']) ? $instance['width'] : $w;
			$h = isset($instance['height']) ? $instance['height'] : $h;	
			$z = isset($instance['zoom']) ? $instance['zoom'] : $z;
			$t = isset($instance['type']) ? $instance['type'] : $t;
			echo "<div id='$canvasId' style='width:$w;height:$h;'>Loading map...</div>";
			$this->portraymap($geocode, $canvasId, $z, $t, $key);
		}
		echo $args['after_widget'];
	}

}	// Class CPT_Widget_Googlemap ends here