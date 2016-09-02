<?php
/**
 * Template for displaying pages
 * 
 * @package bootstrap-basic
 */

/**
* Disallow grandchldren pages for this site. They have too little imformation to be useful
* These posts will be displayed in the parent.
*/
global $wp_query;
$object = $wp_query->get_queried_object();
$parent_id  = $object->post_parent;
$depth = 0;
while ($parent_id > 0) {
	$p = get_page($parent_id);
	$parent_id = $p->post_parent;
	$depth++;
}
if ($depth >= 2) {
	header('Location: ' . get_permalink($object->post_parent));
}
get_header();

/**
 * determine main column size from actived sidebar
 */
$main_column_size = 12;
$map_embed = false; 
$form_embed = false;
$treatment_class = "treatment";
$treatment_width = "col-md-4";
$modulus = 3; ?> 
<?php get_sidebar('left'); ?>
<?php if (have_posts()): while (have_posts()): ?>
	<?php global $post; ?>
	<main id="main" class="site-main" role="main">
		<?php $parents = get_post_ancestors($post); 
		$p_c = count($parents) - 1;
		$parent_id = ($parents) ? $parents[$p_c] : $post->ID;
		$nrc_link = (get_post_meta($post->ID, 'natural_remedy_link', true)) ? get_post_meta($post->ID, 'natural_remedy_link', true) : '';
		$contact_addr = (get_post_meta($post->ID, 'contact_address', true)) ? get_post_meta($post->ID, 'contact_address', true) : '';
		$buy_txt = __('Purchase ', 'portchris') . $post->post_title . __(' Online', 'portchris'); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-<?php echo $main_column_size; ?> content-area" id="main-column">
					<?php $metas = get_post_meta(get_the_ID());
					$feature_img = (has_post_thumbnail()) ? true : false;
					$col_class = ($feature_img) ? "col-sm-6" : "col-sm-12";
					foreach ($metas as $name => $meta) {
						if ($name === "map_embed" && !empty($meta) && isset($meta[0]) && strtolower($meta[0]) == "true") {
							$map_embed = true;
							$col_class = "col-sm-6";
						}
						if ($name === "form_embed" && !empty($meta) && isset($meta[0]) && strtolower($meta[0]) == "true") {
							$form_embed = true;
						}
					} ?>
					<div class="col-sm-12">
						<h2 class="page-title"><?php the_title(); ?></h2>
						<hr/>
					</div>
					<div class="<?php echo $col_class ?>">
						<?php the_post();
						get_template_part('content', 'page'); 
						if (strlen($nrc_link) > 0): ?>
							<div class="buy-treatment">
								<h3><?php echo $buy_txt ?></h3>
								<a role="button" target="_blank" class="btn btn-lg btn-default" href="<?php echo $nrc_link ?>" title="<?php echo $buy_txt . __(' (Opens www.naturalremedy.company in new tab)', 'portchris') ?>" onclick="ga('send', 'event', 'Button', 'Click', 'Buy Online', 10);">
									<?php _e('Buy Online', 'portchris') ?>
								</a>
							</div>
						<?php endif; ?>
					</div>
					<?php if ($feature_img === true): ?>
						<div class="col-sm-4 col-sm-offset-2">
							<div class="feature-img">
								<?php the_post_thumbnail(); ?>
							</div>
						</div>
					<?php elseif ($map_embed === true): ?>
						<div class="col-sm-6">
							<?php if (strlen($contact_addr) > 0): ?>
								<div class="entry-content row-with-vspace">
									<h2><?php _e('Salon Address', 'portchris') ?></h2>
									<p><?php echo $contact_addr; ?></p>
								</div>
							<?php endif; ?>
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
		<div class="row">
			<?php if ($parent_id != $post->ID): ?>
				<?php $treatment_width = "col-md-12";
				$modulus = 1;
				$treatment_class = "sub-treatment pull-left"; ?>
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
							<?php $nrc_link = (get_post_meta($page->ID, 'natural_remedy_link', true)) ? get_post_meta($page->ID, 'natural_remedy_link', true) : '';
							$has_buy_btn = (strlen($nrc_link) > 0) ? true : false;
							if ($i !== 0 && $i % $modulus === 0): ?>
								</div><!-- .row -->
								<div class="row no-margin">
							<?php endif; ?>
							<div class="<?php echo $treatment_width ?>">
								<div class="<?php echo $treatment_class ?>">
									<?php if ($parent_id !== $post->ID): ?>
										<i class="fa fa-bookmark" aria-hidden="true"></i>
									<?php endif; ?>
									<?php $attr = array(
										'class'	=> "img-responsive",
										'alt'	=> trim(strip_tags($page->post_excerpt)),
										'title'	=> trim(strip_tags($page->post_title)),
									);
									$has_img = false;
									$image_id = get_post_thumbnail_id($page->ID);
									$image_attributes = wp_get_attachment_image_src($image_id, 'full');
									if (!empty($image_attributes) && isset($image_attributes[0])) : ?>
										<?php $has_img = true; ?>
										<div class="img-container<?php echo ($parent_id !== $post->ID) ? ' col-md-2' : '' ?>">
											<a href=" <?php echo get_page_link($page->ID) ?>" title=" <?php echo $page->post_title ?>">
												<img class="img-responsive" src="<?php echo $image_attributes[0]; ?>" width="100%" alt="<?php echo $page->post_title ?>"/>
											</a>
										</div>
									<?php endif; ?>
									<?php $treatment_desc_class = "treatment-desc";
									if ($has_buy_btn && $parent_id !== $post->ID) {
										if ($has_img) {
											$treatment_desc_class .= ' has-img has-buy-btn col-md-7';
										} else {
											$treatment_desc_class .= ' has-buy-btn col-md-9';
										}
									} else if ($parent_id !== $post->ID) {
										$treatment_desc_class .= ' col-md-9';
									} ?>
									<div class="<?php echo $treatment_desc_class ?>">
										<div class="treatment-title"><?php echo $page->post_title ?></div>
										<?php if ($parent_id === $post->ID) {
											/****************************
											* This is a page is a parent
											* allow depths up to 1
											*****************************/
											$in = $page->post_content; 
											$out = strlen($in) > 200 ? substr($in, 0, 175)."..." : $in;
											echo "<p>".$out."</p>";
											echo '<a role="button" class="btn" href="'.get_page_link($page->ID).'" title="'.$page->post_title.'">' . __('View treatment', 'portchris') . '</a>';
										} else {
											/**********************************
											* This is a page with a parent, to
											* avoid complicated page structure,
											* disallow further breadcrumbs
											***********************************/
											echo "<p>".$page->post_content."</p>";
										} ?>
									</div><!-- .treatment-desc -->
									<?php if ($parent_id !== $post->ID): ?>
										<div class="buy-treatment col-md-3 pull-right text-right">
											<a role="button" class="btn btn-lg row-with-vspace" href="#enquire-within" title="<?php _e('Contact us now by filling in the form below or calling us', 'portchris') ?>" onclick="ga('send', 'event', 'Button', 'Click', 'Make an enquiry', 10);">
												<i class="fa fa-phone" aria-hidden="true"></i>
												<?php _e('Make an enquiry', 'portchris') ?>
											</a>
											<?php if (strlen($nrc_link) > 0 && $parent_id !== $post->ID): ?>
												<a role="button" target="_blank" class="btn btn-lg btn-default" href="<?php echo $nrc_link ?>" title="<?php echo $buy_txt . __(' (Opens www.naturalremedy.company in new tab)', 'portchris') ?>" onclick="ga('send', 'event', 'Button', 'Click', 'Purchase Online', 10);">
													<i class="fa fa-shopping-cart" aria-hidden="true"></i>
													<?php _e('Purchase online', 'portchris') ?>
												</a>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div><!-- .treatment -->
							</div>
						<?php $i++; endforeach; ?>
					</div><!-- .row -->
				</div> <!-- #treatments -->
			<?php endif; ?>
			<?php if ($form_embed === true) : ?>
				<div class="col-md-12">
						<h2>Make an enquiry today</h2>
						<hr/>
					</div>
				<div id="enquire-within" class="col-md-12">
					<?php echo do_shortcode('[contact-form-7 id="156" title="Enquire within"]'); ?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
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
<?php endwhile; endif; ?>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?> 