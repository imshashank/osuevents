<?php

/**
 * Topic Tag Edit
 *
 * @package supreme
 * @subpackage Theme
 */

get_header(); // Loads the header.php template. ?>

	<?php do_atomic( 'before_content' ); // supreme_before_content ?>
	
	<?php bbp_breadcrumb( array( 'before' => '<div class="breadcrumb">', 'after' => '</div>', 'sep' => '<span class="sep">&raquo</span>' ) ); ?>
	
	<?php do_action( 'bbp_template_notices' ); ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // supreme_open_content ?>

		<div class="hfeed">

			<div id="topic-tag" class="bbp-topic-tag">
				
				<div class="loop-meta">
					<h1 class="loop-title"><?php printf( __( 'Topic Tag: %s', 'bbpress' ), '<span>' . bbp_get_topic_tag_name() . '</span>' ); ?></h1>
					<div class="loop-description">
						<?php bbp_topic_tag_description(); ?>
					</div>
				</div><!-- .loop-meta -->

				<?php do_action( 'bbp_template_before_topic_tag_edit' ); ?>

				<?php bbp_get_template_part( 'bbpress/form', 'topic-tag' ); ?>

				<?php do_action( 'bbp_template_after_topic_tag_edit' ); ?>

			</div><!-- #topic-tag -->
			
		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // supreme_close_content ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // supreme_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>

