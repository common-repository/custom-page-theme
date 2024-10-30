<?php
class CPT_Page_Content extends WP_Widget { 

	function __construct() {
		parent::__construct(
			// Base ID of widget
			'CPT_Page_Content', 

			// Widget name to appear in UI
			__($instance['template_name'], 'CPT_Page_Content_domain'), 

			// Widget description
			array( 'description' => __( $instance['template_description'], 'CPT_Page_Content_domain' ), ) 
		);
	}

	// Front-end markup for widget 
	public function widget( $args, $instance ) {
		$applytitle = apply_filters( 'applytitle', isset($instance['applytitle']) ? $instance['applytitle']: true );
		$applycomments = apply_filters( 'applycomments', isset($instance['applycomments']) ? $instance['applycomments']: true );
		$contenttitle = isset($instance['content_title']) ? $instance['content_title']: "cpt_content_title";
		
		echo $args['before_widget'];

		$container = isset($instance['container']) ? $instance['container']: "div";
		$containerId = isset($instance['container_id']) ? $instance['container_id']: "id_cpt_content_area";
		$containerClass = isset($instance['container_class']) ? $instance['container_class']: "class_cpt_container_area";
		echo '<'.$container.' id="'.$containerId.'" class="'.$containerClass.'">';
		//Add Comments and comment form if comments is required
		if($applytitle)	the_title( '<h1 class="'.$contenttitle.'">', '</h1>' );

		if ( have_posts() ) : while ( have_posts() ) : the_post();
			
			//The content of Post
			the_content();

			/*
			 * Add Comments and comment form if comments is required. Also If the current post is protected by a password and
			 * the visitor has not yet entered the password then comments should not be visible to user.
			 */
			  if($applycomments){
				$comment = isset($instance['comment']) ? $instance['comment']: "div";
				$commentareaId = isset($instance['commentarea_id']) ? $instance['commentarea_id']: "id_cpt_comment_area";
				$commentareaClass = isset($instance['commentarea_class']) ? $instance['commentarea_class']: "class_cpt_comments_area";
				echo '<'.$comment.' id="'.$commentareaId.'" class="'.$commentareaClass.'">'; 
					
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				comment_form();
				echo '</'.$comment.'>';
			  }
			// End the loop.
		endwhile; else:
			echo '<p>Sorry, no posts matched your criteria.</p>';
		endif;
			echo '</'.$container.'>';

		echo $args['after_widget'];
	}

	// HTML template of widget for Admin Panel
	public function admin_html( $args, $instance ) {
		$applytitle = apply_filters( 'applytitle', isset($instance['applytitle']) ? $instance['applytitle']: true );
		$applycomments = apply_filters( 'applycomments', isset($instance['applycomments']) ? $instance['applycomments']: true );
		$contenttitle = isset($instance['content_title']) ? $instance['content_title']: "cpt_content_title";
		
		echo $args['before_widget'];

		$container = isset($instance['container']) ? $instance['container']: "div";
		$containerId = isset($instance['container_id']) ? $instance['container_id']: "id_cpt_content_area";
		$containerClass = isset($instance['container_class']) ? $instance['container_class']: "class_cpt_container_area";
		echo '<'.$container.' id="'.$containerId.'" class="'.$containerClass.'">';
		//Add Comments and comment form if comments is required
		if($applytitle)	echo '<h1 class="'.$contenttitle.'">What is Lorem Ipsum?</h1>' ;

			echo "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p><p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>";
			/*
			 * Add Comments and comment form if comments is required. Also If the current post is protected by a password and
			 * the visitor has not yet entered the password then comments should not be visible to user.
			 */
			  if($applycomments){
				$comment = isset($instance['comment']) ? $instance['comment']: "div";
				$commentareaId = isset($instance['commentarea_id']) ? $instance['commentarea_id']: "id_cpt_comment_area";
				$commentareaClass = isset($instance['commentarea_class']) ? $instance['commentarea_class']: "class_cpt_comments_area";
				echo '<'.$comment.' id="'.$commentareaId.'" class="'.$commentareaClass.'">'; 
					
				// If comments are open or we have at least one comment, load up the comment template.
				echo "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>";

				comment_form();
				echo '</'.$comment.'>';
			  }
			// End the loop.
	
			echo '</'.$container.'>';

		echo $args['after_widget'];
	}


}	// Class CPT_Page_Content ends here