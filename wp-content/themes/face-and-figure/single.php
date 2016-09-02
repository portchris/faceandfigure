<?php
/**
 * Template for dispalying single post (read full post page).
 * Simple Fields Connector: single_post_connector
 * 
 * @package bootstrap-basic
 */

get_header();

/**
 * determine main column size from actived sidebar
 */
$main_column_size = bootstrapBasicGetMainColumnSize(); ?>
<div id="post-single"> 
	<div class="container">
		<?php get_sidebar('left'); ?> 
		<div class="col-md-<?php echo $main_column_size; ?> content-area" id="main-column">
			<main id="main" class="site-main" role="main">
				<?php 
				while (have_posts()) {
					the_post();
					$post_cta = simple_fields_fieldgroup('post_cta');
					get_template_part('content', get_post_format());
					if (isset($post_cta) && !empty($post_cta)): ?>
						<?php $cta_txt = (isset($post_cta['post_cta_text']) && !empty($post_cta['post_cta_text'])) ? $post_cta['post_cta_title'] : 'View further details' ?>
						<div class="article">
							<?php if (isset($post_cta['post_cta_title']) && !empty($post_cta['post_cta_title'])): ?>
								<h2><?php _e($post_cta['post_cta_title'], 'portchris') ?></h2>
								<hr />
							<?php endif; ?>
							<?php if (isset($post_cta['post_cta_desc']) && !empty($post_cta['post_cta_desc'])): ?>
								<p class="row-with-vspace">
									<?php echo $post_cta['post_cta_desc']; ?>
								</p>
							<?php endif; ?>
							<?php if (isset($post_cta['post_cta_link']) && !empty($post_cta['post_cta_link'])): ?>
								<a role="button" class="btn btn-default" href="<?php echo $post_cta['post_cta_link'] ?>" target="_blank" title="<?php _e($cta_txt, 'portchris'); ?>" onclick="ga('send', 'event', 'Button', 'Click', 'Single Post CTA', 10);"><?php _e($cta_txt, 'portchris'); ?></a>
							<?php endif; ?>
						</div>
					<?php endif;
					echo "\n\n";
					bootstrapBasicPagination();
					echo "\n\n";
					
					// If comments are open or we have at least one comment, load up the comment template
					if (comments_open() || '0' != get_comments_number()) {
						comments_template();
					}
					echo "\n\n";
				} //endwhile;
				?> 
			</main>
		</div>
		<?php get_sidebar('right'); ?> 
	</div>
</div>
<?php get_footer(); ?> 