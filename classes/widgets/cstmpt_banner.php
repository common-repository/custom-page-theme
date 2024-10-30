<?php
/* Register Banner widget */
class CPT_Widget_Banner extends WP_Widget { 

	private $banner = '';

	function __construct() {
		parent::__construct(
			// Base ID of widget
			'CPT_Widget_Banner', 

			// Widget name to appear in UI
			__('Banner Widget', 'CPT_Widget_Banner_domain'), 

			// Widget description
			array( 'description' => __( 'CPT Banner widget', 'CPT_Widget_Banner_domain' ), ) 
		);
		add_action( 'wp_enqueue_scripts', array( $this, 'jquery_lib_js' ) );
		$this->banner = '<slider><slide><image>'.get_template_directory_uri().'/screenshot.png</image><heading>Custom Page Theme Banner slide1</heading><text>text for slide1</text><link></link></slide><slide><image>'.get_template_directory_uri().'/screenshot.png</image><heading>Custom Page Theme Banner slide2</heading><text>text for slide2</text><link></link></slide></slider>';
	}

	/* Enqueue jQuery min library script */
	function jquery_lib_js() {
		// wp_enqueue_style( 'banner-style', get_template_directory_uri() . '/css/banner.css' );
	}

	

	function portraybanner($banner, $bannerId, $w, $h){ 
		$w = '100%';
		$html = '<div id="'.$bannerId.'" style="width:'.$w.';height:'.$h.';"><div class="slider"><div class="container"><div class="slidewrapper">';
		foreach($banner as $k => $v){
			$html .= '<div class="slide" style="z-index:20;">';
            $html .= '<img src="'.$v->image.'" />';
            $html .= '<div class="slidetext">';
            $html .= '<h2>'.$v->heading.'</h2>';
            $html .= '<p>'.$v->text.'</p>';
            if('' !=$v->link)$html .= '<a class="button" href="'.$v->link.'">Learn More</a>';
            $html .= '</div>';
            $html .= '</div>';
		}
		$html .= '</div></div></div></div>';
		echo $html;
		echo '<script type="text/javascript">';
		echo 'var currentSlide = 0;';
		echo 'var totalSlide = jQuery(".slide").length - 1;';
		echo 'jQuery(document).ready(function(){';
		echo 'jQuery.fn.timer = function() { ';
		echo 'if(currentSlide < totalSlide){ ';
		echo 'currentSlide = currentSlide + 1 ; ';
		echo 'jQuery(".slide").eq(currentSlide).animate({ opacity: 1}, 200) ; ';
		echo 'jQuery(".slide").eq(currentSlide).css({ "z-index": 10}) ; ';
		echo 'jQuery(".slide").eq(currentSlide).siblings().animate({ opacity: 0}, 200) ; ';
		echo 'jQuery(".slide").eq(currentSlide).siblings().css({ "z-index": 0}) ; ';
		echo 'jQuery("ul.slide_nav li").eq(currentSlide).siblings().children("a").css({ "background":"none"}) ; ';
		echo '} else{ ';
		echo 'currentSlide = 0 ; ';
		echo 'jQuery(".slide").eq(currentSlide).animate({ opacity: 1}, 200) ; ';
		echo 'jQuery(".slide").eq(currentSlide).css({ "z-index": 10}) ; ';
		echo 'jQuery(".slide").eq(currentSlide).siblings().animate({ opacity: 0}, 200) ; ';
		echo 'jQuery(".slide").eq(currentSlide).siblings().css({ "z-index": 0}) ; ';
		echo 'jQuery("ul.slide_nav li").eq(currentSlide).siblings().children("a").css({ "background":"none"}) ; ';
		echo '} ';
		echo '} ';
		echo '}); ';
		echo 'window.setInterval(function() { jQuery("#example").timer() ; }, 4000) ; ';
		echo '</script>';
	}


	// Front-end markup for widget 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		$this->banner = isset($args['banner']) ? $args['banner'] : $this->banner;
		$bannererXMLData = "<?xml version='1.0' encoding='UTF-8'?>".$this->banner;
		$banner=simplexml_load_string($bannererXMLData) or die("Error: Cannot create object");
		///echo "<pre>"; print_r($xml);echo "</pre>"; 

		echo $args['before_widget'];
		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		if($banner){
			$bannerId = "cpt_".time()."_banner";
			$w = $h = '200px';
			$w = isset($instance['width']) ? $instance['width'] : $w;
			$h = isset($instance['height']) ? $instance['height'] : $h;				
			$this->portraybanner($banner, $bannerId, $w, $h);
		}
		echo $args['after_widget'];
	}

}	// Class CPT_Widget_Banner ends here

