<?php
/**
 * Template for displaying pages
 * 
 * @package bootstrap-basic
 */

get_header();

/**
 * determine main column size from actived sidebar
 */
$main_column_size = bootstrapBasicGetMainColumnSize();
$map_embed = FALSE; 
$form_embed = FALSE;
$treatment_class = "treatment";
$treatment_width = "col-md-4";
$modulus = 3;  
?> 
<?php get_sidebar('left'); ?>
<?php while (have_posts()) : ?>
<main id="main" class="site-main row-with-vspace" role="main">
	<?php global $post;
	 $parents = get_post_ancestors($post); 
	 $parent_id = ($parents) ? $parents[count($parents)-1]: $post->ID; ?>
	<div class="container">
		<div class="row">
			<div class="col-md-<?php echo $main_column_size; ?> content-area" id="main-column">
				<?php $metas = get_post_meta(get_the_ID());
				$feature_img = (has_post_thumbnail()) ? TRUE : FALSE;
				$col_class = ($feature_img) ? "col-md-6" : "col-md-12";
				foreach ($metas as $name => $meta) {
					if ($name === "map_embed" && !empty($meta) && isset($meta[0]) && strtolower($meta[0]) == "true") {
						$map_embed = TRUE;
						$col_class = "col-md-6";
					}
					if ($name === "form_embed" && !empty($meta) && isset($meta[0]) && strtolower($meta[0]) == "true") {
						$form_embed = TRUE;
					}
				} ?>
				<div class="col-md-12">
					<h2><?php the_title(); ?></h2>
					<hr/>
				</div>
				<div class="<?php echo $col_class ?>">
					<?php the_post();
					get_template_part('content', 'page'); ?>
				</div>
				<?php if ($feature_img === TRUE): ?>
					<div class="col-md-4 col-md-offset-2">
						<div class="feature-img">
							<?php the_post_thumbnail(); ?>
						</div>
					</div>
				<?php elseif ($map_embed === TRUE): ?>
					<div class="col-md-6">
						<div class="contact-map">
							<iframe width="100%" height="735" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=1%20Parkmead%2C%20Monkton%20Heathfield%2C%20United%20Kingdom&key=AIzaSyAcPLubN5t4uwLfpuHCFfgGQAGAc_vot-Q"></iframe> 
						</div>
					</div>
				<?php endif; ?>
			</div> <!-- #main-column -->
		</div><!-- .row -->
	</div><!-- .container -->
</main>
<div class="container site-body">
	<div class="row row-with-vspace">
		<?php if ($parent_id != $post->ID): ?>
			<?php $treatment_width = "col-md-12";
			$modulus = 1;
			$treatment_class = "sub-treatment"; ?>
			<ul id="breadcrumbs" class="list-inline bs-glyphicons-list">
				  <li>
				  		<?php $title = get_the_title($parent_id); ?>
				  		<a href="<?php echo get_page_link($parent_id) ?>" title ="Head back to <?php echo $title; ?>">
				  			<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				  			<span class="sr-only">&lt;</span>
				  			<strong>&lt;</strong>
				  			Back to <?php echo $title ?>
				  		</a>
				  	</li>
			</ul> 
		<?php endif;
		$args = array(
			'child_of' => $post->ID,
			'parent' => $post->ID,
			'hierarchical' => 0, 
			'sort_column' => "post_title",
			'sort_order' => 'asc'
		); 
		$children = get_pages($args);
		if (!empty($children)) : ?>
			<div class="col-md-12">
				<h2>Available Treatments</h2>
				<hr/>
			</div>
			<div id="treatments" class="col-md-12">
				<div class="row no-margin">
					<?php $i = 0;
					foreach ($children as $page) : ?>
						<?php if ($i !== 0 && $i % $modulus === 0): ?>
							</div><!-- .row -->
							<div class="row no-margin">
						<?php endif; ?>
						<div class="<?php echo $treatment_class . " " . $treatment_width ?>">
							<?php $attr = array(
								'class'	=> "img-responsive",
								'alt'	=> trim( strip_tags( $page->post_excerpt ) ),
								'title'	=> trim( strip_tags( $page->post_title ) ),
							);
							$image_id = get_post_thumbnail_id($page->ID);
							$image_attributes = wp_get_attachment_image_src( $image_id, 'full');
							//$photo = get_the_post_thumbnail($page->ID, array(330, 250), $attr);

							if ($parent_id === $post->ID) {
								echo "<a href='".get_page_link($page->ID)."' title='".$page->post_title."'>";
							}
							if (!empty($image_attributes) && isset($image_attributes[0])) : ?>
								<div class="img-container">
									<?php //echo $photo; ?>
									<img class="img-responsive" src="<?php echo $image_attributes[0]; ?>" width="100%" alt="<?php echo $page->post_title ?>"/>
								</div>
							<?php endif; ?>
							<div class="treatment-desc">
								<div class="treatment-title"><?php echo $page->post_title ?></div>
								<?php if ($parent_id === $post->ID) {
									/****************************
									* This is a page is a parent
									* allow depths up to 1
									*****************************/
									$in = $page->post_content; 
									$out = strlen($in) > 200 ? substr($in,0,200)."..." : $in;
									echo "<p>".$out."</p>";
									echo "</a>";
								} else {
									/**********************************
									* This is a page with a parent, to
									* avoid complicated page structure,
									* disallow further breadcrumbs
									***********************************/
									echo "<p>".$page->post_content."</p>";
								} ?>
							</div><!-- .treatment-desc -->
						</div><!-- .treatment -->
					<?php $i++; endforeach; ?>
				</div><!-- .row -->
			</div> <!-- #treatments -->
		<?php endif; ?>
		<?php if ($form_embed === TRUE) : ?>
			<div class="col-md-12">
					<h2>Make an enquiry today</h2>
					<hr/>
				</div>
			<div id="enquire-within" class="col-md-12">
				<?php echo do_shortcode('[contact-form-7 id="156" title="Enquire within"]'); ?>
				<script type="text/javascript">
					jQuery(document).ready(function()
					{
						var title = "<?php echo htmlspecialchars_decode(the_title()) ?>";
						jQuery("#enquire-within .your-subject input").val(title);
						ga('send', 'event', 'enquiry', 'submit', title);
					});
				</script>
			</div>
		<?php endif; ?>
	</div><!-- row -->
	<?php	
	/*********************
	* User comments Below
	**********************/
	// If comments are open or we have at least one comment, load up the comment template
	if (comments_open() || '0' != get_comments_number()) : ?>
		<div class="row">
			<div class="col-md-12">
				<?php comments_template(); ?>
			</div>
		</div>
	<?php endif; ?>
</div><!-- .container -->
<?php endwhile; ?>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?> 