<?php
/**
 * Template Name: Category
 * 
 * @package bootstrap-basic
 */

get_header();

/**
 * determine main column size from actived sidebar
 */
$main_column_size = bootstrapBasicGetMainColumnSize();
$category = get_the_category();
$cat_name = "";
$cat_desc = "";
if (!is_front_page() && is_home()) {
	$category = get_post(get_option('page_for_posts'));
	$cat_name = get_the_title($category->ID);
	$cat_desc = get_the_content($category->ID);
} else {
	$cat_name = single_term_title(__("Category: "), false);
	$cat_desc = term_description($category->term_id);
} ?>
<div class="container">
	<?php if (strlen($cat_name) > 0 || strlen($cat_desc) > 0): ?>
		<div class="row category-info">
			<div class="col-md-12 article">
				<h1 class="entry-title"><?php echo $cat_name?></h1>
				<hr />
				<p><?php echo $cat_desc ?></p>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<?php get_sidebar('left'); ?> 
		<div class="col-md-<?php echo $main_column_size; ?> content-area" id="main-column">
			<main id="main" class="site-main" role="main">
				<?php if (have_posts()) {
					// start the loop
					while (have_posts()) {
						the_post();
						
						/* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part('content', get_post_format());
					}
					bootstrapBasicPagination();
				} else { 
					get_template_part('no-results', 'index');
				} ?> 
			</main>
		</div>
		<?php get_sidebar('right'); ?> 
	</div>
</div>
<?php get_footer(); ?> 