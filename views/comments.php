<?php

if ( post_password_required() )
	return;
?>

<?php if ( have_comments() ) : ?>
	<h2 class="comments_title">
		<?php
		echo get_the_title() ;
		?>
	</h2>


<ol class="comment_list">
	<?php
		wp_list_comments( array(
			'style'       => 'ol',
			'short_ping'  => true,
			'avatar_size' => 74,
		) );
	?>
</ol><!-- .comment-list -->


<?php endif; // have_comments() ?>
